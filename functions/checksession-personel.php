<?php
session_start();
if($_SESSION['type']='personnel' && $_SESSION['isloggedin']=true){
}
else{
    header('Location: LogIn-Personnel.php?message=plslogin');
    exit();
}
?>