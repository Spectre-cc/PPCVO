<?php
  if(isset($_POST['add-client'])){
    //database connectionn
    require('config/config.php');
    require('config/db.php');
  
    //input
    $fName=mysqli_real_escape_string($conn,$_POST['fName']);
    $mName=mysqli_real_escape_string($conn,$_POST['mName']);
    $lName=mysqli_real_escape_string($conn,$_POST['lName']);
    $birthdate=mysqli_real_escape_string($conn,$_POST['birthdate']);
    $sex=mysqli_real_escape_string($conn,$_POST['sex']);
    $barangay=mysqli_real_escape_string($conn,$_POST['barangay']);
    $cNumber=mysqli_real_escape_string($conn,$_POST['cNumber']);
    $email=mysqli_real_escape_string($conn,$_POST['email']);
  
    //check if client already exist
    $query = "SELECT * FROM client WHERE fName=? AND mName=? AND lName=?"; 
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $query)){
      $alertmessage = urlencode("SQL error!");
      header('Location: ../Update-Client-Form.php.php?alertmessage='.$alertmessage);
      exit();
    }
    else{
      mysqli_stmt_bind_param($stmt, "sss", $fName, $mName, $lName);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      if(mysqli_num_rows($result)==1){
        $alertmessage = urlencode("Client already exist!");
        header('Location: ../Update-Client-Form.php.php?alertmessage='.$alertmessage);
        exit();
      }
    }
      
    //insert input into database
    //prepare sql statement before execution
    $query = "INSERT INTO `client`(`fName`,`mName`,`lName`,`birthdate`, `sex`, `barangay`, `cNumber`, `email`) 
    VALUES (?,?,?,?,?,?,?,?)";
    $stmt = mysqli_stmt_init($conn);
  
    if(!mysqli_stmt_prepare($stmt, $query)){
      $alertmessage = urlencode("SQL error!");
      header('Location: ../Add-Client-Form.php?alertmessage='.$alertmessage);
      exit();
    }
    else{
      mysqli_stmt_bind_param($stmt, "ssssssss", $fName, $mName, $lName, $birthdate, $sex, $barangay, $cNumber, $email);
      mysqli_stmt_execute($stmt);
       $alertmessage = urlencode("Client has been added!");
      header('Location: ../View-Client-List.php?alertmessage='.$alertmessage);
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
  }
  else{
    $alertmessage = urlencode("Invalid link! Logging out...");
    header('Location: logout.php?alertmessage='.$alertmessage);
    exit();
  }
?>