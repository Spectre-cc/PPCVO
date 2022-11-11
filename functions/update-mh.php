<?php
  if(isset($_POST['update-mh'])){
    //database connection
    require('config/config.php');
    require('config/db.php');
    
    $type=mysqli_real_escape_string($conn,$_POST['type']);

    if($type=="Animal Health"){
      //input
      $mhID=mysqli_real_escape_string($conn,$_POST['mhid']);
      $date=mysqli_real_escape_string($conn,$_POST['date']);
      $animalname=mysqli_real_escape_string($conn,$_POST['animalname']);
      $clinicalSign=mysqli_real_escape_string($conn,$_POST['clinicalSign']);
      $tentativeDiagnosis=mysqli_real_escape_string($conn,$_POST['tentativeDiagnosis']);
      $prescription=mysqli_real_escape_string($conn,$_POST['prescription']);
      $treatment=mysqli_real_escape_string($conn,$_POST['treatment']);
      $remarks=mysqli_real_escape_string($conn,$_POST['remarks']);
      $vetID=mysqli_real_escape_string($conn,$_POST['vetID']);
      $animalID=mysqli_real_escape_string($conn,$_POST['animalid']);

      //prepare sql statement before execution
      $query = "
      UPDATE `medicalhistory` 
      SET date=?, clinicalSign=?, tentativeDiagnosis=?, prescription=?, treatment=?, remarks=?, vetID=? 
      WHERE animalID=? AND medicalhistoryID=?;
      ";
      $stmt = mysqli_stmt_init($conn);
      if(!mysqli_stmt_prepare($stmt, $query)){
        $alertmessage = urlencode("SQL error!");
        header('Location: ../View-Health-History.php?alertmessage='.$alertmessage.'&animalid='.$animalID.'&animalname='.$animalname.'&type='.$type);
        exit();
      }
      else{
        mysqli_stmt_bind_param($stmt, "sssssssii", $date, $clinicalSign, $tentativeDiagnosis, $prescription, $treatment, $remarks, $vetID, $animalID, $mhID);
        mysqli_stmt_execute($stmt);
        $alertmessage = urlencode($type." record has been updated!");
        header('Location: ../View-Health-History.php?alertmessage='.$alertmessage.'&animalid='.$animalID.'&animalname='.$animalname.'&type='.$type);
        exit();
      }
    }elseif($type=="Vaccination"){
      //input
      $mhID=mysqli_real_escape_string($conn,$_POST['mhid']);
      $date=mysqli_real_escape_string($conn,$_POST['date']);
      $animalname=mysqli_real_escape_string($conn,$_POST['animalname']);
      $disease=mysqli_real_escape_string($conn,$_POST['disease']);
      $vaccineID=mysqli_real_escape_string($conn,$_POST['vaccineID']);
      $vaccineUsed=mysqli_real_escape_string($conn,$_POST['vaccineUsed']);
      $batchNumber=mysqli_real_escape_string($conn,$_POST['batchNumber']);
      $vaccineSource=mysqli_real_escape_string($conn,$_POST['vaccineSource']);
      $remarks=mysqli_real_escape_string($conn,$_POST['remarks']);
      $vetID=mysqli_real_escape_string($conn,$_POST['vetID']);
      $animalID=mysqli_real_escape_string($conn,$_POST['animalid']);

      //prepare sql statement before execution
      $query1 = "
      UPDATE `vaccine` 
      SET name=?, batchNumber=?, source=? 
      WHERE vaccineID=?;
      ";
      $query2 = "
      UPDATE `medicalhistory` 
      SET date=?, disease=?, remarks=?, vetID=? 
      WHERE animalID=? AND medicalhistoryID=?;
      ";
      $stmt1 = mysqli_stmt_init($conn);
      $stmt2 = mysqli_stmt_init($conn);
      if(!mysqli_stmt_prepare($stmt1, $query1) || !mysqli_stmt_prepare($stmt2, $query2)){
        $alertmessage = urlencode("SQL error!");
        header('Location: ../View-Health-History.php?alertmessage='.$alertmessage.'&animalid='.$animalID.'&animalname='.$animalname.'&type='.$type);
        exit();
      }
      else{
        mysqli_stmt_bind_param($stmt1, "sssi", $vaccineUsed, $batchNumber, $vaccineSource, $vaccineID);
        mysqli_stmt_bind_param($stmt2, "sssiii", $date, $disease, $remarks, $vetID, $animalID, $mhID);
        mysqli_stmt_execute($stmt1);
        mysqli_stmt_execute($stmt2);
        $alertmessage = urlencode($type." record has been updated!");
        header('Location: ../View-Health-History.php?alertmessage='.$alertmessage.'&animalid='.$animalID.'&animalname='.$animalname.'&type='.$type);
        exit();
      }
    }elseif($type=="Routine Service"){
      //input
      $mhID=mysqli_real_escape_string($conn,$_POST['mhid']);
      $date=mysqli_real_escape_string($conn,$_POST['date']);
      $animalname=mysqli_real_escape_string($conn,$_POST['animalname']);
      $clinicalSign=mysqli_real_escape_string($conn,$_POST['clinicalSign']);
      $activity=mysqli_real_escape_string($conn,$_POST['activity']);
      $medication=mysqli_real_escape_string($conn,$_POST['medication']);
      $remarks=mysqli_real_escape_string($conn,$_POST['remarks']);
      $vetID=mysqli_real_escape_string($conn,$_POST['vetID']);
      $animalID=mysqli_real_escape_string($conn,$_POST['animalid']);

      //prepare sql statement before execution
      $query = "
      UPDATE `medicalhistory` 
      SET date=?, clinicalSign=?, activity=?, medication=?, remarks=?, vetID=? 
      WHERE animalID=? AND medicalhistoryID=?;
      ";
      $stmt = mysqli_stmt_init($conn);
      if(!mysqli_stmt_prepare($stmt, $query)){
        $alertmessage = urlencode("SQL error!");
        header('Location: ../View-Health-History.php?alertmessage='.$alertmessage.'&animalid='.$animalID.'&animalname='.$animalname.'&type='.$type);
        exit();
      }
      else{
        mysqli_stmt_bind_param($stmt, "ssssssii", $date, $clinicalSign, $activity, $medication, $remarks, $vetID, $animalID, $mhID);
        mysqli_stmt_execute($stmt);
        $alertmessage = urlencode($type." record has been updated!");
        header('Location: ../View-Health-History.php?alertmessage='.$alertmessage.'&animalid='.$animalID.'&animalname='.$animalname.'&type='.$type);
        exit();
      }
    }else{
      $alertmessage = urlencode("Invalid link! Logging out...");
      header('Location: functions/logout.php?alertmessage='.$alertmessage);
      exit();
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
  }
  else{
    header('Location: ../Index.php');
    exit();
  }
?>