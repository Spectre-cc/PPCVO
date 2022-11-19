<?php
  require('config/config.php');
  require('config/db.php');
  include('functions/checksession-personel.php');

    $userID = $_GET['userID'];
    $type = $_GET['type'];
    session_start();
    $_SESSION["alert"]=true;
    if(empty($userID) && empty($type)){
        $alertmessage = urlencode("Invalid link! Logging out...");
        header('Location: logout.php?alertmessage'.$alertmessage);
        exit();
    }
    else{

      //input
      $userID=mysqli_real_escape_string($conn,$_GET['userID']);
      $type=mysqli_real_escape_string($conn,$_GET['type']);
      
      //delete input into database
      //prepare sql statement before execution
      $query = "DELETE FROM `user` WHERE userID=? AND type=? ;";
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
          mysqli_stmt_bind_param($stmt, "is", $userID, $type);
          mysqli_stmt_execute($stmt);
          $alertmessage = urlencode("User has been deleted!");
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
?>