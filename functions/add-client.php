<?php
  if(isset($_POST['add-client'])){
    //database connectionn
    require('./config/config.php');
    require('./config/db.php');
  
    //input
    $fName=mysqli_real_escape_string($conn,$_POST['fName']);
    $mName=mysqli_real_escape_string($conn,$_POST['mName']);
    $lName=mysqli_real_escape_string($conn,$_POST['lName']);
    $birthdate=mysqli_real_escape_string($conn,$_POST['birthdate']);
    $sex=mysqli_real_escape_string($conn,$_POST['sex']);
    $address=mysqli_real_escape_string($conn,$_POST['address']);
    $barangay=mysqli_real_escape_string($conn,$_POST['barangay']);
    $cNumber=mysqli_real_escape_string($conn,$_POST['cNumber']);
    $email=mysqli_real_escape_string($conn,$_POST['email']);
    session_start();
    $_SESSION["alert"]=true;
  
    //check if client already exist
    $query = "SELECT clientID FROM clients WHERE fName=? AND mName=? AND lName=?"; 
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $query)){
      $alertmessage = urlencode("SQL error!");
      header('Location: ../View-Client-List.php?alertmessage='.$alertmessage);
      exit();
    }
    else{
      mysqli_stmt_bind_param($stmt, "sss", $fName, $mName, $lName);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      if(mysqli_num_rows($result)==1){
        $alertmessage = urlencode("Client already exist!");
        header('Location: ../View-Client-List.php?alertmessage='.$alertmessage);
        exit();
      }
    }
      
    //check if barangay already exist
    $query="SELECT barangayID FROM barangays WHERE brgy_name=? LIMIT 1;";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $query)){
      $alertmessage = urlencode("SQL error!");
      header('Location: ../View-Client-List.php?alertmessage='.$alertmessage);
      exit();
    }else{
      mysqli_stmt_bind_param($stmt, "s", $barangay);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);

      //if barangay does not exist, insert new barangay name
      if(mysqli_num_rows($result)<1){
        $query = "
        INSERT INTO `barangays`(`brgy_name`) 
        VALUES (?);
        ";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $query)){
          $alertmessage = urlencode("SQL error!");
          header('Location: ../View-Client-List.php?alertmessage='.$alertmessage);
          exit();
        }else{
          mysqli_stmt_bind_param($stmt, "s", $barangay);
          mysqli_stmt_execute($stmt);
          $barangayExist=false;
        }
      }else{
        $barangayExist=true;
        foreach ($result as $data):
          $barangay=$data['barangayID'];
        endforeach;
      }
    }

    if($barangayExist==true){
      $query1 = "
      INSERT INTO `clients_addresses`(`Specific_add`, `barangayID`) 
      VALUES (?,?);
      ";
    }else{
      $query1 = "
      INSERT INTO `clients_addresses`(`Specific_add`, `barangayID`) 
      VALUES (?,LAST_INSERT_ID());
      ";
    }
    $query2 = "
      INSERT INTO `clients`(`fName`,`mName`,`lName`,`birthdate`, `sex`, `addressID`, `cNumber`, `email`) 
      VALUES (?,?,?,?,?,LAST_INSERT_ID(),?,?)
    ";
    $stmt1 = mysqli_stmt_init($conn);
    $stmt2 = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt1, $query1) || !mysqli_stmt_prepare($stmt2, $query2)){
      $alertmessage = urlencode("SQL error!");
      header('Location: ../View-Client-List.php?alertmessage='.$alertmessage);
      exit();
    }
    else{
      if($barangayExist==true){
       mysqli_stmt_bind_param($stmt1, "si", $address, $barangay);
      }else{
      mysqli_stmt_bind_param($stmt1, "s", $address);
      }
      mysqli_stmt_bind_param($stmt2, "sssssss", $fName, $mName, $lName, $birthdate, $sex, $cNumber, $email);
      mysqli_stmt_execute($stmt1);
      mysqli_stmt_execute($stmt2);
       $alertmessage = urlencode("Client has been added!");
      header('Location: ../View-Client-List.php?alertmessage='.$alertmessage);
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