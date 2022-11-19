<?php
  if(isset($_POST['update-mh'])){
    //database connection
    require('config/config.php');
    require('config/db.php');
    
    $type=mysqli_real_escape_string($conn,$_POST['type']);

    session_start();
    $_SESSION["alert"]=true;

    if($type=="Animal Health"){
      //input
      $consultationID=mysqli_real_escape_string($conn,$_POST['consultationID']);
      $date=mysqli_real_escape_string($conn,$_POST['date']);
      $clinicalSign=mysqli_real_escape_string($conn,$_POST['clinicalSign']);
      $tentativeDiagnosis=mysqli_real_escape_string($conn,$_POST['tentativeDiagnosis']);
      $prescription=mysqli_real_escape_string($conn,$_POST['prescription']);
      $treatment=mysqli_real_escape_string($conn,$_POST['treatment']);
      $remarks=mysqli_real_escape_string($conn,$_POST['remarks']);
      $personnelID=mysqli_real_escape_string($conn,$_POST['personnelID']);
      $animalID=mysqli_real_escape_string($conn,$_POST['animalID']);
      $animalname=mysqli_real_escape_string($conn,$_POST['animalname']);

      //prepare sql statement before execution
      $query = "
      UPDATE 
        `walk_in_transactions` 
      SET 
        date=?, 
        clinicalSign=?, 
        tentativeDiagnosis=?, 
        prescription=?, 
        treatment=?, 
        remarks=?, 
        personnelID=? 
      WHERE 
        animalID=? 
        AND 
        consultationID=?;
      ";
      $stmt = mysqli_stmt_init($conn);
      if(!mysqli_stmt_prepare($stmt, $query)){
        $alertmessage = urlencode("SQL error!");
        header('Location: ../View-Health-History.php?alertmessage='.$alertmessage.'&animalID='.$animalID.'&animalname='.$animalname.'&type='.$type);
        exit();
      }
      else{
        mysqli_stmt_bind_param($stmt, "sssssssii", $date, $clinicalSign, $tentativeDiagnosis, $prescription, $treatment, $remarks, $personnelID, $animalID, $consultationID);
        mysqli_stmt_execute($stmt);
        $alertmessage = urlencode($type." record has been updated!");
        header('Location: ../View-Health-History.php?alertmessage='.$alertmessage.'&animalID='.$animalID.'&animalname='.$animalname.'&type='.$type);
        exit();
      }
    }elseif($type=="Vaccination"){
      //input
      $vaccineID=mysqli_real_escape_string($conn,$_POST['vaccineID']);
      $consultationID=mysqli_real_escape_string($conn,$_POST['consultationID']);
      $date=mysqli_real_escape_string($conn,$_POST['date']);
      $disease=mysqli_real_escape_string($conn,$_POST['disease']);
      $vaccineUsed=mysqli_real_escape_string($conn,$_POST['vaccineUsed']);
      $batchNumber=mysqli_real_escape_string($conn,$_POST['batchNumber']);
      $vaccineSource=mysqli_real_escape_string($conn,$_POST['vaccineSource']);
      $remarks=mysqli_real_escape_string($conn,$_POST['remarks']);
      $personnelID=mysqli_real_escape_string($conn,$_POST['personnelID']);
      $animalID=mysqli_real_escape_string($conn,$_POST['animalID']);
      $animalname=mysqli_real_escape_string($conn,$_POST['animalname']);

      //prepare sql statement before execution
      $query1 = "
      UPDATE `vaccines` 
      SET name=?, batchNumber=?, source=? 
      WHERE vaccineID=?;
      ";
      $query2 = "
      UPDATE `walk_in_transactions` 
      SET date=?, disease=?, remarks=?, personnelID=? 
      WHERE animalID=? AND consultationID=?;
      ";
      $stmt1 = mysqli_stmt_init($conn);
      $stmt2 = mysqli_stmt_init($conn);
      if(!mysqli_stmt_prepare($stmt1, $query1) || !mysqli_stmt_prepare($stmt2, $query2)){
        $alertmessage = urlencode("SQL error!");
        header('Location: ../View-Health-History.php?alertmessage='.$alertmessage.'&animalID='.$animalID.'&animalname='.$animalname.'&type='.$type);
        exit();
      }
      else{
        mysqli_stmt_bind_param($stmt1, "sisi", $vaccineUsed, $batchNumber, $vaccineSource, $vaccineID);
        mysqli_stmt_bind_param($stmt2, "sssiii", $date, $disease, $remarks, $personnelID, $animalID, $consultationID);
        mysqli_stmt_execute($stmt1);
        mysqli_stmt_execute($stmt2);
        $alertmessage = urlencode($type." record has been updated!");
        header('Location: ../View-Health-History.php?alertmessage='.$alertmessage.'&animalID='.$animalID.'&animalname='.$animalname.'&type='.$type);
        exit();
      }
    }elseif($type=="Routine Service"){
      //input
      $consultationID=mysqli_real_escape_string($conn,$_POST['consultationID']);
      $date=mysqli_real_escape_string($conn,$_POST['date']);
      $clinicalSign=mysqli_real_escape_string($conn,$_POST['clinicalSign']);
      $activity=mysqli_real_escape_string($conn,$_POST['activity']);
      $medication=mysqli_real_escape_string($conn,$_POST['medication']);
      $remarks=mysqli_real_escape_string($conn,$_POST['remarks']);
      $personnelID=mysqli_real_escape_string($conn,$_POST['personnelID']);
      $animalID=mysqli_real_escape_string($conn,$_POST['animalID']);
      $animalname=mysqli_real_escape_string($conn,$_POST['animalname']);
      $barangay=mysqli_real_escape_string($conn,$_POST['barangay']);

      //check if barangay already exist
      $query="SELECT barangayID FROM barangays WHERE brgy_name=? LIMIT 1;";
      $stmt = mysqli_stmt_init($conn);
      if(!mysqli_stmt_prepare($stmt, $query)){
        $alertmessage = urlencode("SQL error!");
        header('Location: ../View-Health-History.php?alertmessage='.$alertmessage.'&animalID='.$animalID.'&animalname='.$animalname.'&type='.$type);
        exit();
      }else{
        mysqli_stmt_bind_param($stmt, "s", $barangay);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        //if barangay does not exist, insert new barangay name
        if(mysqli_num_rows($result)<1){
          $query = "
          INSERT INTO `barangays`(`brgy_name`) 
          VALUES (?);
          ";
          $stmt = mysqli_stmt_init($conn);
          if(!mysqli_stmt_prepare($stmt, $query)){
            $alertmessage = urlencode("SQL error!");
            header('Location: ../View-Health-History.php?alertmessage='.$alertmessage.'&animalID='.$animalID.'&animalname='.$animalname.'&type='.$type);
            exit();
          }else{
            mysqli_stmt_bind_param($stmt, "s", $barangay);
            mysqli_stmt_execute($stmt);
            $barangayExist=false;
          }
        }else{
          $barangayExist=true;
          foreach ($result as $data):
            $barangay=$data['barangayID'];
          endforeach;
        }
      }

      if($barangayExist==true){
        $query = "
        UPDATE 
          `field_visititations` 
        SET 
          date=?, 
          clinicalSign=?, 
          activity=?, 
          medication=?, 
          remarks=?, 
          personnelID=?,
          barangayID=?
        WHERE 
          animalID=? 
          AND 
          consultationID=?;
        ";
      }else{
        $query = "
        UPDATE 
          `field_visititations` 
        SET 
          date=?, 
          clinicalSign=?, 
          activity=?, 
          medication=?, 
          remarks=?, 
          personnelID=?,
          barangayID=LAST_INSERT_ID()
        WHERE 
          animalID=? 
          AND 
          consultationID=?;
        ";
      }
      $stmt = mysqli_stmt_init($conn);
      if(!mysqli_stmt_prepare($stmt, $query)){
        $alertmessage = urlencode("SQL error!");
        header('Location: ../View-Health-History.php?alertmessage='.$alertmessage.'&animalID='.$animalID.'&animalname='.$animalname.'&type='.$type);
        exit();
      }
      else{
        if($barangayExist==true){
          mysqli_stmt_bind_param($stmt, "sssssiiii",  $date, $clinicalSign, $activity, $medication, $remarks, $personnelID, $barangay, $animalID, $consultationID);
        }else{
          mysqli_stmt_bind_param($stmt, "sssssiii",  $date, $clinicalSign, $activity, $medication, $remarks, $personnelID, $animalID, $consultationID);
        }
        mysqli_stmt_execute($stmt);
        $alertmessage = urlencode("Routine Service record has been updated!");
        header('Location: ../View-Health-History.php?alertmessage='.$alertmessage.'&animalID='.$animalID.'&animalname='.$animalname.'&type='.$type);
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
    $alertmessage = urlencode("Invalid link! Logging out...");
    header('Location: functions/logout.php?alertmessage='.$alertmessage);
    exit();
  }
?>