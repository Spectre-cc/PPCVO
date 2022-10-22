<?php
  if(isset($_POST['update-client'])){
    //database connection
    require('config/config.php');
    require('config/db.php');

    //input
    $clientid=mysqli_real_escape_string($conn,$_POST['clientid']);
    $name=mysqli_real_escape_string($conn,$_POST['name']);
    $birthdate=mysqli_real_escape_string($conn,$_POST['birthdate']);
    $sex=mysqli_real_escape_string($conn,$_POST['sex']);
    $barangay=mysqli_real_escape_string($conn,$_POST['barangay']);
    $contactnumber=mysqli_real_escape_string($conn,$_POST['contactnumber']);
    $email=mysqli_real_escape_string($conn,$_POST['email']);

    //check if client already exist
    $query = "SELECT * FROM client WHERE name=? AND NOT clientID=?"; 
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $query)){
      $alertmessage = urlencode("SQL error!");
      header('Location: ../View-Client-List.php?alertmessage='.$alertmessage);
      exit();
    }
    else{
      mysqli_stmt_bind_param($stmt, "si", $name, $clientid);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      if(mysqli_num_rows($result)==1){
        $alertmessage = urlencode("Client already exist!");
        header('Location: ../View-Client-List.php?alertmessage='.$alertmessage);
        exit();
      }
    }

    //prepare sql statement before execution
    $query = "UPDATE `client` SET name=?, birthdate=?, sex=?, barangay=?, contactNumber=?, email=? WHERE clientID=?;";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt, $query)){
      $alertmessage = urlencode("SQL error!");
      header('Location: ../View-Client-List.php?alertmessage='.$alertmessage);
      exit();
    }
    else{

      mysqli_stmt_bind_param($stmt, "ssssssi", $name, $birthdate, $sex, $barangay, $contactnumber, $email, $clientid);
      mysqli_stmt_execute($stmt);
      $alertmessage = urlencode("User has been updated!");
      header('Location: ../View-Client-List.php?alertmessage='.$alertmessage);
      exit();
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
  }
  else{
    header('Location: ../Index.php');
    exit();
  }
?>