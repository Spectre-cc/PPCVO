<?php
session_start();

$userID = $_SESSION['userID'];
$type = $_SESSION['type'];
$email = $_SESSION['email'];

if(empty($userID) || empty($type) || empty($email)){
    $alertmessage = urlencode("Please Log In!");
    header('Location: index.php?alertmessage='.$alertmessage);
    exit();
}
else{
    if(empty($type) || $type != 'admin'){
        $alertmessage = urlencode("Invalid credentials, Please Log In!");
        header('Location: logout.php?alertmessage='.$alertmessage);
        exit();
    }
    else{ 
    
        $query="SELECT * FROM user WHERE userid=? AND email=? AND type='admin' LIMIT 1";
    
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $query)){
            $alertmessage = urlencode("SQL error!");
            header('Location: logout.php?alertmessage='.$alertmessage);
            exit();
        }
        else{
            mysqli_stmt_bind_param($stmt, "ss", $userID, $email);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if(mysqli_num_rows($result)==1){
    
            }
            else{
                $alertmessage = urlencode("Invalid credentials, Please Log In!");
                header('Location: logout.php?alertmessage='.$alertmessage);
                exit();
            }
        }
    }
}
?>