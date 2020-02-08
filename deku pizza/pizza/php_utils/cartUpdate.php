<?php
    require_once 'db_connection.php';

    if(session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    $conn = connect();

    $stmt_select = $conn->prepare("SELECT * FROM carts WHERE email=? and id_object=?");
    $email = $_POST["email"];
    $id = intval($_POST["id"]);
    $qty = $_POST["qty"];
	
	   $stmt_select = $conn->prepare("SELECT * FROM logs WHERE email=? and id_object=?");
    $email = $_POST["email"];
    $id = intval($_POST["id"]);
    $qty = $_POST["qty"];

    $stmt_select->bind_param("si", $email, $id);
    $stmt_select->execute();
    $stmt_select->bind_result($r_mail,$r_id, $r_qty);
    $stmt_select->store_result();
    $stmt_select->fetch();

    if($stmt_select->num_rows > 0) 
    { 
        // if a record of the same person already exists for the same object, 
        //update the row and calculate the new quantity
        $tot = intval($qty) + intval($r_qty);

        $stmt_update = $conn->prepare("UPDATE carts SET qty=? where email=? and id_object=?");
        $stmt_update->bind_param("isi", $tot,$email,$id);
        $stmt_update->execute();
		
		    $stmt_update = $conn->prepare("UPDATE logs SET qty=? where email=? and id_object=?");
        $stmt_update->bind_param("isi", $tot,$email,$id);
        $stmt_update->execute();

        $stmt_update->close();

    }
    else 
    {    
        $stmt_insert = $conn->prepare("INSERT INTO carts VALUES (?,?,?)"); 
        $stmt_insert->bind_param("sii", $email, $id, $qty);
        $stmt_insert->execute();
 $stmt_insert->close();
    }
$stmt_insert = $conn->prepare("INSERT INTO logs VALUES (?,?,?)"); 
        $stmt_insert->bind_param("sii", $email, $id, $qty);
        $stmt_insert->execute();
 $stmt_insert->close();

    $conn->close();

?>
