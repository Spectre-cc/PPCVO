<?php
  if($_SESSION['type']='personnel' && $_SESSION['isloggedin']=true){

    $animalid = $_GET['animalid'];
    $animalname = $_GET['animalname'];
    $mhid = $_GET['mhid'];
    if(empty($animalid) || empty($mhid) || empty($animalname)){
        $alertmessage = urlencode("Invalid link! Logging out...");
        header('Location: logout.php?alertmessage'.$alertmessage);
        exit();
    }
    else{
      //database connectionn
      require('config/config.php');
      require('config/db.php');

      //input
      $animalid=mysqli_real_escape_string($conn,$animalid);
      $mhid=mysqli_real_escape_string($conn,$mhid);
      $animalname=mysqli_real_escape_string($conn,$animalname);
      
      //delete input into database
      //prepare sql statement before execution
      $query = "DELETE FROM `medicalhistory` WHERE mhID=? AND animalID=?;";
      $stmt = mysqli_stmt_init($conn);

      if(!mysqli_stmt_prepare($stmt, $query)){
          $alertmessage = urlencode("SQL error!");
          header('Location: ../View-Health-History-AH.php?alertmessage='.$alertmessage.'&animalid='.$animalid.'&animalname='.$animalname);
          exit();
      }
      else{
          mysqli_stmt_bind_param($stmt, "ii", $mhid, $animalid);
          mysqli_stmt_execute($stmt);
          $alertmessage = urlencode("Routine Service record has been deleted!");
          header('Location: ../View-Health-History-RS.php?alertmessage='.$alertmessage.'&animalid='.$animalid.'&animalname='.$animalname);
          exit();
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