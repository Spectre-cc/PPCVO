<?php
  if(isset($_POST['add-personnel'])){
    //database connectionn
    require('config/config.php');
    require('config/db.php');

    //input
    $name=mysqli_real_escape_string($conn,$_POST['name']);
    $email=mysqli_real_escape_string($conn,$_POST['email']);
    $password=mysqli_real_escape_string($conn,$_POST['password']);
    $type="personnel";
    $contactnumber=mysqli_real_escape_string($conn,$_POST['contactnumber']);
    
    //check if email exist
    
    
    //insert input into database
    //prepare sql statement before execution
    $query = "INSERT INTO `user`(`type`,`name`, `email`, `password`, `contactNumber`) 
    VALUES (?,?,?,?,?)";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt, $query)){
        $alertmessage = urlencode("SQL error!");
        header('Location: ../Add-User-Personnel-Form.php?alertmessage'.$alertmessage);
        exit();
    }
    else{

        //hash password before insert
        $hashedpassword = password_hash($password, PASSWORD_DEFAULT);

        mysqli_stmt_bind_param($stmt, "sssss", $type, $name, $email, $hashedpassword, $contactnumber);
        mysqli_stmt_execute($stmt);
        $alertmessage = urlencode("Personnel user has been added!");
        header('Location: ../View-Users-Personnel.php?alertmessage'.$alertmessage);
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