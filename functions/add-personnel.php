<?php
  if(isset($_POST['add-personnel'])){
    //database connectionn
    require('./config/config.php');
    require('./config/db.php');

    //input
    $fName=mysqli_real_escape_string($conn,$_POST['fName']);
    $mName=mysqli_real_escape_string($conn,$_POST['mName']);
    $lName=mysqli_real_escape_string($conn,$_POST['lName']);
    $licenseNo=mysqli_real_escape_string($conn,$_POST['licenseNo']);
    $designation=mysqli_real_escape_string($conn,$_POST['designation']);
    session_start();
    $_SESSION["alert"]=true;

    //Check if record already exists
    $query = "SELECT licenseNo FROM personnel WHERE licenseNo=?";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt, $query)){
        $alertmessage = urlencode("SQL error!");
        header('Location: ../View-Personnel.php?alertmessage='.$alertmessage);
        exit();
    }
    else{
        mysqli_stmt_bind_param($stmt, "s", $licenseNo);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if(mysqli_num_rows($result)==1){
          $alertmessage = urlencode("Personnel record already exist!");
          header('Location: ../View-Personnel.php?alertmessage='.$alertmessage);
          exit();
        }
    }
    
    //insert input into database
    //prepare sql statement before execution
    $query = "INSERT INTO `personnel`(`fName`, `mName`, `lName`, `licenseNo`, `designation`) 
    VALUES (?,?,?,?,?)";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt, $query)){
        $alertmessage = urlencode("SQL error!");
        header('Location: ../View-Personnel.php?alertmessage='.$alertmessage);
        exit();
    }
    else{
        mysqli_stmt_bind_param($stmt, "sssss", $fName, $mName, $lName, $licenseNo, $designation);
        mysqli_stmt_execute($stmt);
        $alertmessage = urlencode("Personnel record has been added!");
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