<?php
  if(isset($_POST['update-animal'])){
    //database connection
    require('config/config.php');
    require('config/db.php');

    //input
    $animalid=mysqli_real_escape_string($conn,$_POST['animalid']);
    $name=mysqli_real_escape_string($conn,$_POST['name']);
    $species=mysqli_real_escape_string($conn,$_POST['species']);
    $breed=mysqli_real_escape_string($conn,$_POST['breed']);
    $color=mysqli_real_escape_string($conn,$_POST['color']);
    $sex=mysqli_real_escape_string($conn,$_POST['sex']);
    $birthdate=mysqli_real_escape_string($conn,$_POST['birthdate']);
    $numberHeads=mysqli_real_escape_string($conn,$_POST['numberHeads']);
    $registrationdate=mysqli_real_escape_string($conn,$_POST['registrationdate']);
    $registrationnumber=mysqli_real_escape_string($conn,$_POST['registrationnumber']);
    $clientid=mysqli_real_escape_string($conn,$_POST['clientid']);
    $clientname=mysqli_real_escape_string($conn,$_POST['clientname']);

    //check if animal already exist
    $query = "SELECT * FROM animal WHERE name=? AND clientID=? AND NOT animalID=?"; 
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $query)){
      $alertmessage = urlencode("SQL error!");
      header('Location: ../Update-Animal-Form.php?alertmessage='.$alertmessage.'&clientid='.$clientid.'&animalid='.$animalid.'&clientname='.$clientname);
      exit();
    }
    else{
      mysqli_stmt_bind_param($stmt, "sii", $name, $clientid, $animalid);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      if(mysqli_num_rows($result)==1){
        $alertmessage = urlencode("Animal already exist!");
        header('Location: ../Update-Animal-Form.php?alertmessage='.$alertmessage.'&clientid='.$clientid.'&animalid='.$animalid.'&clientname='.$clientname);
        exit();
      }
    }

    //prepare sql statement before execution
    $query = "UPDATE `animal` SET name=?, species=?, breed=?, color=?, sex=?, birthdate=?, vaccinationDate=?, registrationDate=?, registrationNumber=? WHERE animalID=? AND clientID=?;";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt, $query)){
      $alertmessage = urlencode("SQL error!");
      header('Location: ../Update-Animal-Form.php?alertmessage='.$alertmessage.'&clientid='.$clientid.'&animalid='.$animalid.'&clientname='.$clientname);
      exit();
    }
    else{

      mysqli_stmt_bind_param($stmt, "sssssssssii", $name, $species, $breed, $color, $sex, $birthdate, $numberHeads, $registrationdate, $registrationnumber, $animalid, $clientid);
      mysqli_stmt_execute($stmt);
      $alertmessage = urlencode("Animal record has been updated!");
      header('Location: ../View-Animals-Owned.php?alertmessage='.$alertmessage.'&clientid='.$clientid.'&clientname='.$clientname);
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