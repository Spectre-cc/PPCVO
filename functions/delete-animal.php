<?php
  require('./config/config.php');
  require('./config/db.php');
  include('./checksession-personel.php');

    $userID = $_GET['userID'];
    $type = $_GET['type'];
    session_start();
    $_SESSION["alert"]=true;
    
  if($_SESSION['type']='personnel' && $_SESSION['isloggedin']=true){

    $animalID = $_GET['animalID'];
    $clientID = $_GET['clientID'];
    $clientname = $_GET['clientname'];
    session_start();
    $_SESSION["alert"]=true;
    if(empty($clientID) || empty($animalID) || empty($clientname)){
        $alertmessage = urlencode("Invalid link! Logging out...");
        header('Location: logout.php?alertmessage'.$alertmessage);
        exit();
    }
    else{
      //database connectionn
      require('./config/config.php');
      require('./config/db.php');

      //input
      $animalID=mysqli_real_escape_string($conn,$animalID);
      $clientID=mysqli_real_escape_string($conn,$clientID);
      $clientname=mysqli_real_escape_string($conn,$clientname);
      
      //delete input into database
      //prepare sql statement before execution
      $query = "DELETE FROM `animals` WHERE animalID=? AND clientID=?;";
      $stmt = mysqli_stmt_init($conn);

      if(!mysqli_stmt_prepare($stmt, $query)){
          $alertmessage = urlencode("SQL error!");
          header('Location: ../View-Animals-Owned.php?alertmessage='.$alertmessage.'&clientID='.$clientID.'&clientname='.$clientname);
          exit();
      }
      else{
          mysqli_stmt_bind_param($stmt, "ii", $animalID, $clientID);
          mysqli_stmt_execute($stmt);
          $alertmessage = urlencode("Animal record has been deleted!");
          header('Location: ../View-Animals-Owned.php?alertmessage='.$alertmessage.'&clientID='.$clientID.'&clientname='.$clientname);
          exit();
      }
      mysqli_stmt_close($stmt);
      mysqli_close($conn);
    }
  }
  else{
    $alertmessage = urlencode("Please Log In!");
    header('Location: logout.php?alertmessage='.$alertmessage);
    exit();
  }
?>