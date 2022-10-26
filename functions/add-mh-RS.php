<?php
  if($_SESSION['type']='personnel' && $_SESSION['isloggedin']=true){
    if(isset($_POST['add-mh-RS'])){
      //database connectionn
      require('config/config.php');
      require('config/db.php');
  
      //input
      $type = mysqli_real_escape_string($conn,"routine service");
      $date=mysqli_real_escape_string($conn,$_POST['date']);
      $clinicalSign=mysqli_real_escape_string($conn,$_POST['clinicalSign']);
      $activity=mysqli_real_escape_string($conn,$_POST['activity']);
      $medication=mysqli_real_escape_string($conn,$_POST['medication']);
      $remarks=mysqli_real_escape_string($conn,$_POST['remarks']);
      $veterinarian=mysqli_real_escape_string($conn,$_POST['veterinarian']);
      $animalid=mysqli_real_escape_string($conn,$_POST['animalid']);
      $animalname=mysqli_real_escape_string($conn,$_POST['animalname']);
      
      //insert input into database
      //prepare sql statement before execution
      $query = "INSERT INTO `medicalhistory`(`type`, `date`, `clinicalSign`, `activity`, `medication`, `remarks`, `veterinarian`, `animalID`) 
      VALUES (?,?,?,?,?,?,?,?)";
      $stmt = mysqli_stmt_init($conn);
  
      if(!mysqli_stmt_prepare($stmt, $query)){
          $alertmessage = urlencode("SQL error!");
          header('Location: ../Add-Health-History-RS-Form.php?alertmessage='.$alertmessage.'&clientid='.$clientid.'&clientname='.$clientname);
          exit();
      }
      else{
          mysqli_stmt_bind_param($stmt, "sssssssi", $type, $date, $clinicalSign, $activity, $medication, $remarks, $veterinarian, $animalid);
          mysqli_stmt_execute($stmt);
          $alertmessage = urlencode("Routine Service record has been added!");
          header('Location: ../View-Health-History-RS.php?alertmessage='.$alertmessage.'&animalid='.$animalid.'&animalname='.$animalname);
          exit();
      }
      mysqli_stmt_close($stmt);
      mysqli_close($conn);
    }
    else{
      header('Location: ../Index.php');
      exit();
    }
  }
  else{
    $alertmessage = urlencode("Please Log In!");
    header('Location: ../Index.php?alertmessage='.$alertmessage);
    exit();
  }
?>