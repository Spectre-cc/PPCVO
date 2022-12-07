<?php
  if(isset($_GET['personnelID'])&& isset($_GET['action'])){
    //database connectionn
    require('config/config.php');
    require('config/db.php');

    //input
    $personnelID=mysqli_real_escape_string($conn,$_GET['personnelID']);
    $action=mysqli_real_escape_string($conn,$_GET['action']);
    session_start();
    $_SESSION["alert"]=true;
    
    if($action == "activate" || $action == "deactivate"){
      //prepare sql statement before execution
      $query = "UPDATE `personnel` SET status = ? WHERE personnelID = ?;";
      $stmt = mysqli_stmt_init($conn);

      if(!mysqli_stmt_prepare($stmt, $query)){
        $alertmessage = urlencode("SQL error!");
        header('Location: ../View-Personnel.php?alertmessage='.$alertmessage);
        exit();
      }
      else{
        if($action == "activate"){
          $status = "active";
          mysqli_stmt_bind_param($stmt, "si", $status, $personnelID);
        }elseif($action == "deactivate"){
          $status = "inactive";
          mysqli_stmt_bind_param($stmt, "si", $status, $personnelID);
        }
        mysqli_stmt_execute($stmt);
        if($action == "activate"){
          $alertmessage = urlencode("Personnel is now active!");
        }elseif($action == "deactivate"){
          $alertmessage = urlencode("Personnel is now inactive!");
        }
        header('Location: ../View-Personnel.php?alertmessage='.$alertmessage);
        exit();
      }
      mysqli_stmt_close($stmt);
      mysqli_close($conn);
    }else{ 
      $alertmessage = urlencode("Invalid link! Logging out...");
      header('Location: logout.php?alertmessage='.$alertmessage);
      exit();
    }
  }
  else{
    $alertmessage = urlencode("Invalid link! Logging out...");
    header('Location: logout.php?alertmessage='.$alertmessage);
    exit();
  }
?>