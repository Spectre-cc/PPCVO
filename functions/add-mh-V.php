<?php
  if($_SESSION['type']='personnel' && $_SESSION['isloggedin']=true){
    if(isset($_POST['add-mh-V'])){
      //database connectionn
      require('config/config.php');
      require('config/db.php');
  
      //input
      $type = mysqli_real_escape_string($conn,"vaccination");
      $date=mysqli_real_escape_string($conn,$_POST['date']);
      $disease=mysqli_real_escape_string($conn,$_POST['disease']);
      $vaccineUsed=mysqli_real_escape_string($conn,$_POST['vaccineUsed']);
      $batchNumber=mysqli_real_escape_string($conn,$_POST['batchNumber']);
      $vaccineSource=mysqli_real_escape_string($conn,$_POST['vaccineSource']);
      $remarks=mysqli_real_escape_string($conn,$_POST['remarks']);
      $veterinarian=mysqli_real_escape_string($conn,$_POST['veterinarian']);
      $animalid=mysqli_real_escape_string($conn,$_POST['animalid']);
      $animalname=mysqli_real_escape_string($conn,$_POST['animalname']);
      
      //insert input into database
      //prepare sql statement before execution
      $query = "INSERT INTO `medicalhistory`(`type`, `date`, `disease`, `vaccineUsed`, `batchNumber`, `vaccineSource`, `remarks`, `veterinarian`, `animalID`) 
      VALUES (?,?,?,?,?,?,?,?,?)";
      $stmt = mysqli_stmt_init($conn);
  
      if(!mysqli_stmt_prepare($stmt, $query)){
          $alertmessage = urlencode("SQL error!");
          header('Location: ../Add-Health-History-V-Form.php?alertmessage='.$alertmessage.'&clientid='.$clientid.'&clientname='.$clientname);
          exit();
      }
      else{
          mysqli_stmt_bind_param($stmt, "ssssssssi", $type, $date, $disease, $vaccineUsed, $batchNumber, $vaccineSource, $remarks, $veterinarian, $animalid);
          mysqli_stmt_execute($stmt);
          $alertmessage = urlencode("Vaccination record has been added!");
          header('Location: ../View-Health-History-V.php?alertmessage='.$alertmessage.'&animalid='.$animalid.'&animalname='.$animalname);
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