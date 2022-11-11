<?php
  require('config/config.php');
  require('config/db.php');
  include('functions/checksession-personel.php');

  $type = $_GET['type'];
  $animalID = $_GET['animalid'];
  $animalname = $_GET['animalname'];
  $mhID = $_GET['mhid'];
  if(empty($animalID) || empty($mhID) || empty($animalname) || empty($type)){
    $alertmessage = urlencode("Invalid link! Logging out...");
    header('Location: logout.php?alertmessage'.$alertmessage);
    exit();
  }
  else{
    //input
    $type=mysqli_real_escape_string($conn,$type);
    $animalID=mysqli_real_escape_string($conn,$animalID);
    $mhID=mysqli_real_escape_string($conn,$mhID);
    $animalname=mysqli_real_escape_string($conn,$animalname);
      
    //delete input into database
    //prepare sql statement before execution
    $query = "DELETE FROM `medicalhistory` WHERE medicalhistoryID=? AND animalID=?;";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt, $query)){
      $alertmessage = urlencode("SQL error!");
      header('Location: ../View-Health-History.php?alertmessage='.$alertmessage.'&animalid='.$animalID.'&animalname='.$animalname.'&type='.$type);
      exit();
    }
    else{
      mysqli_stmt_bind_param($stmt, "ii", $mhID, $animalID);
      mysqli_stmt_execute($stmt);
      $alertmessage = urlencode($type." record has been deleted!");
      header('Location: ../View-Health-History.php?alertmessage='.$alertmessage.'&animalid='.$animalID.'&animalname='.$animalname.'&type='.$type);
      exit();
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
  }
?>