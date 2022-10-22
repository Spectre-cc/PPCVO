<?php
  if($_SESSION['type']='personnel' && $_SESSION['isloggedin']=true){
    if(isset($_POST['add-client'])){
      //database connectionn
      require('config/config.php');
      require('config/db.php');
  
      //input
      $name=mysqli_real_escape_string($conn,$_POST['name']);
      $birthdate=mysqli_real_escape_string($conn,$_POST['birthdate']);
      $sex=mysqli_real_escape_string($conn,$_POST['sex']);
      $barangay=mysqli_real_escape_string($conn,$_POST['barangay']);
      $contactnumber=mysqli_real_escape_string($conn,$_POST['contactnumber']);
      $email=mysqli_real_escape_string($conn,$_POST['email']);
  
      //check if client already exist
      $query = "SELECT * FROM client WHERE name=?"; 
      $stmt = mysqli_stmt_init($conn);
      if(!mysqli_stmt_prepare($stmt, $query)){
        $alertmessage = urlencode("SQL error!");
        header('Location: ../View-Client-List.php?alertmessage='.$alertmessage);
        exit();
      }
      else{
        mysqli_stmt_bind_param($stmt, "s", $name);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if(mysqli_num_rows($result)==1){
          $alertmessage = urlencode("Client already exist!");
          header('Location: ../View-Client-List.php?alertmessage='.$alertmessage);
          exit();
        }
      }
      
      //insert input into database
      //prepare sql statement before execution
      $query = "INSERT INTO `client`(`name`,`birthdate`, `sex`, `barangay`, `contactNumber`, `email`) 
      VALUES (?,?,?,?,?,?)";
      $stmt = mysqli_stmt_init($conn);
  
      if(!mysqli_stmt_prepare($stmt, $query)){
          $alertmessage = urlencode("SQL error!");
          header('Location: ../Add-Client-Form.php?alertmessage='.$alertmessage);
          exit();
      }
      else{
  
          mysqli_stmt_bind_param($stmt, "ssssss", $name, $birthdate, $sex, $barangay, $contactnumber, $email);
          mysqli_stmt_execute($stmt);
          $alertmessage = urlencode("Client has been added!");
          header('Location: ../View-Client-List.php?alertmessage='.$alertmessage);
      }
      mysqli_stmt_close($stmt);
      mysqli_close($conn);
    }
    else{
      header('Location: ../Index.php');
      exit();
    }
  }
  else{
    $alertmessage = urlencode("Please Log In!");
    header('Location: ../Index.php?alertmessage='.$alertmessage);
    exit();
  }
?>