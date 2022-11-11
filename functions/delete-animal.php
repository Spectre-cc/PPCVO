<?php
  if($_SESSION['type']='personnel' && $_SESSION['isloggedin']=true){

    $animalID = $_GET['animalid'];
    $clientID = $_GET['clientid'];
    $clientname = $_GET['clientname'];
    if(empty($clientID) || empty($animalID) || empty($clientname)){
        $alertmessage = urlencode("Invalid link! Logging out...");
        header('Location: logout.php?alertmessage'.$alertmessage);
        exit();
    }
    else{
      //database connectionn
      require('config/config.php');
      require('config/db.php');

      //input
      $animalID=mysqli_real_escape_string($conn,$animalID);
      $clientID=mysqli_real_escape_string($conn,$clientID);
      $clientname=mysqli_real_escape_string($conn,$clientname);
      
      //delete input into database
      //prepare sql statement before execution
      $query = "DELETE FROM `animal` WHERE animalID=? AND clientID=?;";
      $stmt = mysqli_stmt_init($conn);

      if(!mysqli_stmt_prepare($stmt, $query)){
          $alertmessage = urlencode("SQL error!");
          header('Location: ../View-Client-List.php?alertmessage='.$alertmessage);
      }
      else{
          mysqli_stmt_bind_param($stmt, "ii", $animalID, $clientID);
          mysqli_stmt_execute($stmt);
          $alertmessage = urlencode("Animal record has been deleted!");
          header('Location: ../View-Animals-Owned.php?alertmessage='.$alertmessage.'&clientid='.$clientID.'&clientname='.$clientname);
      }
      mysqli_stmt_close($stmt);
      mysqli_close($conn);
    }
  }
  else{
    $alertmessage = urlencode("Please Log In!");
    header('Location: ../Index.php?alertmessage='.$alertmessage);
    exit();
  }
?>