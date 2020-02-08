<?php
    // include the db_connection.php file which has all the connection parameters
    require_once 'db_connection.php';

    function check_for_notifications($email, $isAdmin) {
        $table = "";
        if($isAdmin == TRUE) {
            $table = "admin_notification";
        }else {
            $table = "user_notification";
        }
        $query = "SELECT ID FROM ".$table." WHERE new=true AND email=?";
        $conn = connect();

        $stmt = $conn->prepare($query);

        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($id);
        $affected = 0;
        while($stmt->fetch()) {
            $affected = $stmt->num_rows;
            $query = "UPDATE TABLE " .$table. " SET new=false WHERE ID=".$id;
            $res = $conn->query($query);
        }
        $stmt->close();
        $conn->close();
        return $affected;
    }
?>
