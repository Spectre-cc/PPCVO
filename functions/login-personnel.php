<?php
  if(isset($_POST['login-personnel'])){
    //database connection
    require('config/config.php');
    require('config/db.php');

    //input
    $email=mysqli_real_escape_string($conn,$_POST['email']);
    $password=mysqli_real_escape_string($conn,$_POST['password']);

    //prepare sql statement before execution
    $query = "SELECT userID, fName, type, email, password FROM user WHERE email=? and type='personnel';";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt, $query)){
        $alertmessage = urlencode("SQL Error!");
        header('Location: ../index.php?alertmessage='.$alertmessage);
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
            $_SESSION['userID'] = $row['userID'];
            $_SESSION['type'] = $row['type'];
            $_SESSION['fName'] = $row['fName'];
            $_SESSION['email'] = $row['email'];
            $_SESSION["alert"]=false;
            header('Location: ../View-Client-List.php');
            exit();
          }
          else if($passwordcheck == false){
            $alertmessage = urlencode("Wrong password!");
            header('Location: ../index.php?alertmessage='.$alertmessage);
            exit();
          }
          else{
            $alertmessage = urlencode("Wrong password!");
            header('Location: ../index.php?alertmessage='.$alertmessage);
            exit();
          }
        }
        else{
          $alertmessage = urlencode("User does not exist!");
          header('Location: logout.php?alertmessage='.$alertmessage);
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