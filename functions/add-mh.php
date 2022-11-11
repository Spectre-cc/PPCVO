<?php
  if(isset($_POST['add-mh'])){
    //database connectionn
    require('config/config.php');
    require('config/db.php');

    $type = mysqli_real_escape_string($conn,$_POST['type']);
    if($type == "Animal Health"){
      //input
      $date=mysqli_real_escape_string($conn,$_POST['date']);
      $clinicalSign=mysqli_real_escape_string($conn,$_POST['clinicalSign']);
      $tentativeDiagnosis=mysqli_real_escape_string($conn,$_POST['tentativeDiagnosis']);
      $prescription=mysqli_real_escape_string($conn,$_POST['prescription']);
      $treatment=mysqli_real_escape_string($conn,$_POST['treatment']);
      $remarks=mysqli_real_escape_string($conn,$_POST['remarks']);
      $vetID=mysqli_real_escape_string($conn,$_POST['vetID']);
      $animalID=mysqli_real_escape_string($conn,$_POST['animalID']);
      $animalname=mysqli_real_escape_string($conn,$_POST['animalname']);

      //insert input into database
      //prepare sql statement before execution
      $query = "INSERT INTO `medicalhistory`(`type`, `date`, `clinicalSign`, `tentativeDiagnosis`, `prescription`, `treatment`, `remarks`, `vetID`, `animalID`) 
      VALUES (?,?,?,?,?,?,?,?,?)";
      $stmt = mysqli_stmt_init($conn);
      if(!mysqli_stmt_prepare($stmt, $query)){
        $alertmessage = urlencode("SQL error!");
        header('Location: ../View-Health-History.php?alertmessage='.$alertmessage.'&animalid='.$animalID.'&animalname='.$animalname.'&type='.$type);
        exit();
      }
      else{
        mysqli_stmt_bind_param($stmt, "sssssssii", $type, $date, $clinicalSign, $tentativeDiagnosis, $prescription, $treatment, $remarks, $vetID, $animalID);
        mysqli_stmt_execute($stmt);
        $alertmessage = urlencode("Animal Health record has been added!");
        header('Location: ../View-Health-History.php?alertmessage='.$alertmessage.'&animalid='.$animalID.'&animalname='.$animalname.'&type='.$type);
        exit();
      }
    }
    elseif($type == "Vaccination"){
      //input
      $date=mysqli_real_escape_string($conn,$_POST['date']);
      $disease=mysqli_real_escape_string($conn,$_POST['disease']);
      $vaccineUsed=mysqli_real_escape_string($conn,$_POST['vaccineUsed']);
      $batchNumber=mysqli_real_escape_string($conn,$_POST['batchNumber']);
      $vaccineSource=mysqli_real_escape_string($conn,$_POST['vaccineSource']);
      $remarks=mysqli_real_escape_string($conn,$_POST['remarks']);
      $vetID=mysqli_real_escape_string($conn,$_POST['vetID']);
      $animalID=mysqli_real_escape_string($conn,$_POST['animalID']);
      $animalname=mysqli_real_escape_string($conn,$_POST['animalname']);

      //insert input into database
      //prepare sql statement before execution
      $query1 = "
      INSERT INTO `vaccine`(`name`, `batchNumber`, `source`) 
      VALUES (?,?,?);";
      $query2 = "
      INSERT INTO `medicalhistory`(`type`, `date`, `disease`, `vaccineID`,`remarks`, `vetID`, `animalID`)
      VALUES (?,?,?,LAST_INSERT_ID(),?,?,?);
      ";
      $stmt1 = mysqli_stmt_init($conn);
      $stmt2 = mysqli_stmt_init($conn);
      if(!mysqli_stmt_prepare($stmt1, $query1) || !mysqli_stmt_prepare($stmt2, $query2)){
          $alertmessage = urlencode("SQL error!");
          header('Location: ../View-Health-History.php?alertmessage='.$alertmessage.'&animalid='.$animalID.'&animalname='.$animalname.'&type='.$type);
          exit();
      }
      else{
        mysqli_stmt_bind_param($stmt1, "sss", $vaccineUsed, $batchNumber, $vaccineSource);
          mysqli_stmt_bind_param($stmt2, "ssssii", $type, $date, $disease, $remarks, $vetID, $animalID);
          mysqli_stmt_execute($stmt1);
          mysqli_stmt_execute($stmt2);
          $alertmessage = urlencode("Vaccination record has been added!");
          header('Location: ../View-Health-History.php?alertmessage='.$alertmessage.'`&animalid='.$animalID.'&animalname='.$animalname.'&type='.$type);
          exit();
      }
    }
    elseif($type == "Routine Service"){
      //input
      $date=mysqli_real_escape_string($conn,$_POST['date']);
      $clinicalSign=mysqli_real_escape_string($conn,$_POST['clinicalSign']);
      $activity=mysqli_real_escape_string($conn,$_POST['activity']);
      $medication=mysqli_real_escape_string($conn,$_POST['medication']);
      $remarks=mysqli_real_escape_string($conn,$_POST['remarks']);
      $vetID=mysqli_real_escape_string($conn,$_POST['vetID']);
      $animalID=mysqli_real_escape_string($conn,$_POST['animalID']);
      $animalname=mysqli_real_escape_string($conn,$_POST['animalname']);

      //insert input into database
      //prepare sql statement before execution
      $query = "
      INSERT INTO `medicalhistory`(`type`, `date`, `clinicalSign`, `activity`, `medication`, `remarks`, `vetID`, `animalID`) 
      VALUES (?,?,?,?,?,?,?,?)
      ";
      $stmt = mysqli_stmt_init($conn);
  
      if(!mysqli_stmt_prepare($stmt, $query)){
          $alertmessage = urlencode("SQL error!");
          header('Location: ../View-Health-History.php?alertmessage='.$alertmessage.'&animalid='.$animalID.'&animalname='.$animalname.'&type='.$type);
          exit();
      }
      else{
          mysqli_stmt_bind_param($stmt, "ssssssii", $type, $date, $clinicalSign, $activity, $medication, $remarks, $vetID, $animalID);
          mysqli_stmt_execute($stmt);
          $alertmessage = urlencode("Routine Service record has been added!");
          header('Location: ../View-Health-History.php?alertmessage='.$alertmessage.'&animalid='.$animalID.'&animalname='.$animalname.'&type='.$type);
          exit();
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