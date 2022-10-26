<?php
  if($_SESSION['type']='personnel' && $_SESSION['isloggedin']=true){
    if(isset($_POST['add-animal'])){
      //database connectionn
      require('config/config.php');
      require('config/db.php');
  
      //input
      $name=mysqli_real_escape_string($conn,$_POST['name']);
      $species=mysqli_real_escape_string($conn,$_POST['species']);
      $breed=mysqli_real_escape_string($conn,$_POST['breed']);
      $color=mysqli_real_escape_string($conn,$_POST['color']);
      $sex=mysqli_real_escape_string($conn,$_POST['sex']);
      $birthdate=mysqli_real_escape_string($conn,$_POST['birthdate']);
      $numberHeads=mysqli_real_escape_string($conn,$_POST['numberHeads']);
      $registrationdate=mysqli_real_escape_string($conn,$_POST['registrationdate']);
      $registrationnumber=mysqli_real_escape_string($conn,$_POST['registrationnumber']);
      $clientid=mysqli_real_escape_string($conn,$_POST['clientid']);
      $clientname=mysqli_real_escape_string($conn,$_POST['clientname']);
  
      //check if animal already exist
      $query = "SELECT * FROM animal WHERE name=? AND clientid=?"; 
      $stmt = mysqli_stmt_init($conn);
      if(!mysqli_stmt_prepare($stmt, $query)){
        $alertmessage = urlencode("SQL error!");
        header('Location: ../Add-Animal-Form.php?alertmessage='.$alertmessage.'&clientid='.$clientid.'&clientname='.$clientname);
        exit();
      }
      else{
        mysqli_stmt_bind_param($stmt, "si", $name, $clientid);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if(mysqli_num_rows($result)==1){
          $alertmessage = urlencode("Animal already exist!");
          header('Location: ../Add-Animal-Form.php?alertmessage='.$alertmessage.'&clientid='.$clientid.'&clientname='.$clientname);
          exit();
        }
      }
      
      //insert input into database
      //prepare sql statement before execution
      $query = "INSERT INTO `animal`(`name`,`species`, `breed`, `color`, `sex`, `birthdate`, `numberHeads`, `registrationDate`, `registrationNumber`, `clientID`) 
      VALUES (?,?,?,?,?,?,?,?,?,?)";
      $stmt = mysqli_stmt_init($conn);
  
      if(!mysqli_stmt_prepare($stmt, $query)){
          $alertmessage = urlencode("SQL error!");
          header('Location: ../Add-Animal-Form.php?alertmessage='.$alertmessage.'&clientid='.$clientid.'&clientname='.$clientname);
          exit();
      }
      else{
          mysqli_stmt_bind_param($stmt, "sssssssssi", $name, $species, $breed, $color, $sex, $birthdate, $numberHeads, $registrationdate, $registrationnumber, $clientid);
          mysqli_stmt_execute($stmt);
          $alertmessage = urlencode("Animal has been added!");
          header('Location: ../View-Animals-Owned.php?alertmessage='.$alertmessage.'&clientid='.$clientid.'&clientname='.$clientname);
          exit();
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