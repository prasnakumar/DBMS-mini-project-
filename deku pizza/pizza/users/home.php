<?php

    if(session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    if(!isset($_SESSION["user"])) {
        header("location: userlogin.php");
        die();
    }

    require_once '../php_utils/db_connection.php';

    $conn = connect();
    $query = "select * from menu where id_category=1";
    $classic = $conn->query($query);

    $query = "select * from menu where id_category=2";
    $special = $conn->query($query);

    $query = "select * from menu where id_category=3";
    $calzone = $conn->query($query);

    $query = "select * from menu where id_category=4";
    $sodas = $conn->query($query);

    //ciclo per icona carrello

    $email = $_SESSION["user"];
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
        <meta name="description" content="Online Food Delivery">
        <meta name="keywords" content="online,pizza,pasta">
        <link rel="icon" href="../iamges/favicon.ico" type="image/x-icon">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
        <link rel="stylesheet" type="text/css" href="../styles/customBgJumbo.css">
        <link rel="stylesheet" type="text/css" href="../styles/home.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
        <script src="../scripts/smoothScrolling.js"></script>
        <script src="../scripts/shopping.js"></script>
        <script src="../scripts/notifications_user.js"></script>
        <title>Home</title>
    </head>
    <body>
        <nav class="navbar fixed-top navbar-dark bg-dark navbar-expand-md">
            <a class="navbar-brand" href="#">Deku Pizza</a>
            <div class="d-flex flex-row order-2 order-md-2 justify-content-end">
                <ul class="navbar-nav flex-row">
                    <li class="nav-item">
                        <input type="hidden" id="cart-field" name="cart-field" value="<?=$_SESSION["user"]?>">
                        <a class="btn btn-link nav-link" href="checkout.php" id="cart-link">View Cart and Checkout <span class="fas fa-shopping-cart" id="cart-icon"></span><span class="<?=$hidden?> badge badge-pill badge-danger" id="cart-count"><?= $cart_items ?></span></a>
                    </li>
                </ul>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
            <div class="collapse navbar-collapse order-3 order-lg-2" id="navbarNavDropdown">
                <ul class="navbar-nav ml-auto">
                    <li>
                        <a class="nav-link active" href="#top">Home  <span class="fas fa-home"></span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="info.php">Contact Us  <span class="fas fa-address-book"></span></a>
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
                        <h1 > Deku Pizza </h1>
                    </div>
                </div>
            </div>
            <div id="content"><?php
                if(isset($_SESSION["ok"])) {
                    if($_SESSION["ok"] == 1) {
                        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                Order Completed Successfully.
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>';
                    } else {
                        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
      Order  Failed.
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>';

                    }
                    unset($_SESSION["ok"]);
                }
            ?>
			 <a href="search.php" input type= "submit" class= "btn " background-color="blue"> search</a>
                <div class="container-fluid menu">
                    <div class="row">
                        <div class="col-md-4 offset-md-4 center-block text-center">
                            <h2 class="display-3" id="menu">Menu</h2>
                        </div>
                        <div class="col-md-4 navigation align-self-end">
                            <p>
                                <a href="#pizza-classic">Pizza Classic</a> | <a href="#pizza-special">Pizza Special</a> | <a href="#calzone">Calzone</a> | <a href="#sodas">Sodas</a>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="container-fluid classiche">
                    <div class="row align-items-start">
                        <div class="col-md-10 offset-md-1">
                            <div class="header-categoria" id="pizza-classic">
                                <h3>Pizza Classic</h3>
                            </div>
                        </div>
                    </div>
                    <?php
                    $count = 0;
                    while($row = $classic->fetch_assoc()) {
                        if($count % 2 === 0) {
                            echo '<div class="row newline bg-grey align-items-start">';
                        }
                        else {
                            echo '<div class="row newline align-items-start">';
                        };
                        echo '  <div class="col-md-6 offset-md-2">
                                    <div class="row">
                                        <h4 class="prod-title">'.$row["name"].'</h4>
                                    </div>

                                    <div class="row">
                                        <p class="prod-description">
                                            '.$row["description"].'
                                        </p>
                                    </div>
                                </div>

                                <div class="col-md-1 align-self-center">
                                    <p class="prezzo">
                                        ₹'.$row["price"].'
                                    </p>
                                </div>

                                <div class="col-md-1 align-self-center">
                                    <button class="btn btn-primary dropdown-toggle" type="button" id="dropDownMenuButton-'.$row["ID"].'" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">+</button>
                                    <div class="dropdown-menu cart-menu" aria-labelledby="dropDownMenuButton-'.$row["ID"].'">
                                        <div class="row">
                                            <div class="col-md-1">
                                                <span>Quantity?</span>
                                            </div>
                                            <div class="col-md-11 mb-3">
                                                <input class="form-control qty-input" min="1" type="number" title="prod-quantity" id="qty-'.$row["ID"].'" value="1">
                                            </div>
                                        </div>
                                    <div class="row justify-content-center mb-4">
                                        <button class="btn btn-success" type="button" id="ok-'.$row["ID"].'" onclick="addToCart('.$row["ID"].')">Confirm</button>
                                    </div>
                                </div>
                            </div>
                        </div>';
                    $count++;
                    }
                    ?>

                </div>
                <div class="container-fluid speciali">
                    <div class="row align-items-start">
                        <div class="col-md-10 offset-md-1">
                            <div class="header-categoria" id="pizza-special">
                                <h3>Pizza Special</h3>
                            </div>
                        </div>
                    </div>
                    <?php
                    $count = 0;
                    while($row = $special->fetch_assoc()) {
                        if($count % 2 === 0) {
                            echo '<div class="row newline bg-grey align-items-start">';
                        }
                        else
                        {
                            echo '<div class="row newline align-items-start">';
                        };
                        echo '  <div class="col-md-6 offset-md-2">
                                    <div class="row">
                                    <h4 class="prod-title">'.$row["name"].'</h4>
                                    </div>
                                    <div class="row">
                                        <p class="prod-description">'.$row["description"].'
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-1 align-self-center">
                                    <p class="prezzo">
                                        ₹'.$row["price"].'
                                    </p>
                                </div>
                                <div class="col-md-1 align-self-center">
                                    <button class="btn btn-primary dropdown-toggle" type="button" id="dropDownMenuButton-'.$row["ID"].'" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">+</button>
                                    <div class="dropdown-menu cart-menu" aria-labelledby="dropDownMenuButton-'.$row["ID"].'">
                                        <div class="row">
                                            <div class="col-md-1">
                                                <span>Quantity?</span>
                                            </div>
                                        <div class="col-md-11 mb-3">
                                            <input class="form-control qty-input" min="1" type="number" title="prod-quantity" id="qty-'.$row["ID"].'" value="1">
                                        </div>
                                    </div>
                                    <div class="row justify-content-center mb-4">
                                        <button class="btn btn-success" type="button" id="ok-'.$row["ID"].'" onclick="addToCart('.$row["ID"].')">Confirm</button>
                                    </div>
                                </div>
                            </div>
                        </div>';
                    $count++;
                    }
                    ?>
                </div>
                <div class="container-fluid classiche">
                    <div class="row align-items-start">
                        <div class="col-md-10 offset-md-1">
                            <div class="header-categoria" id="calzone">
                                <h3>Calzone</h3>
                            </div>
                        </div>
                    </div>
                    <?php
                    $count = 0;
                    while($row = $calzone->fetch_assoc()) {
                        if($count % 2 === 0)
                        {
                            echo '<div class="row newline bg-grey align-items-start">';
                        }
                        else
                        {
                            echo '<div class="row newline align-items-start">';
                        };
                        echo    '<div class="col-md-6 offset-md-2">
                                    <div class="row">
                                        <h4 class="prod-title">'.$row["name"].'</h4>
                                    </div>
                                    <div class="row">
                                        <p class="prod-description">
                                          '.$row["description"].'
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-1 align-self-center">
                                    <p class="prezzo">
                                        ₹'.$row["price"].'
                                    </p>
                                </div>
                                <div class="col-md-1 align-self-center">
                                    <button class="btn btn-primary dropdown-toggle" type="button" id="dropDownMenuButton-'.$row["ID"].'" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">+</button>
                                    <div class="dropdown-menu cart-menu" aria-labelledby="dropDownMenuButton-'.$row["ID"].'">
                                        <div class="row">
                                            <div class="col-md-1">
                                                <span>Quantity?</span>
                                            </div>
                                        <div class="col-md-11 mb-3">
                                            <input class="form-control qty-input" min="1" type="number" title="prod-quantity" id="qty-'.$row["ID"].'" value="1">
                                        </div>
                                    </div>

                                    <div class="row justify-content-center mb-4">
                                       <button class="btn btn-success" type="button" id="ok-'.$row["ID"].'" onclick="addToCart('.$row["ID"].')">Confirm</button>
                                    </div>
                                </div>
                            </div>
                        </div>';
                    $count++;
                    }
                    ?>
                </div>
                <div class="container-fluid classiche">
                    <div class="row align-items-start">
                        <div class="col-md-10 offset-md-1">
                            <div class="header-categoria" id="sodas">
                                <h3>Soda</h3>
                            </div>
                        </div>
                    </div>
                    <?php
                    $count = 0;
                    while($row = $sodas->fetch_assoc()) {
                        if($count % 2 === 0) {
                            echo '<div class="row newline bg-grey align-items-start">';
                        }
                        else {
                            echo '<div class="row newline align-items-start">';
                        };
                        echo    '<div class="col-md-6 offset-md-2">
                                    <div class="row">
                                        <h4 class="prod-title">'.$row["name"].'</h4>
                                    </div>
                                </div>

                                <div class="col-md-1 align-self-center">
                                    <p class="prezzo">
                                        ₹'.$row["price"].'
                                    </p>
                                </div>

                                <div class="col-md-1 align-self-center">
                                    <button class="btn btn-primary dropdown-toggle" type="button" id="dropDownMenuButton-'.$row["ID"].'" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">+</button>
                                    <div class="dropdown-menu cart-menu" aria-labelledby="dropDownMenuButton-'.$row["ID"].'">
                                        <div class="row">
                                            <div class="col-md-1">
                                                <span>Quantity?</span>
                                            </div>
                                            <div class="col-md-11 mb-3">
                                                <input class="form-control qty-input" min="1" type="number" title="prod-quantity" id="qty-'.$row["ID"].'" value="1">
                                            </div>
                                        </div>
                                        <div class="row justify-content-center mb-4">
                                            <button class="btn btn-success" type="button" id="ok-'.$row["ID"].'" onclick="addToCart('.$row["ID"].')">Confirm</button>
                                        </div>
                                    </div>
                                </div>
                            </div>';
                    $count++;
                    }
                    ?>
                </div>
            </div>
			<div>

			
			 </div>
            <div id="footer">
                <footer class="container-fluid text-center">
                    <div class="row align-item-center footer-row">

                        </div>
                        <div >
                            <div class="col-md-12 align-self-center">
                                <p class="copyright">
                                    <p>KEEP IN TOUCH <br> Email:lastbenchatm@gmail.com</p>
                                </p>
                            </div>
                        </div>
                    </footer>
                </div>
            </div>
    </body>
</html>
