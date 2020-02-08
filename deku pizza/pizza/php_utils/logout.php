<?php
if(session_status() == PHP_SESSION_NONE) {
    session_start();
}

// remove all session variables
session_unset();

// destroy the session
session_destroy();

header('location: ../users/userlogin.php');
die();
 ?>
