<?php
session_start();
if($_SESSION['type']='personnel' && $_SESSION['isloggedin']=true){
}
else{
    $alertmessage = urlencode("Please Log In!");
    header('Location: Index.php?alertmessage='.$alertmessage);
    exit();
}
?>