<?php
  require('config/config.php');
  require('config/db.php');
  include('functions/checksession-personel.php');

  $type = $_GET['type'];
  $animalID = $_GET['animalID'];
  $animalname = $_GET['animalname'];
  $consultationID = $_GET['consultationID'];
  $transaction=$_GET['transaction'];
  
  session_start();
  $_SESSION["alert"]=true;

  if(empty($animalID) || empty($consultationID) || empty($animalname) || empty($type) || empty($transaction)){
    $alertmessage = urlencode("Invalid link! Logging out...");
    header('Location: logout.php?alertmessage='.$alertmessage);
    exit();
  }
  else{
    //input
    $type=mysqli_real_escape_string($conn,$type);
    $animalID=mysqli_real_escape_string($conn,$animalID);
    $consultationID=mysqli_real_escape_string($conn,$consultationID);
    $animalname=mysqli_real_escape_string($conn,$animalname);
    $transaction=mysqli_real_escape_string($conn,$transaction);
      
    //delete input into database
      //prepare sql statement before execution
    if($transaction=="walk-in"){
      $query = "DELETE FROM `walk_in_transactions` WHERE consultationID=? AND animalID=?;";
    }elseif($transaction=="field"){
      $query = "DELETE FROM `field_visititations` WHERE consultationID=? AND animalID=?;";
    }
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt, $query)){
      $alertmessage = urlencode("SQL error!");
      header('Location: ../View-Health-History.php?alertmessage='.$alertmessage.'&animalID='.$animalID.'&animalname='.$animalname.'&type='.$type.'&transaction='.$transaction);
      exit();
    }
    else{
      mysqli_stmt_bind_param($stmt, "ii", $consultationID, $animalID);
      mysqli_stmt_execute($stmt);
      $alertmessage = urlencode($type." record has been deleted!");
      header('Location: ../View-Health-History.php?alertmessage='.$alertmessage.'&animalID='.$animalID.'&animalname='.$animalname.'&type='.$type.'&transaction='.$transaction);
      exit();
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
  }
?>