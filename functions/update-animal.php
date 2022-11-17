<?php
  if(isset($_POST['update-animal'])){
    //database connection
    require('config/config.php');
    require('config/db.php');

    //input

    $animalID=mysqli_real_escape_string($conn,$_POST['animalID']);
    $name=mysqli_real_escape_string($conn,$_POST['name']);
    $classificationID=mysqli_real_escape_string($conn,$_POST['classificationID']);
    $species=mysqli_real_escape_string($conn,$_POST['species']);
    $breed=mysqli_real_escape_string($conn,$_POST['breed']);
    $color=mysqli_real_escape_string($conn,$_POST['color']);
    $sex=mysqli_real_escape_string($conn,$_POST['sex']);
    $birthdate=mysqli_real_escape_string($conn,$_POST['birthdate']);
    $noHeads=mysqli_real_escape_string($conn,$_POST['noHeads']);
    $regDate=mysqli_real_escape_string($conn,$_POST['regDate']);
    $regNumber=mysqli_real_escape_string($conn,$_POST['regNumber']);
    $clientID=mysqli_real_escape_string($conn,$_POST['clientID']);
    $clientname=mysqli_real_escape_string($conn,$_POST['clientname']);

    session_start();
    $_SESSION["alert"]=true;

    //check if animal already exist
    $query = "SELECT * FROM animals WHERE name=? AND clientID=? AND NOT animalID=?"; 
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $query)){
      $alertmessage = urlencode("SQL error!");
      header('Location: ../Update-Animal-Form.php?alertmessage='.$alertmessage.'&clientID='.$clientID.'&animalID='.$animalID.'&clientname='.$clientname);
      exit();
    }
    else{
      mysqli_stmt_bind_param($stmt, "sii", $name, $clientID, $animalID);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      if(mysqli_num_rows($result)==1){
        $alertmessage = urlencode("Animal already exist!");
        header('Location: ../Update-Animal-Form.php?alertmessage='.$alertmessage.'&clientID='.$clientID.'&animalID='.$animalID.'&clientname='.$clientname);
        exit();
      }
    }

    //prepare sql statement before execution
    $query1 = "UPDATE `classifications` SET species=?, breed=? WHERE classificationID=?";
    $query2 = "UPDATE `animals` SET name=?, color=?, sex=?, birthdate=?, noHeads=?, regDate=?, regNumber=? WHERE animalID=? AND clientID=?;";
    $stmt1 = mysqli_stmt_init($conn);
    $stmt2 = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt1, $query1) || !mysqli_stmt_prepare($stmt2, $query2)){
      $alertmessage = urlencode("SQL error!");
      header('Location: ../Update-Animal-Form.php?alertmessage='.$alertmessage.'&clientID='.$clientID.'&animalID='.$animalID.'&clientname='.$clientname);
      exit();
    }
    else{
      mysqli_stmt_bind_param($stmt1, "ssi", $species, $breed, $classificationID);
      mysqli_stmt_bind_param($stmt2, "sssssssii", $name, $color, $sex, $birthdate, $noHeads, $regDate, $regNumber, $animalID, $clientID);
      mysqli_stmt_execute($stmt1);
      mysqli_stmt_execute($stmt2);
      $alertmessage = urlencode("Animal record has been updated!");
      header('Location: ../View-Animals-Owned.php?alertmessage='.$alertmessage.'&clientID='.$clientID.'&clientname='.$clientname);
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