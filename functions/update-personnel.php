<?php
  if(isset($_POST['update-personnel'])){
    //database connectionn
    require('config/config.php');
    require('config/db.php');

    //input
    $personnelID=mysqli_real_escape_string($conn,$_POST['personnelID']);
    $fName=mysqli_real_escape_string($conn,$_POST['fName']);
    $mName=mysqli_real_escape_string($conn,$_POST['mName']);
    $lName=mysqli_real_escape_string($conn,$_POST['lName']);
    $licenseNo=mysqli_real_escape_string($conn,$_POST['licenseNo']);
    $designation=mysqli_real_escape_string($conn,$_POST['designation']);

    session_start();
    $_SESSION["alert"]=true;

    //check veterinarian record already exist
    $query = "SELECT * FROM personnel WHERE licenseNo=? AND NOT personnelID=?"; 
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $query)){
      $alertmessage = urlencode("SQL error!");
      header('Location: ../Update-Personnel-Form.php?alertmessage='.$alertmessage.'&personnelID='.$personnelID);
      exit();
    }
    else{
      mysqli_stmt_bind_param($stmt, "si", $licenseNo, $personnelID);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      if(mysqli_num_rows($result)==1){
        $alertmessage = urlencode("Personnel record already exist! Update failed...");
        header('Location: ../Update-Personnel-Form.php?alertmessage='.$alertmessage.'&personnelID='.$personnelID);
        exit();
      }
    }

    //prepare sql statement before execution
    $query = "UPDATE `personnel` SET fName=?, mName=?, lName=?, licenseNo=?, designation=? WHERE personnelID=?;";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt, $query)){
      $alertmessage = urlencode("SQL error!");
      header('Location: ../Update-Personnel-Form.php?alertmessage='.$alertmessage.'&personnelID='.$personnelID);
      exit();
    }
    else{
      mysqli_stmt_bind_param($stmt, "sssssi", $fName, $mName, $lName, $licenseNo, $designation, $personnelID);
      mysqli_stmt_execute($stmt);
      $alertmessage = urlencode("Personnel Record has been updated!");
      header('Location: ../View-Personnel.php?alertmessage='.$alertmessage);
      exit();
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