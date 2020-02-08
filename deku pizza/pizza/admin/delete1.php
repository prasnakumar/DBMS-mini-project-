<?php
						$conn =mysqli_connect("localhost","root","","pizza_asap");
 
 mysqli_select_db($conn,'pizza_asap');
 
 $sql = " DELETE from logs where email=email";

 if(mysqli_query($conn,$sql))
	  header("refresh:1 url=notifications.php");
  else 
	  echo" not deleted";
 
	?>
	