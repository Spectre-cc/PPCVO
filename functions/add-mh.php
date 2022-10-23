<?php
  if($_SESSION['type']='personnel' && $_SESSION['isloggedin']=true){
    if(isset($_POST['add-mh'])){
      //database connectionn
      require('config/config.php');
      require('config/db.php');
  
      //input
      $date=mysqli_real_escape_string($conn,$_POST['date']);
      $case=mysqli_real_escape_string($conn,$_POST['case']);
      $tentativeDiagnosis=mysqli_real_escape_string($conn,$_POST['tentativeDiagnosis']);
      $prescription=mysqli_real_escape_string($conn,$_POST['prescription']);
      $treatment=mysqli_real_escape_string($conn,$_POST['treatment']);
      $remarks=mysqli_real_escape_string($conn,$_POST['remarks']);
      $veterinarian=mysqli_real_escape_string($conn,$_POST['veterinarian']);
      $animalid=mysqli_real_escape_string($conn,$_POST['animalid']);
      $animalname=mysqli_real_escape_string($conn,$_POST['animalname']);
      
      //insert input into database
      //prepare sql statement before execution
      $query = "INSERT INTO `medicalhistory`(`date`,`caseHistory`, `tentativeDiagnosis`, `prescription`, `treatment`, `remarks`, `veterinarian`, `animalID`) 
      VALUES (?,?,?,?,?,?,?,?)";
      $stmt = mysqli_stmt_init($conn);
  
      if(!mysqli_stmt_prepare($stmt, $query)){
          $alertmessage = urlencode("SQL error!");
          header('Location: ../Add-Animal-Form.php?alertmessage='.$alertmessage.'&clientid='.$clientid.'&clientname='.$clientname);
          exit();
      }
      else{
          mysqli_stmt_bind_param($stmt, "sssssssi", $date, $case, $tentativeDiagnosis, $prescription, $treatment, $remarks, $veterinarian, $animalid);
          mysqli_stmt_execute($stmt);
          $alertmessage = urlencode("Health history has been added!");
          header('Location: ../View-Health-History.php?alertmessage='.$alertmessage.'&animalid='.$animalid.'&animalname='.$animalname);
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