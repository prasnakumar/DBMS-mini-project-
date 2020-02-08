<?php 
$conn =mysqli_connect("localhost","root","","pizza_asap");
if($conn-> connect_error){
	die("connection failed:".$conn -> connect_error);
}
$sql="select l.email,m.name,l.qty from logs l,menu m where l.id_object=m.ID";
$result= $conn-> query($sql);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="author" content="PS">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <meta name="description" content="Online Pizza Delivery">
        <meta name="keywords" content="online,pizza,pasta">
        <link rel="icon" href="../favicon.ico" type="image/x-icon">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
        <link rel="stylesheet" type="text/css" href="../styles/customBgJumbo.css">
        <link rel="stylesheet" type="text/css" href="../styles/home.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
        <script src="../scripts/smoothScrolling.js"></script>
        <link rel="stylesheet" type="text/css" href="../styles/account.css">
        <link rel="stylesheet" type="text/css" href="../styles/notifications.css">
        <!--<script src="../scripts/notifications.js"></script> -->

        <title>Notifications</title>
    </head>
    <body>
        <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
            <a href="#top" class="navbar-brand">Pizza ASAP!</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="navbar-collapse collapse justify-content-stretch" id="navbarCollapse">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="adminWelcome.php">Home  <span class="fas fa-home"></span></a>
                    </li>
                  <li>
                    <a class="nav-link" href="settings.php">Settings  <span class="fas fa-wrench"></span></a>
                </li>
                <li class="nav-item">
                    <input type="hidden" id="mail-field" value="<?= $_SESSION["admin"]?>">
                    <input type="hidden" id="is-admin" value="true">
                    <a class="nav-link active" href="#top">Notifications  <span class="fas fa-bell" id="bell-icon"></span><span class="hidden badge badge-pill badge-danger" id="bell-count">0</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../php_utils/logout.php">Logout  <span class="fas fa-sign-out-alt"></span></a>
                </li>
                </ul>
            </div>
        </nav>
        <div id="wrapper">
            <div id="header">
                <div class="bg">
                    <div class="jumbotron jumbotron-fluid">
                        <h1 >Notifications</h1>
                    </div>
                </div>
            </div>

            <div class="content container">
                <div class="container-fluid bg-grey rounded">
                 <form action= "notifications.php" method= "post">
                    <h2>Notifications</h2>
                    <hr class="mb-4">
                        <div class="notifications-container">	
                       			<table style="width:100%" border="1">
						<tr>
						<th>email</th>
						<th>description</th>
						<th>qty</th></tr>		
						<?php
						if($result-> num_rows >0)
						{while($row =$result-> fetch_assoc()){
								echo "<tr><td>". $row["email"]."</td> <td>".$row["name"]."</td><td>".$row["qty"]."</td></tr>";
						}
        echo"</table>";
						}
         else { echo "0 result";
    }
               $conn -> close();
					?>
					</table>
                        <div class= "row text-center">
						
                          <div class= "col-md-12 align-self-center">
						 <a href="delete1.php"
							 input type= "submit" class= "btn btn-danger"> Clear All Notifications</a>
							 

                          </div>
                        </div>
                    </div>
                    <input type= "hidden" id= "cancel" value= "cancel" name= "cancel">
                  </form>
                </div>
            </div>
            <div id="footer">
                <footer class="container-fluid text-center">
                    <div class="row align-item-center footer-row">
                        <div class="col-md-12 align-self-center">
                            <a href="#top" title="To Top">
                                <span class="fas fa-chevron-up" style="color:white"></span>
                            </a>
                        </div>
                    </div>
                    <div class="row align-item-center">
                        <div class="col-md-12 align-self-center">
                            <p class="copyright">
                                lastbench@gmail.com
                            </p>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
    </body>
</html>
