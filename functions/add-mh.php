<?php
  if(isset($_POST['add-mh'])){
    //database connectionn
    require('./config/config.php');
    require('./config/db.php');

    $type = mysqli_real_escape_string($conn,$_POST['type']);
    session_start();
    $_SESSION["alert"]=true;
    if($type == "Animal Health"){
      //input
      $ctID = mysqli_real_escape_string($conn,$_POST['ctID']);
      $date=mysqli_real_escape_string($conn,$_POST['date']);
      $clinicalSign=mysqli_real_escape_string($conn,$_POST['clinicalSign']);
      $tentativeDiagnosis=mysqli_real_escape_string($conn,$_POST['tentativeDiagnosis']);
      $prescription=mysqli_real_escape_string($conn,$_POST['prescription']);
      $treatment=mysqli_real_escape_string($conn,$_POST['treatment']);
      $remarks=mysqli_real_escape_string($conn,$_POST['remarks']);
      $personnelID=mysqli_real_escape_string($conn,$_POST['personnelID']);
      $animalID=mysqli_real_escape_string($conn,$_POST['animalID']);
      $animalname=mysqli_real_escape_string($conn,$_POST['animalname']);

      //insert input into database
      //prepare sql statement before execution
      $query = "INSERT INTO `walk_in_transactions`(`ctID`, `date`, `clinicalSign`, `tentativeDiagnosis`, `prescription`, `treatment`, `remarks`, `personnelID`, `animalID`) 
      VALUES (?,?,?,?,?,?,?,?,?)";
      $stmt = mysqli_stmt_init($conn);
      if(!mysqli_stmt_prepare($stmt, $query)){
        $alertmessage = urlencode("SQL error!");
        header('Location: ../View-Health-History.php?alertmessage='.$alertmessage.'&animalID='.$animalID.'&animalname='.$animalname.'&type='.$type);
        exit();
      }
      else{
        mysqli_stmt_bind_param($stmt, "issssssii", $ctID, $date, $clinicalSign, $tentativeDiagnosis, $prescription, $treatment, $remarks, $personnelID, $animalID);
        mysqli_stmt_execute($stmt);
        $alertmessage = urlencode("Animal Health record has been added!");
        header('Location: ../View-Health-History.php?alertmessage='.$alertmessage.'&animalID='.$animalID.'&animalname='.$animalname.'&type='.$type);
        exit();
      }
    }
    elseif($type == "Vaccination"){
        //input
        $ctID = mysqli_real_escape_string($conn,$_POST['ctID']);
        $date=mysqli_real_escape_string($conn,$_POST['date']);
        $disease=mysqli_real_escape_string($conn,$_POST['disease']);
        $vaccineUsed=mysqli_real_escape_string($conn,$_POST['vaccineUsed']);
        $batchNumber=mysqli_real_escape_string($conn,$_POST['batchNumber']);
        $vaccineSource=mysqli_real_escape_string($conn,$_POST['vaccineSource']);
        $remarks=mysqli_real_escape_string($conn,$_POST['remarks']);
        $personnelID=mysqli_real_escape_string($conn,$_POST['personnelID']);
        $animalID=mysqli_real_escape_string($conn,$_POST['animalID']);
        $animalname=mysqli_real_escape_string($conn,$_POST['animalname']);

        $query1 = "
        INSERT INTO `vaccines`(`name`, `batchNumber`, `source`) 
        VALUES (?,?,?);";
        $query2 = "
        INSERT INTO `walk_in_transactions`(`ctID`, `date`, `disease`, `vaccineID`,`remarks`, `personnelID`, `animalID`)
        VALUES (?,?,?,LAST_INSERT_ID(),?,?,?);
        ";
        $stmt1 = mysqli_stmt_init($conn);
        $stmt2 = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt1, $query1) || !mysqli_stmt_prepare($stmt2, $query2)){
            $alertmessage = urlencode("SQL error!");
            header('Location: ../View-Health-History.php?alertmessage='.$alertmessage.'&animalID='.$animalID.'&animalname='.$animalname.'&type='.$type);
            exit();
        }
        else{
          mysqli_stmt_bind_param($stmt1, "sis", $vaccineUsed, $batchNumber, $vaccineSource);
            mysqli_stmt_bind_param($stmt2, "isssii", $ctID, $date, $disease, $remarks, $personnelID, $animalID);
            mysqli_stmt_execute($stmt1);
            mysqli_stmt_execute($stmt2);
            $alertmessage = urlencode("Vaccination record has been added!");
            header('Location: ../View-Health-History.php?alertmessage='.$alertmessage.'&animalID='.$animalID.'&animalname='.$animalname.'&type='.$type);
            exit();
        }
      
    }
    elseif($type == "Routine Service"){
      //input
      $ctID = mysqli_real_escape_string($conn,$_POST['ctID']);
      $date=mysqli_real_escape_string($conn,$_POST['date']);
      $clinicalSign=mysqli_real_escape_string($conn,$_POST['clinicalSign']);
      $activity=mysqli_real_escape_string($conn,$_POST['activity']);
      $medication=mysqli_real_escape_string($conn,$_POST['medication']);
      $remarks=mysqli_real_escape_string($conn,$_POST['remarks']);
      $personnelID=mysqli_real_escape_string($conn,$_POST['personnelID']);
      $animalID=mysqli_real_escape_string($conn,$_POST['animalID']);
      $animalname=mysqli_real_escape_string($conn,$_POST['animalname']);
      $barangay=mysqli_real_escape_string($conn,$_POST['barangay']);

      //insert input into database
      //prepare sql statement before execution

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
          INSERT INTO `field_visititations`(`ctID`, `date`, `clinicalSign`, `activity`, `medication`, `remarks`, `personnelID`, `animalID`, `barangayID`) 
          VALUES (?,?,?,?,?,?,?,?,?)
        ";
      }else{
        $query = "
          INSERT INTO `field_visititations`(`ctID`, `date`, `clinicalSign`, `activity`, `medication`, `remarks`, `personnelID`, `animalID`, `barangayID`) 
          VALUES (?,?,?,?,?,?,?,?,LAST_INSERT_ID())
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
          mysqli_stmt_bind_param($stmt, "isssssiii", $ctID, $date, $clinicalSign, $activity, $medication, $remarks, $personnelID, $animalID, $barangay);
        }else{
          mysqli_stmt_bind_param($stmt, "isssssii", $ctID, $date, $clinicalSign, $activity, $medication, $remarks, $personnelID, $animalID);
        }
        mysqli_stmt_execute($stmt);
        $alertmessage = urlencode("Routine Service record has been added!");
        header('Location: ../View-Health-History.php?alertmessage='.$alertmessage.'&animalID='.$animalID.'&animalname='.$animalname.'&type='.$type);
        exit();
      }
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
  }
  else{
    $alertmessage = urlencode("Invalid link! Logging out...");
    header('Location: logout.php?alertmessage='.$alertmessage);
    exit();
  }
?>