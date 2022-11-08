<?php
  if(isset($_POST['update-veterinarian'])){
    //database connectionn
    require('config/config.php');
    require('config/db.php');

    //input
    $vetID=mysqli_real_escape_string($conn,$_POST['vetID']);
    $fName=mysqli_real_escape_string($conn,$_POST['fName']);
    $mName=mysqli_real_escape_string($conn,$_POST['mName']);
    $lName=mysqli_real_escape_string($conn,$_POST['lName']);
    $licenseNo=mysqli_real_escape_string($conn,$_POST['licenseNo']);

    //check veterinarian record already exist
    $query = "SELECT * FROM veterinarian WHERE licenseNo=? AND NOT vetID=?"; 
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $query)){
      $alertmessage = urlencode("SQL error!");
      header('Location: ../Update-Veterinarian-Form.php?alertmessage='.$alertmessage.'&vetID='.$vetID);
      exit();
    }
    else{
      mysqli_stmt_bind_param($stmt, "si", $licenseNo, $vetID);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      if(mysqli_num_rows($result)==1){
        $alertmessage = urlencode("Veterinarian record already exist! Update failed...");
        header('Location: ../Update-Veterinarian-Form.php?alertmessage='.$alertmessage.'&vetID='.$vetID);
        exit();
      }
    }

    //prepare sql statement before execution
    $query = "UPDATE `veterinarian` SET fName=?, mName=?, lName=?, licenseNo=? WHERE vetID=?;";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt, $query)){
      $alertmessage = urlencode("SQL error!");
      header('Location: ../Update-Veterinarian-Form.php?alertmessage='.$alertmessage.'&vetID='.$vetID);
      exit();
    }
    else{
      mysqli_stmt_bind_param($stmt, "ssssi", $fName, $mName, $lName, $licenseNo, $vetID);
      mysqli_stmt_execute($stmt);
      $alertmessage = urlencode("Veterinarian Record has been updated!");
      header('Location: ../View-Veterinarian.php?alertmessage='.$alertmessage);
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