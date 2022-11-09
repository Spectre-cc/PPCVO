<?php
  if(isset($_POST['update-client'])){
    //database connection
    require('config/config.php');
    require('config/db.php');

    //input
    $clientID=mysqli_real_escape_string($conn,$_POST['clientID']);
    $fName=mysqli_real_escape_string($conn,$_POST['fName']);
    $mName=mysqli_real_escape_string($conn,$_POST['mName']);
    $lName=mysqli_real_escape_string($conn,$_POST['lName']);
    $birthdate=mysqli_real_escape_string($conn,$_POST['birthdate']);
    $sex=mysqli_real_escape_string($conn,$_POST['sex']);
    $barangay=mysqli_real_escape_string($conn,$_POST['barangay']);
    $cNumber=mysqli_real_escape_string($conn,$_POST['cNumber']);
    $email=mysqli_real_escape_string($conn,$_POST['email']);

    //check if client already exist
    $query = "SELECT * FROM client WHERE fName=? AND mName=? AND lName=? AND NOT clientID=?"; 
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $query)){
      $alertmessage = urlencode("SQL error!");
      header('Location: ../Update-Client-Form.php.php?alertmessage='.$alertmessage);
      exit();
    }
    else{
      mysqli_stmt_bind_param($stmt, "sssi", $fName, $mName, $lName, $clientID);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      if(mysqli_num_rows($result)==1){
        $alertmessage = urlencode("Client already exist!");
        header('Location: ../Update-Client-Form.php?alertmessage='.$alertmessage.'&clientid='.$clientID);
        exit();
      }
    }

    //prepare sql statement before execution
    $query = "UPDATE `client` SET fName=?, mName=?, lName=?, birthdate=?, sex=?, barangay=?, cNumber=?, email=? WHERE clientID=?;";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt, $query)){
      $alertmessage = urlencode("SQL error!");
      header('Location: ../Update-Client-Form.php?alertmessage='.$alertmessage);
      exit();
    }
    else{
      mysqli_stmt_bind_param($stmt, "ssssssssi", $fName, $mName, $lName, $birthdate, $sex, $barangay, $cNumber, $email, $clientID);
      mysqli_stmt_execute($stmt);
      $alertmessage = urlencode("Client record has been updated!");
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