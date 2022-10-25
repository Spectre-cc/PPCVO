<?php
  if(isset($_POST['update-mh-AH'])){
    //database connection
    require('config/config.php');
    require('config/db.php');

    //input
    $mhid=mysqli_real_escape_string($conn,$_POST['mhid']);
    $date=mysqli_real_escape_string($conn,$_POST['date']);
    $clinicalSign=mysqli_real_escape_string($conn,$_POST['clinicalSign']);
    $tentativeDiagnosis=mysqli_real_escape_string($conn,$_POST['tentativeDiagnosis']);
    $prescription=mysqli_real_escape_string($conn,$_POST['prescription']);
    $treatment=mysqli_real_escape_string($conn,$_POST['treatment']);
    $remarks=mysqli_real_escape_string($conn,$_POST['remarks']);
    $veterinarian=mysqli_real_escape_string($conn,$_POST['veterinarian']);
    $animalid=mysqli_real_escape_string($conn,$_POST['animalid']);
    $animalname=mysqli_real_escape_string($conn,$_POST['animalname']);

    //prepare sql statement before execution
    $query = "UPDATE `medicalhistory` SET date=?, clinicalSign=?, tentativeDiagnosis=?, prescription=?, treatment=?, remarks=?, veterinarian=? WHERE animalID=? AND mhID=?;";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt, $query)){
      $alertmessage = urlencode("SQL error!");
      header('Location: ../Update-Health-History-AH-Form.php?alertmessage='.$alertmessage.'&animalid='.$animalid.'&animalname='.$animalname.'&mhid='.$mhid);
      exit();
    }
    else{

      mysqli_stmt_bind_param($stmt, "sssssssii", $date, $clinicalSign, $tentativeDiagnosis, $prescription, $treatment, $remarks, $veterinarian, $animalid, $mhid);
      mysqli_stmt_execute($stmt);
      $alertmessage = urlencode("Animal Health record has been updated!");
      header('Location: ../View-Health-History-AH.php?alertmessage='.$alertmessage.'&animalid='.$animalid.'&animalname='.$animalname);
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