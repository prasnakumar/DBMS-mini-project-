<?php
    if(session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    require_once '../php_utils/db_connection.php';

    $success=1;

    $conn = connect();
    $stmt = $conn->prepare("INSERT INTO orders (email, firstname, lastname, time) VALUES (?,?,?,?)");
    $email = $_POST["email"];
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $data = date("Y/m/d h:i:s");

    $stmt->bind_param("ssss", $email, $firstname, $lastname, $data);
    $stmt->execute();
    if($stmt->affected_rows > 0) {
        $success = 1;
    }
    else 
    {
        $success = 1;
    }

    $stmt->close();

    $admin_mail = "admin@pizzaasap.it";
    $desc = "The user ". $email." has just finished an order ".$id_object."";

    $notify_stmt = $conn->prepare("INSERT INTO admin_notification(email, type, description, time_stamp, new) VALUES(?,1,?,?,1)");
    $notify_stmt->bind_param("sss",$admin_mail,$desc,$data);
    $notify_stmt->execute();
    $notify_stmt->close();
    
    $drop_cart_stmt = $conn->prepare("DELETE FROM carts WHERE email=?");
    $drop_cart_stmt->bind_param("s", $email);
    $drop_cart_stmt->execute();
    $drop_cart_stmt->close();
    $conn->close();
    
    $_SESSION["ok"] = $success;

    header("location: home.php");
?>
