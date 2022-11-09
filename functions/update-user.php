<?php
  if(isset($_POST['update-user'])){
    //database connectionn
    require('config/config.php');
    require('config/db.php');

    //input
    $userID=mysqli_real_escape_string($conn,$_POST['userID']);
    $type=mysqli_real_escape_string($conn,$_POST['type']);
    $fName=mysqli_real_escape_string($conn,$_POST['fName']);
    $mName=mysqli_real_escape_string($conn,$_POST['mName']);
    $lName=mysqli_real_escape_string($conn,$_POST['lName']);
    $email=mysqli_real_escape_string($conn,$_POST['email']);
    $password=mysqli_real_escape_string($conn,$_POST['password']);
    $cNumber=mysqli_real_escape_string($conn,$_POST['cNumber']);

    //check if email is already used
    $query = "SELECT * FROM user WHERE email=? AND type=? AND NOT userID=?"; 
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $query)){
      $alertmessage = urlencode("SQL error!");
      if($type=="personnel" || $type=="admin"){
        header('Location: ../Update-Client-Form.php?alertmessage='.$alertmessage.'&type='.$type.'&userID='.$userID);
        exit();
      }
      else{
        $alertmessage = urlencode("Invalid link! Logging out...");
        header('Location: logout.php?alertmessage='.$alertmessage);
        exit();
      }
    }
    else{
      mysqli_stmt_bind_param($stmt, "ssi", $email, $type, $userID);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      if(mysqli_num_rows($result)==1){
        $alertmessage = urlencode("Email is already used! Update failed...");
        if($type=="personnel" || $type=="admin"){
          header('Location: ../Update-User-Form.php?alertmessage='.$alertmessage.'&type='.$type);
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
      $query = "UPDATE `user` SET fName=?, mName=?, lName=?, email=?, cNumber=? WHERE userID=? AND type=?;";
      $stmt = mysqli_stmt_init($conn);

      if(!mysqli_stmt_prepare($stmt, $query)){
        $alertmessage = urlencode("SQL error!");
        if($type=="personnel" || $type=="admin"){
          header('Location: ../Update-User-Form.php?alertmessage='.$alertmessage.'&type='.$type);
          exit();
        }
        else{
          $alertmessage = urlencode("Invalid link! Logging out...");
          header('Location: logout.php?alertmessage='.$alertmessage);
          exit();
        }
      }
      else{

        mysqli_stmt_bind_param($stmt, "sssssis", $fName, $mName, $lName, $email, $cNumber, $userID, $type);
        mysqli_stmt_execute($stmt);
        $alertmessage = urlencode("User has been updated!");
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
    else{
      //prepare sql statement before execution
      $query = "UPDATE `user` SET $fName=?, $mName=?, $lName=?, email=?, password=?, cNumber=? WHERE userID=? AND type=?;";
      $stmt = mysqli_stmt_init($conn);

      if(!mysqli_stmt_prepare($stmt, $query)){
        $alertmessage = urlencode("SQL error!");
        if($type=="personnel" || $type=="admin"){
          header('Location: ../Add-User.php?alertmessage='.$alertmessage.'&type='.$type);
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

        mysqli_stmt_bind_param($stmt, "ssssssis", $fName, $mName, $lName, $email, $hashedpassword, $cNumber, $userID, $type);
        mysqli_stmt_execute($stmt);
        $alertmessage = urlencode("User has been updated!");
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
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
  }
  else{
    header('Location: ../Index.php');
    exit();
  }
?>