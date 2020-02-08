<?php
    require_once '../php_utils/db_connection.php';

    if(session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    $email = $_SESSION["admin"];
    $conn = connect();
    $stmt = $conn->prepare("SELECT password FROM admin WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($pw);
    $stmt->store_result();
    $stmt->fetch();

    $success = 0;

    if(isset($_POST["new-pw"])) {
        if(strcmp($_POST["old-pw"], $pw) == 0) {
            $stmt_2 = $conn->prepare("UPDATE admin SET password=? WHERE email=?");
            $stmt_2->bind_param("ss", $_POST["new-pw"], $email);
            $stmt_2->execute();
            var_dump($stmt_2);
            if($stmt_2->affected_rows > 0)
            {
                $success = 1;
            }
            else
            {
                $success = 0;
            }
            $stmt_2->close();
            $_POST = array();
        }
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
        <link rel="stylesheet" type="text/css" href="../styles/account.css">
        <script src="../scripts/notifications.js"></script>

        <title>Settings</title>
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
                    <a class="nav-link active" href="#top">Settings  <span class="fas fa-wrench"></span></a>
                </li>
                <li class="nav-item">
                    <input type="hidden" id="mail-field" value="<?= $_SESSION["admin"]?>">
                    <input type="hidden" id="is-admin" value="true">
                    <a class="nav-link" href="notifications.php">Notifications  <span class="fas fa-bell" id="bell-icon"></span><span class="hidden badge badge-pill badge-danger" id="bell-count">0</span></a>
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
                        <h1 >Settings</h1>
                    </div>
                </div>
            </div>
            <div class="content">
                <?php
                if($success == 1)
                {
                    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    Data inserted successfully.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                    </div>';
                }
                else if($success == -1)
                {
                    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    Data Insertion Failed
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                    </div>';
                }
                ?>
              <ul class="nav nav-pills mb-4" role="tablist">
                <li class="nav-item">

                </li>
              </ul>
              <div class="tab-content">
                <div id="info-account" class="container tab-pane active bg-grey rounded">
                  <h2>Account Information</h2>
                    <p class="text-muted">
                      change your password here.
                    </p>
                      <div class="container-fluid">
                                <form id="info-account-form" action="settings.php" method="post">
                                    <div class="row newline">
                                        <div class="col-md-4">
                                            <label for="email">E-mail</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="email" name="email" class="form-control" id="email" placeholder="<?= $_SESSION["admin"]?>" disabled>
                                        </div>
                                    </div>
                                    <div class="row newline">
                                        <div class="col-md-4">
                                            <label for="old-pw">Old Password</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="password" required class="form-control" name="old-pw" id="old-pw" placeholder="">
                                        </div>
                                    </div>
                                    <div class="row newline">
                                        <div class="col-md-4">
                                            <label for="new-pw">New Password</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="password" required class="form-control" name="new-pw" id="new-pw">
                                        </div>
                                    </div>
                                    <div class="row button-row text-center">
                                        <div class="col-md-12 align-self-center">
                                            <input type="submit" class="btn btn-primary" value="Confirm">
                                        </div>
                                    </div>
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
                                      <p>KEEP IN TOUCH <br> Email:lastbenchatm@gmail.com</p>
                                  </p>
                              </div>
                          </div>
                      </footer>
                  </div>
                </div>
              </body>
          </html>
