<?php
    session_start();
    
    unset($_SESSION["username"]);
    unset($_SESSION["user"]);
    unset($_SESSION["userid"]);
    unset($_SESSION["isAdmin"]);

    header('Location: login.php');
?>