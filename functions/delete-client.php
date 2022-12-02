<?php
  $clientID = $_GET['clientID'];
  session_start();
  $_SESSION["alert"]=true;
  if(empty($clientID)){
    $alertmessage = urlencode("Invalid link! Logging out...");
    header('Location: logout.php?alertmessage'.$alertmessage);
    exit();
  }
  else{
    //database connectionn
    require('./config/config.php');
    require('./config/db.php');

     //input
    $clientID=mysqli_real_escape_string($conn,$clientID);
    
    //delete input into database
    //prepare sql statement before execution
    $query = "DELETE FROM `clients` WHERE clientID=?;";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt, $query)){
        $alertmessage = urlencode("SQL error!");
        header('Location: ../View-Client-List.php?alertmessage='.$alertmessage);
    }
    else{
        mysqli_stmt_bind_param($stmt, "i", $clientID);
        mysqli_stmt_execute($stmt);
        $alertmessage = urlencode("Client record has been deleted!");
        header('Location: ../View-Client-List.php?alertmessage='.$alertmessage);
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
  }
?>