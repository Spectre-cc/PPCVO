<?php
  if($_SESSION['type']='personnel' && $_SESSION['isloggedin']=true){

    $clientid = $_GET['clientid'];
    if(empty($clientid)){
        $alertmessage = urlencode("Invalid link! Logging out...");
        header('Location: logout.php?alertmessage'.$alertmessage);
        exit();
    }
    else{
      //database connectionn
      require('config/config.php');
      require('config/db.php');

      //input
      $clientid=mysqli_real_escape_string($conn,$clientid);
      
      //delete input into database
      //prepare sql statement before execution
      $query = "DELETE FROM `client` WHERE clientID=?;";
      $stmt = mysqli_stmt_init($conn);

      if(!mysqli_stmt_prepare($stmt, $query)){
          $alertmessage = urlencode("SQL error!");
          header('Location: ../View-Client-List.php?alertmessage='.$alertmessage);
      }
      else{
          mysqli_stmt_bind_param($stmt, "i", $clientid);
          mysqli_stmt_execute($stmt);
          $alertmessage = urlencode("User has been deleted!");
          header('Location: ../View-Client-List.php?alertmessage='.$alertmessage);
      }
      mysqli_stmt_close($stmt);
      mysqli_close($conn);
    }
  }
  else{
    $alertmessage = urlencode("Please Log In!");
    header('Location: ../Index.php?alertmessage='.$alertmessage);
    exit();
  }
?>