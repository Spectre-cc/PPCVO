<?php
session_start();
session_unset();
session_destroy();
$alert = $_GET['alertmessage'];
if($alert == false){
    header('Location: ../index.php');
}else{
    $alert = $_GET['alertmessage'];
    header('Location: ../index.php?alertmessage='.urlencode($alert));
}
?>