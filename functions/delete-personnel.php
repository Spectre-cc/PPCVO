<?php
  require('./config/config.php');
  require('./config/db.php');
  include('./checksession-admin.php');

      //input
      $personnelID=mysqli_real_escape_string($conn,$_GET['personnelID']);
      session_start();
      $_SESSION["alert"]=true;
      
      //delete input into database
      //prepare sql statement before execution
      $query = "DELETE FROM `personnel` WHERE personnelID=?;";
      $stmt = mysqli_stmt_init($conn);

      if(!mysqli_stmt_prepare($stmt, $query)){
          $alertmessage = urlencode("SQL error!");
          header('Location: ../View-Personnel.php?alertmessage='.$alertmessage);
          exit();
      }
      else{
          mysqli_stmt_bind_param($stmt, "s", $personnelID);
          mysqli_stmt_execute($stmt);
          $alertmessage = urlencode("Personnel record has been deleted!");
          header('Location: ../View-Personnel.php?alertmessage='.$alertmessage);
          exit();
      }
      mysqli_stmt_close($stmt);
      mysqli_close($conn);
?>