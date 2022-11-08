<?php
  require('config/config.php');
  require('config/db.php');
  include('checksession-admin.php');

      //input
      $vetID=mysqli_real_escape_string($conn,$_GET['vetID']);
      
      //delete input into database
      //prepare sql statement before execution
      $query = "DELETE FROM `veterinarian` WHERE vetID=?;";
      $stmt = mysqli_stmt_init($conn);

      if(!mysqli_stmt_prepare($stmt, $query)){
          $alertmessage = urlencode("SQL error!");
          header('Location: ../View-Veterinarian.php?alertmessage='.$alertmessage);
          exit();
      }
      else{
          mysqli_stmt_bind_param($stmt, "s", $vetID);
          mysqli_stmt_execute($stmt);
          $alertmessage = urlencode("Veterinarian record has been deleted!");
          header('Location: ../View-Veterinarian.php?alertmessage='.$alertmessage);
          exit();
      }
      mysqli_stmt_close($stmt);
      mysqli_close($conn);
?>