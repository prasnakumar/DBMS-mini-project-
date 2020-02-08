<?php
    require_once '../php_utils/db_connection.php';

    if(session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if(!isset($_SESSION["admin"])) {
        header("location: ../users/userlogin.php");
        die();
    }

    $conn = connect();

    $query = "select email from admin";
    $admins = $conn->query($query);
    $flag = FALSE;

    $query = "select * from menu where id_category=1";
    $classic = $conn->query($query);

    $query = "select * from menu where id_category=2";
    $speciali = $conn->query($query);

    $query = "select * from menu where id_category=3";
    $calzone = $conn->query($query);

    $query = "select * from menu where id_category=4";
    $sodas = $conn->query($query);

    $success = 0;

    if(isset($_POST["name"])) {
        $category = $_POST["category"];
        $name = $_POST["name"];
        $price = $_POST["price"];
        $descr = $_POST["descr"];

        $query = "INSERT INTO menu (name, description, price, id_category) VALUES (?,?,?,?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssi", $name, $descr, $price, $category);
        $stmt->execute();
        $stmt->store_result();
        if($stmt->affected_rows > 0)
        {
            $success = 1;
        }
        else
        {
            $success = -1;
        }
        $stmt->close();

       

    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="author" content="PS">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <meta name="description" content="Online Pizza Delivery">
        <meta name="keywords" content="online,pizza,pasta">
        <link rel="icon" href="../favicon.png" type="image/x-icon">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
        <link rel="stylesheet" type="text/css" href="../styles/customBgJumbo.css">
        <link rel="stylesheet" type="text/css" href="../styles/home.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
        <script src="../scripts/smoothScrolling.js"></script>
        <script src="../scripts/inputControl.js"></script>
        <link rel="stylesheet" type="text/css" href="../styles/admin.css">
        <link rel="stylesheet" type="text/css" href="../styles/account.css">
        <script src="../scripts/notifications.js"></script>

        <title>Add Pizza</title>
    </head>
    <body>
        <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
            <a href="#top" class="navbar-brand">Deku pizza</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="navbar-collapse collapse justify-content-stretch" id="navbarCollapse">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="adminWelcome.php">Home   <span class="fas fa-home"></span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="settings.php">Settings <span class="fas fa-wrench"></span></a>
                    </li>
                    <li class="nav-item">
                        <input type="hidden" id="mail-field" value="<?= $_SESSION["admin"]?>">
                        <a class="nav-link" href="notifications.php">Notifications <span class="fas fa-bell" id="bell-icon"></span><span class="hidden badge badge-pill badge-danger" id="bell-count">0</span></a>
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
                        <h1 >Add the new pizza</h1>
                    </div>
                </div>
            </div>
            <div id="content">
                <?php
                if($success == 1) {
                    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        Pizza added to Deku pizza database
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                        </div>';
                }
                else if($success == -1)
                {
                    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        pizza failed to be added in Deku Pizza database
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                        </div>';
                }
                ?>
                <div class="container container-fluid bg-grey rounded">
                    <form action="addpizza.php" method="post">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="categoria">Category</label>
                            </div>
                            <div class="col-md-8 mb-2">
                                <select class="form-control" id="category" name="category" onChange="hideDescr()">
                                    <option value="1">
                                        Pizza Classic
                                    </option>
                                    <option value="2">
                                        Pizze Special
                                    </option>
                                    <option value="3">
                                        Calzone
                                    </option>
                                    <option value="4">
                                        Soda
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="row newline">
                            <div class="col-md-4">
                                <label for="nome">Name</label>
                            </div>
                            <div class="col-md-8 mb-2">
                                <input type="text" class="form-control" id="name" name="name" value="" required="">
                            </div>
                        </div>
                        <div class="row newline">
                            <div class="col-md-4">
                                <label for="price">Price</label>
                            </div>
                            <div class="col-md-8">
                                <div class="input-group mb-3">
                                  <div class="input-group-prepend">
                                    <span class="input-group-text" id="currency">₹</span>
                                  </div>
                                  <input type="number" class="form-control" step="0.01" id="price" min = "0" name="price" placeholder="INR" aria-label="prezzo" aria-describedby="currency" required="">
                                </div>
                            </div>
                        </div>
                        <div class="row newline to-hide">
                            <div class="col-md-4">
                                <label for="descr">Description</label>
                            </div>
                            <div class="col-md-8">
                                <textarea class="form-control" id="descr" name="descr" rows="3" cols="20"></textarea>
                            </div>
                        </div>
                        <div class="row newline justify-content-end ma-4" id="moveUp">
                            <input type="submit" class="btn btn-success mb-4 mr-4" name="submit" id="submit" value="Submit">

                        </div>
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
                                  <p>KEEP IN TOUCH <br> Email:lastbenchatm@gmail.com</p>
                            </p>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
    </body>
</html>
