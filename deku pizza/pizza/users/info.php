<?php
    require_once '../php_utils/db_connection.php';

    if(session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    $conn = connect();

    $email = $_SESSION["user"];
    //Session Management

    $cart_items = 0;
    $hidden = "hidden";
    $cart_stmt = $conn->prepare("SELECT qty FROM carts WHERE email=?");
    $cart_stmt->bind_param("s", $email);
    $cart_stmt->execute();
    $cart_stmt->store_result();
    $cart_stmt->bind_result($qty);
    if($cart_stmt->num_rows > 0) {
        $hidden = "";
        while($cart_stmt->fetch()) {
            $cart_items += $qty;
        }
    }
    $cart_stmt->close();
 ?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="author" content="PS">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <meta name="description" content="Online Pizza Delivery">
        <meta name="keywords" content="online,pizza,pasta">
        <link rel="icon" href="../images/favicon.ico" type="image/x-icon">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
        <link rel="stylesheet" type="text/css" href="../styles/customBgJumbo.css">
        <link rel="stylesheet" type="text/css" href="../styles/home.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
        <script src="../scripts/smoothScrolling.js"></script>
        <link rel="stylesheet" type="text/css" href="../styles/account.css">
        <script src="../scripts/notifications_user.js"></script>
        <title>Contact</title>
    </head>
    <body>
        <nav class="navbar fixed-top navbar-dark bg-dark navbar-expand-md">
            <a class="navbar-brand" href="#"> Deku Pizza</a>
            <div class="d-flex flex-row order-2 order-md-2 justify-content-end">
                <ul class="navbar-nav flex-row">
                    <li class="nav-item">
                        <input type="hidden" id="cart-field" name="cart-field" value="<?=$_SESSION["user"]?>">
                        <a class="btn btn-link nav-link" href="checkout.php" id="cart-link"> Cart <span class="fas fa-shopping-cart" id="cart-icon"></span><span class="<?=$hidden?> badge badge-pill badge-danger" id="cart-count"><?= $cart_items ?></span></a>
                    </li>
                </ul>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
            <div class="collapse navbar-collapse order-3 order-lg-2" id="navbarNavDropdown">
                <ul class="navbar-nav ml-auto">
                    <li>
                        <a class="nav-link active" href="home.php">Home  <span class="fas fa-home"></span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#top">Contact Us  <span class="fas fa-address-book"></span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="settings.php">Settings  <span class="fas fa-wrench"></span></a>
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
                        <h1 >Contact</h1>
						
                    </div>
					
                </div>
				
                <div class="container-fluid bg-grey" id="content">
                    <div class="row align-item-center">
                        <div class="col-md-12 align-self-center">
                            <p class="info owner">
                                <p class="h5 text-center">Deku pizza <span class="text-muted">MVJCE</span></p>
                            </p>
                        </div>
                    </div>
                    <div class="row newline align-item-center">
					
                        <div class="col-md-12 align-self-center">
						
                            <p class="h6 text-center">
							<div class="w3-content w3-display-container" >
  <img class="mySlides" src="../images/2.jpg" style="width:33%" >
  <img class="mySlides" src="1.jpg" style="width:34%">
  <img class="mySlides" src="../images/3.jpg" style="width:32%" >
  


</div>

<h1>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;LOCATION</h1>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h1><iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15551.273210367164!2d77.7620593!3d12.9834704!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xbde773e8a7f7189d!2sMVJ%20College%20of%20Engineering!5e0!3m2!1sen!2sin!4v1574348497280!5m2!1sen!2sin" width="400" height="300" frameborder="0" style="border:0;" allowfullscreen=""></iframe>

                               
   
                        </div>
                    </div>
                    <div class="row newline align-item-center">
                        <div class="col-md-12 align-self-center">
                            <p class="h6 text-center">
                                <span class="fas fa-phone" style="color:#343a40"></span>
                                +91 876217 1130

                            </p>
                        </div>
                    </div>
                    <div class="row newline align-item-center">
                        <div class="col-md-12 align-self-center">
                            <p class="h6 text-center">
                                 <span class="fas fa-map-pin" style="color:#343a40"></span>
                                MVJCE
                                  </br>

                            </p>
                        </div>
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
                                      <p>KEEP IN TOUCH <br> Email:lastbenchatm@gmail.com</p>
                                </p>
                            </div>
                        </div>
                    </footer>
                </div>
            </div>
        </div>
    </body>
</html>
