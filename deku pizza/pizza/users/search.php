<?php

   

    require_once '../php_utils/db_connection.php';

    $conn = connect();
  
	$id = 2;
	$sql= "CALL `getmenu`(:id);";
	$stmt=$conn->prepare($sql);
	$stmt->bindParam(":id",$id);
	$stmt-> execute();
	$name =$stmt->fetchALL(PDO::FETCH_ASSOC);
	
	
	print_r($name); exit;

    


?>