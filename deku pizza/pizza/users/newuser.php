<?php
    if(session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    require_once '../php_utils/db_connection.php';

    $firstname = $lastname = $address = $email = $password = $err = "";

    function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if (isset($_POST['firstname'])) {
            $firstname = test_input($_POST['firstname']);

            if ( empty($firstname) ) {
                $err .= "The field First Name cannot be blank.\n";
            }
            elseif ( !preg_match("/^[a-zA-Z ]{1,32}$/",$firstname) ) {
                $err .= "The First Name must be less than 32 characters, letters and spaces allowed\n";
            }
        }

        if (isset($_POST['lastname'])) {

            $lastname = test_input($_POST["lastname"]);

            if( empty($lastname) ) {
                $err .= "The Last Name field must be completed\n";
            }
            elseif ( !preg_match("/^[a-zA-Z ']{1,32}$/", $lastname) ) {
                $err .= "The Last Name can have less than 32 characters.\n";
            }
        }

        if(isset($_POST['address'])) {

            $address = test_input($_POST["address"]);

            if (empty($address)) {
                $err .= "The address field must be completed\n";
            }
            elseif (!strlen($address) > 128) {
                $err .= "Address field can have maximum of 128 characters\n";
            }
        }

        if (isset($_POST['email'])) {

            $email = test_input($_POST["email"]);

            if(empty($email)) {
                $err .= "The E-mail field cannot be blank\n";
            } else {
                $email = strtolower($email);

                if(!preg_match("/(?!.*\.\.)(^[^\.][^@\s]+@[^@\s]+\.[^@\s\.]+$)/", $email)) {
                    $err .= "The email must be shorter than 128 characters. Special characters are accepted as long as the username@domain.organization format is followed\n";
                }
            }
        }

        if (isset($_POST['password'])) {

            $password = test_input($_POST["password"]);

            if(empty($password))
            {
                $err .= "The Password Field cannot be empty.\n";
            } 

        }

        if ($err == "") {
            $conn = connect();

            $stmt = $conn->prepare("insert into users values (?,?,?,?,?)");
            if(!$stmt) {
                $err .= "Could not prepare the statement.\n";
                exit();
            }
            $stmt->bind_param("sssss",$email,$firstname,$lastname,$password,$address);

            $stmt->execute();
            $stmt->close();

            $stmt_1 = $conn->prepare("INSERT INTO payment (email) value (?)");
            $stmt_1->bind_param("s", $email);
            $stmt_1->execute();
            $stmt_1->close();

            $conn->close();

            //Entry Successful
            //Add Session['user']

            $_SESSION['user'] = $email;

            header("location: home.php");
            die();
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
        <link rel="icon" href="../favicon.ico" type="image/x-icon">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css"
            integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB"
            crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.3.1.min.js"
            integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
            crossorigin="anonymous"></script>
        <script src="../scripts/hideFadeElements.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
            integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
            crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"
            integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T"
            crossorigin="anonymous"></script>
        <link rel="stylesheet" type="text/css" href="../styles/customBgJumbo.css">
        <link rel="stylesheet" type="text/css" href="../styles/register.css">
        <script src="../scripts/registrationUtils.js"></script>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
        <title>Registration</title>
    </head>
    <body>
        <div class="bg">
            <div >
                <?php
                    if ($err != "") {
                        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">'.$err.'  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                            </div>';
                    }
                 ?>
                <form action="newuser.php" method="post">
                    <div class="container-fluid">
                        <div class="card card-block toHide" id="signUpCard">
                            <div class="card-title">
                                <h3 class="card-header">New User Registration</h3>
                            </div>
                            <div class="text-container container-fluid text-center">

                            </div>
                            <div class="card-content">
                                <div class="container-fluid form-container">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="firstname">First Name</label>
                                                <input type="text" name="firstname" class="form-control" id="firstname" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="lastname">Last Name</label>
                                                <input type="text" name="lastname" class="form-control" id="lastname" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="address">Address</label>
                                                <input type="text" name="address" class="form-control" id="address"   Eabled>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-left-border">
                                            <div class="form-group">
                                                <label for="email">E-mail</label>
                                                <input type="email" name="email" class="form-control" id="email" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="password">Password</label>
                                                <div class="input-group-append">
                                                    <input type="password" name="password" class="form-control" id="password" value=""><span class="fa fa-check" style="color:green;" aria-hidden="true"></span>
                                                    </div>
                                                </div>
                                                <small id="passwordHelpText" class="form-text text-muted">
                                              </small>
                                                <div class="form-group">
                                                    <label for="pwd_ok">Confirm Password</label>
                                                    <div class="input-group-append">
                                                        <input type="password" name="password_ok" class="form-control" id="pwd_ok" value=""  ><span class="fa fa-check" style="color:green;" aria-hidden="true"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 text-center">
                                            <input type="submit" class="btn btn-primary" value="Register" id="submit">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>
