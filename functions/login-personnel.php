<?php
  if(isset($_POST['login-personnel'])){
    //database connection
    require('config/config.php');
    require('config/db.php');

    //input
    $email=mysqli_real_escape_string($conn,$_POST['email']);
    $password=mysqli_real_escape_string($conn,$_POST['password']);

    //prepare sql statement before execution
    $query = "SELECT type, email, password FROM user WHERE email=? and type='personnel';";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt, $query)){
        header('Location: ../LogIn-Personnel.php?error=sqlerror');
        exit();
    }
    else{
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        //get result
        $result = mysqli_stmt_get_result($stmt);
        if($row = mysqli_fetch_assoc($result)){
          //check if password matches
          $passwordcheck = password_verify($password,$row['password']);
          if($passwordcheck == true){
            //set session variables before redirecting
            session_start();
            $_SESSION['type'] = 'personnel';
            $_SESSION['isloggedin'] = true;
            header('Location: ../Analytics.php?login=success');
            exit();
          }
          else if($passwordcheck == false){
            header('Location: ../LogIn-Personnel.php?error=wrongpassword');
            exit();
          }
          else{
            header('Location: ../LogIn-Personnel.php?error=wrongpassword');
            exit();
          }
        }
        else{
          header('Location: ../LogIn-Personnel.php?error=nouser');
          exit();
        }
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
  }
  else{
    header('Location: ../LogIn-Personnel.php');
    exit();
  }
?>