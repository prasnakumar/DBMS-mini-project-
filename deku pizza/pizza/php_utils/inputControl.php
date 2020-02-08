<?php
    require_once 'db_connection.php';

    $conn = connect();

    $query="SELECT name,description,price FROM menu WHERE ID=".$_POST["id"];
    $res = $conn->query($query);
    $row = $res->fetch_assoc();
    $result_string = $row["name"]."_";
    $result_string .= $row["price"]."_";
    $result_string .= $row["description"];
    echo $result_string;
    $conn->close();
 ?>
