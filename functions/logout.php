<?php
session_start();
session_unset();
session_destroy();
if(empty($alert=$_GET['alertmessage'])){
    header('Location: ../Index.php');
}else{
    header('Location: ../Index.php?alertmessage='.urlencode($alert));
}
?>