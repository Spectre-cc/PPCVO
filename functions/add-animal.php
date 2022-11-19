<?php
  if(isset($_POST['add-animal'])){
    //database connectionn
    require('config/config.php');
    require('config/db.php');
  
    //input
    $name=mysqli_real_escape_string($conn,$_POST['name']);
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
    $query = "SELECT * FROM animals WHERE name=? AND clientID=?"; 
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $query)){
      $alertmessage = urlencode("SQL error!");
      header('Location: ../View-Animals-Owned.php?alertmessage='.$alertmessage.'&clientID='.$clientID.'&clientname='.$clientname);
      exit();
    }
    else{
      mysqli_stmt_bind_param($stmt, "si", $name, $clientID);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      if(mysqli_num_rows($result)==1){
        $alertmessage = urlencode("Animal already exist!");
        header('Location: ../View-Animals-Owned.php?alertmessage='.$alertmessage.'&clientID='.$clientID.'&clientname='.$clientname);
        exit();
      }
    }
      
    //insert input into database
    //prepare sql statement before execution
    $query1 = "
    INSERT INTO `classifications`(`species`,`breed`) 
      VALUES(?,?);
    ";
    $query2 = "
    INSERT INTO `animals`(`name`,`classificationID`, `color`, `sex`, `birthdate`, `noHeads`, `regDate`, `regNumber`, `clientID`) 
      VALUES(?,LAST_INSERT_ID(),?,?,?,?,?,?,?);
    ";
    $stmt1 = mysqli_stmt_init($conn);
    $stmt2 = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt1, $query1) || !mysqli_stmt_prepare($stmt2, $query2)){
      $alertmessage = urlencode("SQL error!");
        header('Location: ../View-Animals-Owned.php?alertmessage='.$alertmessage.'&clientID='.$clientID.'&clientname='.$clientname);
        exit();
    }
    else{
      mysqli_stmt_bind_param($stmt1, "ss", $species, $breed);
      mysqli_stmt_bind_param($stmt2, "ssssissi", $name, $color, $sex, $birthdate, $noHeads, $regDate, $regNumber, $clientID);
      mysqli_stmt_execute($stmt1);
      mysqli_stmt_execute($stmt2);
      $alertmessage = urlencode("Animal has been added!");
      header('Location: ../View-Animals-Owned.php?alertmessage='.$alertmessage.'&clientID='.$clientID.'&clientname='.$clientname);
      exit();
    }
    mysqli_stmt_close($stmt1);
    mysqli_stmt_close($stmt2);
    mysqli_close($conn);
  }
  else{
    header('Location: ../Index.php');
    exit();
  }
?>