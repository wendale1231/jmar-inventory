<?php
    include "../controller/connect.php";
    include "core.php";
    session_start();
    logs("logout", $_SESSION['user']['user_id']);
    session_destroy();
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
    header('Location: ' . $_SERVER['HTTP_REFERER']);
?>