<?php
session_start();
if($_SESSION['type']='admin' && $_SESSION['isloggedin']=true){
}
else{
    header('Location: LogIn-Admin.php?message=plslogin');
    exit();
}
?>