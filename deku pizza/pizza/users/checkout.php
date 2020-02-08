<?php
    require_once '../php_utils/db_connection.php';
    require_once '../php_utils/menu_item.php';

    if(session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    if(!isset($_SESSION["user"])) {
        header("location: userlogin.php");
        die();
    }

    $conn = connect();

    $stmt = $conn->prepare("SELECT id_object, qty FROM carts WHERE email=?");
    $email = $_SESSION["user"];

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $res = $stmt->get_result();

    $cart = array();
    $pizza_data = array();
    $i = 0;
    $tot_qty = 0;

    // Fill the cart data structure
    while($row = $res->fetch_assoc()) {
        $cart[$i]["ID"] = $row["id_object"];
        $cart[$i]["qty"] = $row["qty"];
        $tot_qty += $row["qty"];
        $i++;
    }

    $stmt->close();

    $i = 0;
    //Fill the data structure with the data of the pizzas taken from the db
    foreach ($cart as $cart_item) {
        $query = "SELECT * FROM menu WHERE ID=" .$cart_item["ID"];
        $res = $conn->query($query);
        $pizza_data[$i] = $res->fetch_object('pizza');
        $i++;
    }

    $firstname;
    $lastname;

    $cc_name = "";
    $cc_num = "";
    $exp = "";
    $cvv = "";

    $user_data_stmt = $conn->prepare("SELECT firstname, lastname FROM users WHERE email=?");
    $user_data_stmt->bind_param("s", $email);
    $user_data_stmt->execute();
    $user_data_stmt->bind_result($firstname, $lastname);
    $user_data_stmt->store_result();
    $user_data_stmt->fetch();
    $user_data_stmt->close();
    $firstname_lastname = $firstname." ".$lastname;

    $pay_stmt = $conn->prepare("SELECT card_number,expiry_date,cvv FROM payment WHERE email=?");
    //Credit Card Information
    $pay_stmt->bind_param("s", $email);
    $pay_stmt->execute();
    $pay_stmt->store_result();

    if($pay_stmt->num_rows > 0) {
        $pay_stmt->bind_result($cc_num, $exp, $cvv);
        $pay_stmt->fetch();
    }
    $pay_stmt->close();

    //Cart Icon

    $cart_items = 0;
    $hidden = "hidden";
    $cart_stmt = $conn->prepare("SELECT qty FROM carts WHERE email=?");
    $cart_stmt->bind_param("s", $email);
    $cart_stmt->execute();
    $cart_stmt->store_result();
    $cart_stmt->bind_result($qty);
    if($cart_stmt->num_rows > 0)
    {
        $hidden = "";
        while($cart_stmt->fetch())
        {
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
        <link rel="icon" href="../favicon.ico" type="image/x-icon">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
        <link rel="stylesheet" type="text/css" href="../styles/customBgJumbo.css">
        <link rel="stylesheet" type="text/css" href="../styles/home.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
        <script src="../scripts/smoothScrolling.js"></script>
        <script src="../scripts/checkout.js"></script>
        <script src="../scripts/notifications_user.js"></script>

        <title>Checkout</title>
    </head>
    <body>
        <nav class="navbar fixed-top navbar-dark bg-dark navbar-expand-md">
            <a class="navbar-brand" href="#">Deku pizza</a>
            <div class="d-flex flex-row order-2 order-md-2 justify-content-end">
                <ul class="navbar-nav flex-row">
                    <li class="nav-item">
                        <input type="hidden" id="cart-field" name="cart-field" value="<?=$_SESSION["user"]?>">
                        <a class="btn btn-link nav-link active" href="#top" id="cart-link">Cart <span class="fas fa-shopping-cart" id="cart-icon"></span><span class="<?=$hidden?> badge badge-pill badge-danger" id="cart-count"><?= $cart_items ?></span></a>
                    </li>
                </ul>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
            <div class="collapse navbar-collapse order-3 order-lg-2" id="navbarNavDropdown">
                <ul class="navbar-nav ml-auto">
                    <li>
                        <a class="nav-link" href="home.php">Home  <span class="fas fa-home"></span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="info.php">Contact  <span class="fas fa-address-book"></span></a>
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
                        <h1 >Checkout</h1>
                    </div>
                </div>
            </div>
            <div id="content">
                <div class="container-fluid bg-grey">
                    <div class="row">
                        <div class="col-md-4 order-md-2 mb-4">
                            <h2 class="d-flex justify-content-between align-items-center mb-3 display-5">
                                <span>Your Food Cart</span>
                                <span class="badge badge-secondary badge-pill" id="cart-items-count"><?= $tot_qty;?></span>
                                <input type="hidden" id="cart-rows" value="<?= count($cart) ?>">
                            </h2>
                            <div class="container-fluid">
                                <ul class="list-group mb-3">
                                    <?php
                                        for ($i = 0; $i < count($cart); $i++) {
                                            echo '<li class="list-group-item d-flex justify-content-between lh-condensed row text-center" id="row-'.$i.'">
                                                <div class="col-md-4 mr-auto">
                                                    <input type="hidden" id="id-prod-row-'.$i.'" value="'.$pizza_data[$i]->ID.'">
                                                    <h3 class="prod-title">'.$pizza_data[$i]->name.'</h3>
                                                    <small class="text-muted">'.$pizza_data[$i]->description.'</small>
                                                </div>
                                                <div class="col-md-4">
                                                    <label><span class="qty text-center">₹<span id="price-per-unit-'.$i.'">'.$pizza_data[$i]->price.'</span> x <input type="number" class="form-control cart-item-quantity" id="qta-'.$i.'" value="'.$cart[$i]["qty"].'" title="quantity"></span></label>
                                                </div>
                                                <div class="col-md-3 align-self-center ml-auto justify-content-between">
                                                    <span class="text-muted ml-auto">₹ <span class="pricetag" id="pricetag-'.$i.'">'.$cart[$i]["qty"]*number_format((float)$pizza_data[$i]->price, 2, ".", "").'</span></span>
                                                </div>
                                                <div class="col-md-1 mb-1 align-self-center text-danger">
                                                    <span class ="fa fa-trash btn btn-danger del-icon" id="del-row-'.$i.'"></span>
                                                </div>
                                            </li>';
                                        }
                                    ?>
                                <li class="list-group-item d-flex justify-content-between lh-condensed row text-center">
                                    <div class="col-md-4">
                                        <span>Total (INR)</span>
                                    </div>
                                    <div class="col-md-4 offset-md-4">
                                        <span>₹ <strong id="total"></strong></span>
                                    </div>
                                </ul>
                                <div class="row text-center">
                                    <div class="col-md-4 offset-md-4 align-self-center">
                                        <a href="../php_utils/empty_cart.php" class="btn btn-danger" id="empty-cart">Empty Cart</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8 order-md-1">
                          <h4 class="mb-3">Billing Address</h4>
                          <form class="needs-validation" action="order.php" method="post" novalidate="">
                            <div class="row">
                              <div class="col-md-6 mb-3">
                                <label for="firstName">First Name</label>
                                <input type="text" class="form-control" id="firstName" placeholder="" name="firstname" value="<?= $firstname ?>" required="">
                                <div class="invalid-feedback">
                                  Please fill your First Name.
                                </div>
                              </div>
                              <div class="col-md-6 mb-3">
                                <label for="lastName">Last Name</label>
                                <input type="text" class="form-control" id="lastName" placeholder="" name="lastname" value="<?= $lastname ?>" required="">
                                <div class="invalid-feedback">
                                  Please fill your Last Name.
                                </div>
                              </div>
                            </div>

                            <div class="mb-3">
                              <label for="email">Email</label>
                              <input type="email" class="form-control" id="email" name="email" placeholder="you@example.com" value="<?= $email ?>">
                              <div class="invalid-feedback">
                                Enter a valid e-mail address.
                              </div>
                            </div>

                            <div class="mb-3">
                              <label for="address">Address</label>
                              <input type="text" class="form-control" id="address" name="address" >
                              <div class="invalid-feedback">
                                Enter a valid address for delivery.
                              </div>
                            </div>
                            <hr class="mb-4">

                            <h4 class="mb-3">Payment</h4>

                            <div class="d-block my-3">
                                <fieldset>
                                    <legend>
                                        Method
                                    </legend>
                                    <div class="custom-control custom-radio">
                                        <input id="credit" name="paymentMethod" type="radio" class="custom-control-input" checked="" required="">
                                        <label class="custom-control-label" for="credit">Credit Card</label>
                                    </div>
                                    

                                </fieldset>
                            </div>
                            <div class="row">
                              <div class="col-md-6 mb-3">
                                <label for="cc-name">Name on the card</label>
                                <input type="text" class="form-control" id="cc-name" name="cc-nome" placeholder="" required="" value="<?= $firstname_lastname?>">
                                <small class="text-muted">
                                    Full name as printed on the card
                                </small>
                                <div class="invalid-feedback">
                                  The name is mandatory.
                                </div>
                              </div>
                              <div class="col-md-6 mb-3">
                                <label for="cc-number">Card Number</label>
                                <input type="text" class="form-control" id="cc-number" name="cc-num" placeholder="" required="" value="<?= $cc_num ?>" pattern="[0-9]{16}" title="16 cifre">
                                <div class="invalid-feedback">
                                  Please enter a valid number
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-3 mb-3">
                                <label for="cc-expiration">Expiry Date</label>
                                <input type="text" class="form-control" id="cc-expiration" name="exp" placeholder="" required="" value="<?= $exp ?>" pattern="(?:0[1-9]|1[0-2])/[0-9]{2}" title="Data must be entered in the MM/YY format only">
                                <div class="invalid-feedback">
                                  Expiry Date Invalid.
                                </div>
                              </div>
                              <div class="col-md-3 mb-3">
                                <label for="cc-cvv">CVV</label>
                                <input type="text" class="form-control" id="cc-cvv" name="cvv" placeholder="" required="" value="<?= $cvv ?>" pattern="[0-9]{3}" title="Codice segreto della carta, formato XYZ">
                                <div class="invalid-feedback">
                                    Enter a valid security code.
                                </div>
                              </div>
                            </div>
                            <hr class="mb-4">
                            <button class="btn btn-success btn-block btn-lg" type="submit">Confirm</button>
                          </form>
                        </div>
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
                                lastbench@gmail.com
                            </p>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
    </body>
</html>
