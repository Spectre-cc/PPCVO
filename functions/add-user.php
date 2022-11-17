<?php
  if(isset($_POST['add-user'])){
    //database connectionn
    require('config/config.php');
    require('config/db.php');

    //input
    $fName=mysqli_real_escape_string($conn,$_POST['fName']);
    $mName=mysqli_real_escape_string($conn,$_POST['lName']);
    $lName=mysqli_real_escape_string($conn,$_POST['mName']);
    $email=mysqli_real_escape_string($conn,$_POST['email']);
    $password=mysqli_real_escape_string($conn,$_POST['password']);
    $type=mysqli_real_escape_string($conn,$_POST['type']);
    $cNumber=mysqli_real_escape_string($conn,$_POST['cNumber']);
    session_start();
    $_SESSION["alert"]=true;

    //check if email is already used
    $query = "SELECT * FROM user WHERE email=? AND type=?"; 
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $query)){
      $alertmessage = urlencode("SQL error!");
      if($type=="personnel" || $type=="admin"){
        header('Location: ../View-Users.php?alertmessage='.$alertmessage.'&type='.$type);
        exit();
      }
      else{
        $alertmessage = urlencode("Invalid link! Logging out...");
        header('Location: logout.php?alertmessage='.$alertmessage);
        exit();
      }
    }
    else{
      mysqli_stmt_bind_param($stmt, "ss", $email, $type);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      if(mysqli_num_rows($result)==1){
        $alertmessage = urlencode("Email is already used!");
        if($type=="personnel" || $type=="admin"){
          header('Location: ../View-Users.php?alertmessage='.$alertmessage.'&type='.$type);
          exit();
        }
        else{
          $alertmessage = urlencode("Invalid link! Logging out...");
          header('Location: logout.php?alertmessage='.$alertmessage);
          exit();
        }
      }
    }
    
    //insert input into database
    //prepare sql statement before execution
    $query = "INSERT INTO `user`(`type`,`fName`, `mName`, `lName`, `email`, `password`, `cNumber`) 
    VALUES (?,?,?,?,?,?,?)";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt, $query)){
        $alertmessage = urlencode("SQL error!");
        if($type=="personnel" || $type=="admin"){
          header('Location: ../View-Users.php?alertmessage='.$alertmessage.'&type='.$type);
          exit();
        }
        else{
          $alertmessage = urlencode("Invalid link! Logging out...");
          header('Location: logout.php?alertmessage='.$alertmessage);
          exit();
        }
    }
    else{

        //hash password before insert
        $hashedpassword = password_hash($password, PASSWORD_DEFAULT);

        mysqli_stmt_bind_param($stmt, "sssssss", $type, $fName, $mName, $lName, $email, $hashedpassword, $cNumber);
        mysqli_stmt_execute($stmt);
        $alertmessage = urlencode("User has been added!");
        if($type=="personnel" || $type=="admin"){
          header('Location: ../View-Users.php?alertmessage='.$alertmessage.'&type='.$type);
          exit();
        }
        else{
          $alertmessage = urlencode("Invalid link! Logging out...");
          header('Location: logout.php?alertmessage='.$alertmessage);
          exit();
        }
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