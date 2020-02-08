<?php
    require_once 'db_connection.php';

    $email = $_POST["email"];

    $conn = connect();

    $stmt = $conn->prepare("SELECT ID,tipo,testo,giorno FROM notifiche_utente WHERE nuova=true AND email=?");

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $res = $stmt->get_result();
    //$res = $conn->query("SELECT ID, tipo, testo, giorno FROM notifiche_admin WHERE email='admin@pizzaasap.it' AND nuova=true") or die($conn->error);

    $return_string = "";

    //metto tutti gli id delle notifiche sugli array cosi posso togliere il flag "nuovo" dal db
    $id_array = array();
    $i = 0;
    //formato risposta per chiamata AJAX
    //tipo,testo,data;tipo,testo,data;tipo,testo,data;...
    while($row = $res->fetch_assoc()) {
        $return_string .= $row["tipo"];
        $return_string .= ",";
        $return_string .= $row["testo"];
        $return_string .= ",";
        $return_string .= $row["giorno"];
        $return_string .= ";";
        $id_array[$i] = $row["ID"];
        $i++;
    }
$stmt->free_result();
    //$stmt->close();
    foreach($id_array as $id) {
        $query="UPDATE notifiche_utente SET nuova=false WHERE ID=".$id;
        $conn->query($query);
    }
    $stmt->close();
    $conn->next_result();
    $conn->close();

    echo $return_string;
?>
