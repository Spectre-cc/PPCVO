<?php
  if(isset($_POST['add-user'])){
    //database connectionn
    require('config/config.php');
    require('config/db.php');

    //input
    $name=mysqli_real_escape_string($conn,$_POST['name']);
    $email=mysqli_real_escape_string($conn,$_POST['email']);
    $password=mysqli_real_escape_string($conn,$_POST['password']);
    $type=mysqli_real_escape_string($conn,$_POST['type']);
    $contactnumber=mysqli_real_escape_string($conn,$_POST['contactnumber']);

    //check if email is already used
    $query = "SELECT * FROM user WHERE email=? AND type=?"; 
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $query)){
      $alertmessage = urlencode("SQL error!");
      header('Location: ../Add-User.php?alertmessage='.$alertmessage.'&type='.$type);
      exit();
    }
    else{
      mysqli_stmt_bind_param($stmt, "ss", $email, $type);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      if(mysqli_num_rows($result)==1){
        $alertmessage = urlencode("Email is already used!");
        header('Location: ../Add-User.php?alertmessage='.$alertmessage.'&type='.$type);
        exit();
      }
    }
    
    //insert input into database
    //prepare sql statement before execution
    $query = "INSERT INTO `user`(`type`,`name`, `email`, `password`, `contactNumber`) 
    VALUES (?,?,?,?,?)";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt, $query)){
        $alertmessage = urlencode("SQL error!");
        header('Location: ../Add-User.php?alertmessage'.$alertmessage);
        exit();
    }
    else{

        //hash password before insert
        $hashedpassword = password_hash($password, PASSWORD_DEFAULT);

        mysqli_stmt_bind_param($stmt, "sssss", $type, $name, $email, $hashedpassword, $contactnumber);
        mysqli_stmt_execute($stmt);
        $alertmessage = urlencode("User has been added!");
        if($type="personnel"){
          header('Location: ../View-Users-Personnel.php?alertmessage='.$alertmessage);
          exit();
        }
        else if($type="admin"){
          header('Location: ../View-Users-Admin.php?alertmessage='.$alertmessage);
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
    header('Location: ../Index.php');
    exit();
  }
?>