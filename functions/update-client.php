<?php
  if(isset($_POST['update-client'])){
    //database connection
    require('config/config.php');
    require('config/db.php');

    //input
    $addressID=mysqli_real_escape_string($conn,$_POST['addressID']);
    $clientID=mysqli_real_escape_string($conn,$_POST['clientID']);
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
    $query = "SELECT * FROM clients WHERE fName=? AND mName=? AND lName=? AND NOT clientID=?"; 
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $query)){
      $alertmessage = urlencode("SQL error!");
      header('Location: ../Update-Client-Form.php.php?alertmessage='.$alertmessage);
      exit();
    }
    else{
      mysqli_stmt_bind_param($stmt, "sssi", $fName, $mName, $lName, $clientID);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      if(mysqli_num_rows($result)==1){
        $alertmessage = urlencode("Client already exist!");
        header('Location: ../Update-Client-Form.php?alertmessage='.$alertmessage.'&clientID='.$clientID);
        exit();
      }
    }

    //check if barangay already exist
    $query="SELECT barangayID FROM barangays WHERE brgy_name=? LIMIT 1;";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $query)){
      $alertmessage = urlencode("SQL error!");
      header('Location: ../Update-Client-Form.php?alertmessage='.$alertmessage.'&clientID='.$clientID);
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
          header('Location: ../Update-Client-Form.php?alertmessage='.$alertmessage.'&clientID='.$clientID);
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
    //prepare sql statement before execution
    if($barangayExist==true){
      $query1 = "UPDATE `clients_addresses` SET Specific_add=?, barangayID=? WHERE addressID=?;";
    }else{
      $query1 = "UPDATE `clients_addresses` SET Specific_add=?, barangayID=LAST_INSERT_ID() WHERE addressID=?;";
    }
    $query2 = "UPDATE `clients` SET fName=?, mName=?, lName=?, birthdate=?, sex=?, cNumber=?, email=? WHERE clientID=?;";
    $stmt1 = mysqli_stmt_init($conn);
    $stmt2 = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt1, $query1) || !mysqli_stmt_prepare($stmt2, $query2)){
      $alertmessage = urlencode("SQL error!");
      header('Location: ../Update-Client-Form.php?alertmessage='.$alertmessage.'&clientID='.$clientID);
      exit();
    }
    else{
      if($barangayExist==true){
        mysqli_stmt_bind_param($stmt1, "sii", $address, $barangay, $addressID);
      }else{
        mysqli_stmt_bind_param($stmt1, "si", $address, $addressID);
      }
        mysqli_stmt_bind_param($stmt2, "sssssssi", $fName, $mName, $lName, $birthdate, $sex, $cNumber, $email, $clientID);
        mysqli_stmt_execute($stmt1);
        mysqli_stmt_execute($stmt2);
      $alertmessage = urlencode("Client record has been updated!");
      header('Location: ../View-Client-List.php?alertmessage='.$alertmessage);
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