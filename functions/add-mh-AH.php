<?php
  if($_SESSION['type']='personnel' && $_SESSION['isloggedin']=true){
    if(isset($_POST['add-mh-AH'])){
      //database connectionn
      require('config/config.php');
      require('config/db.php');
  
      //input
      $type = mysqli_real_escape_string($conn,"animal health");
      $date=mysqli_real_escape_string($conn,$_POST['date']);
      $clinicalSign=mysqli_real_escape_string($conn,$_POST['clinicalSign']);
      $tentativeDiagnosis=mysqli_real_escape_string($conn,$_POST['tentativeDiagnosis']);
      $prescription=mysqli_real_escape_string($conn,$_POST['prescription']);
      $treatment=mysqli_real_escape_string($conn,$_POST['treatment']);
      $remarks=mysqli_real_escape_string($conn,$_POST['remarks']);
      $veterinarian=mysqli_real_escape_string($conn,$_POST['veterinarian']);
      $animalid=mysqli_real_escape_string($conn,$_POST['animalid']);
      $animalname=mysqli_real_escape_string($conn,$_POST['animalname']);
      
      //insert input into database
      //prepare sql statement before execution
      $query = "INSERT INTO `medicalhistory`(`type`, `date`, `clinicalSign`, `tentativeDiagnosis`, `prescription`, `treatment`, `remarks`, `veterinarian`, `animalID`) 
      VALUES (?,?,?,?,?,?,?,?,?)";
      $stmt = mysqli_stmt_init($conn);
  
      if(!mysqli_stmt_prepare($stmt, $query)){
          $alertmessage = urlencode("SQL error!");
          header('Location: ../Add-Health-History-AH-Form.php?alertmessage='.$alertmessage.'&clientid='.$clientid.'&clientname='.$clientname);
          exit();
      }
      else{
          mysqli_stmt_bind_param($stmt, "ssssssssi", $type, $date, $clinicalSign, $tentativeDiagnosis, $prescription, $treatment, $remarks, $veterinarian, $animalid);
          mysqli_stmt_execute($stmt);
          $alertmessage = urlencode("Animal Health record has been added!");
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
  }
  else{
    $alertmessage = urlencode("Please Log In!");
    header('Location: ../Index.php?alertmessage='.$alertmessage);
    exit();
  }
?>