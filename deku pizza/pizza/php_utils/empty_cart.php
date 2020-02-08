<?php

    require_once 'db_connection.php';

    if(session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    $conn = connect();

    $stmt = $conn->prepare("DELETE FROM carts WHERE email=?");
    $email = $_SESSION["user"];
    $stmt->bind_param("s", $email);
    $stmt->execute();

    header("location: ../users/home.php");
    die();

?>
