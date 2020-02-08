<?php
    
    function error_found()
    {
      header("Location: ../error/error.html");
    }

    

    function connect() {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $database = "pizza_asap";

        //Connecting to the database 
        $conn = new mysqli($servername, $username, $password, $database); 

        date_default_timezone_set("Asia/Calcutta");
        //Check for connection errors
        if($conn->connect_errno)
        {
            echo "Connection to MySQL database failed: [" .$conn->connect_errno. "] - " .$conn->connect_error;
        }

        set_error_handler('error_found');



        return $conn;
    }
?>
