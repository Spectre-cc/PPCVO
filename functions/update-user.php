<?php
  if(isset($_POST['update-user'])){
    //database connectionn
    require('config/config.php');
    require('config/db.php');

    //input
    $userid=mysqli_real_escape_string($conn,$_POST['userid']);
    $type=mysqli_real_escape_string($conn,$_POST['type']);
    $name=mysqli_real_escape_string($conn,$_POST['name']);
    $email=mysqli_real_escape_string($conn,$_POST['email']);
    $password=mysqli_real_escape_string($conn,$_POST['password']);
    $contactnumber=mysqli_real_escape_string($conn,$_POST['contactnumber']);

    //check if email is already used
    $query = "SELECT * FROM user WHERE email=? AND type=? AND NOT userid=?"; 
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $query)){
      $alertmessage = urlencode("SQL error!");
      if($type="personnel"){
        header('Location: View-Users-Personnel.php?alertmessage='.$alertmessage);
        exit();
      }
      else if($type="admin"){
        header('Location: View-Users-Admin.php?alertmessage='.$alertmessage);
        exit();
      }
      else{
        $alertmessage = urlencode("Invalid link! Logging out...");
        header('Location: functions/logout.php?alertmessage='.$alertmessage);
        exit();
      }
    }
    else{
      mysqli_stmt_bind_param($stmt, "ssi", $email, $type, $userid);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      if(mysqli_num_rows($result)==1){
        $alertmessage = urlencode("Email is already used! Update failed...");
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
    }

    //check if password field is empty
    if(empty($password)){
      //prepare sql statement before execution
      $query = "UPDATE `user` SET name=?, email=?, contactNumber=? WHERE userid=? AND type=?;";
      $stmt = mysqli_stmt_init($conn);

      if(!mysqli_stmt_prepare($stmt, $query)){
        $alertmessage = urlencode("SQL error!");
        header('Location: ../Add-User-Admin-Form.php?alertmessage'.$alertmessage);
        exit();
      }
      else{

        mysqli_stmt_bind_param($stmt, "sssis", $name, $email, $contactnumber, $userid, $type);
        mysqli_stmt_execute($stmt);
        $alertmessage = urlencode("User has been updated!");
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
    }
    else{
      //prepare sql statement before execution
      $query = "UPDATE `user` SET name=?, email=?, password =?, contactNumber=? WHERE userid=? AND type=?;";
      $stmt = mysqli_stmt_init($conn);

      if(!mysqli_stmt_prepare($stmt, $query)){
        $alertmessage = urlencode("SQL error!");
        header('Location: ../Add-User-Admin-Form.php?alertmessage'.$alertmessage);
        exit();
      }
      else{

        //hash password before insert
        $hashedpassword = password_hash($password, PASSWORD_DEFAULT);

        mysqli_stmt_bind_param($stmt, "ssssis", $name, $email, $hashedpassword, $contactnumber, $userid, $type);
        mysqli_stmt_execute($stmt);
        $alertmessage = urlencode("User has been updated!");
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
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
  }
  else{
    header('Location: ../Index.php');
    exit();
  }
?>