<?php
  if($_SESSION['type']='admin' && $_SESSION['isloggedin']=true){

    $userid = $_GET['user'];
    $type = $_GET['type'];
    if(empty($userid) && empty($type)){
        $alertmessage = urlencode("Invalid link! Logging out...");
        header('Location: logout.php?alertmessage'.$alertmessage);
        exit();
    }
    else{
      //database connectionn
      require('config/config.php');
      require('config/db.php');

      //input
      $userid=mysqli_real_escape_string($conn,$_GET['user']);
      $type=mysqli_real_escape_string($conn,$_GET['type']);
      
      //delete input into database
      //prepare sql statement before execution
      $query = "DELETE FROM `user` WHERE userid=? AND type=? ;";
      $stmt = mysqli_stmt_init($conn);

      if(!mysqli_stmt_prepare($stmt, $query)){
          $alertmessage = urlencode("SQL error!");
          if($type="personnel"){
            header('Location: ../View-Users-Personnel.php?alertmessage='.$alertmessage);
            exit();
          }
          else if($type="admin"){
            header('Location: ../View-Users-Admin.php?alertmessage='.$alertmessage);
            exit();
          }
          else{
            $alertmessage = urlencode("Invalid link! Logging out...");
            header('Location: logout.php?alertmessage='.$alertmessage);
            exit();
          }
      }
      else{
          mysqli_stmt_bind_param($stmt, "is", $userid, $type);
          mysqli_stmt_execute($stmt);
          $alertmessage = urlencode("User has been deleted!");
          if($type="personnel"){
            header('Location: ../View-Users-Personnel.php?alertmessage='.$alertmessage);
            exit();
          }
          else if($type="admin"){
            header('Location: ../View-Users-Admin-.php?alertmessage='.$alertmessage);
            exit();
          }
          else{
            $alertmessage = urlencode("Invalid link! Logging out...");
            header('Location: logout.php?alertmessage='.$alertmessage);
            exit();
          }
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