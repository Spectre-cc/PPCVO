<?php

if(isset($_GET['alertmessage'])){
    if($_SESSION["alert"]==true){
        echo '
        <script>
        alert("'.$_GET['alertmessage'].'")
        </script>
        ';
        $_SESSION["alert"]=false;
    }
}

?>