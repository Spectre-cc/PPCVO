<?php
  if(isset($_POST['add-veterinarian'])){
    //database connectionn
    require('config/config.php');
    require('config/db.php');

    //input
    $fName=mysqli_real_escape_string($conn,$_POST['fName']);
    $mName=mysqli_real_escape_string($conn,$_POST['lName']);
    $lName=mysqli_real_escape_string($conn,$_POST['mName']);
    $licenseNo=mysqli_real_escape_string($conn,$_POST['licenseNo']);

    //Check if record already exists
    $query = "SELECT * FROM veterinarian WHERE licenseNo=?";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt, $query)){
        $alertmessage = urlencode("SQL error!");
        header('Location: ../Add-Veterinarian-Form.php?alertmessage='.$alertmessage);
        exit();
    }
    else{
        mysqli_stmt_bind_param($stmt, "s", $licenseNo);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if(mysqli_num_rows($result)==1){
          $alertmessage = urlencode("Veterinarian record already exist!");
          header('Location: ../Add-Veterinarian-Form.php?alertmessage='.$alertmessage);
          exit();
        }
    }
    
    //insert input into database
    //prepare sql statement before execution
    $query = "INSERT INTO `veterinarian`(`fName`, `mName`, `lName`, `licenseNo`) 
    VALUES (?,?,?,?)";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt, $query)){
        $alertmessage = urlencode("SQL error!");
        header('Location: ../Add-Veterinarian-Form.php?alertmessage='.$alertmessage);
        exit();
    }
    else{
        mysqli_stmt_bind_param($stmt, "ssss", $fName, $mName, $lName, $licenseNo);
        mysqli_stmt_execute($stmt);
        $alertmessage = urlencode("Veterinarian record has been added!");
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