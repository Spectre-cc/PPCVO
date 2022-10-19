<?php

if(isset($_GET['alertmessage'])){
    echo '
    <script>
    alert("'.$_GET['alertmessage'].'")
    </script>
    ';
}

?>