<?php
    session_start();
    unset($_SESSION['adminUsername']);
     echo '<meta http-equiv="refresh" content="0;URL=index.php">';
?>