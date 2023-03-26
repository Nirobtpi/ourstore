<?php
require_once("config.php");
session_start();
if (isset($_POST['login_form'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (empty($username)) {
        $error = "User Name Is Required!";
    } elseif (empty($password)) {
        $error = "Password Is Required!";
    } else {
        $password = SHA1($password);

        $stm = $connection->prepare("SELECT id,email,mobile,username,password,email_status,mobile_status FROM users WHERE username=? AND password=?");
        $stm->execute(array($username, $password));
        $cheekuser = $stm->rowCount();

        if ($cheekuser == 1) {
            $userdata = $stm->fetch(PDO::FETCH_ASSOC);

            if ($userdata['mobile_status'] == 1 and $userdata['email_status'] == 1) {
                $_SESSION['user'] = $userdata;
                header("location:index.php");
            } else {
                header("location:verification.php");
            }
        } else {
            $error = "User Name Or Password Wrong!";
        }
    }
}
if (isset($_SESSION['user'])) {
    header("location:index.php");
}

?>

<!DOCTYPE html>
<html class="h-100" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Our Store - Login</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png">
    <link href="css/style.css" rel="stylesheet">

</head>

<body class="h-100">

    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
        <div class="loader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="3" stroke-miterlimit="10" />
            </svg>
        </div>
    </div>
    <!--*******************
        Preloader end
    ********************-->


    <div class="login-form-bg h-100">
        <div class="container h-100">
            <div class="row justify-content-center h-100">
                <div class="col-xl-6">
                    <div class="form-input-content">
                        <div class="card login-form mb-0">
                            <div class="card-body pt-5">
                                <a class="text-center" href="index.php">
                                    <h2>Login</h2>
                                </a>

                                <?php if (isset($error)) : ?>
                                    <div class="alert alert-danger">
                                        <?php echo $error; ?>
                                    </div>
                                <?php endif; ?>
                                <?php if (isset($success)) : ?>
                                    <div class="alert alert-success">
                                        <?php echo $success; ?>
                                    </div>
                                <?php endif; ?>

                                <form method="POST" action="" class="mt-5 mb-5 login-input">
                                    <div class="form-group">
                                        <input type="text" name="username" class="form-control" placeholder="Username">
                                    </div>
                                    <div class="form-group">
                                        <input name="password" type="password" class="form-control" placeholder="Password">
                                    </div>
                                    <button type="submit" name="login_form" class="btn login-form__btn submit w-100">Login</button>
                                </form>
                                <p class="mt-5 login-form__footer">Dont have account? <a href="registration.php" class="text-primary">Registration</a> now</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!--**********************************
        Scripts
    ***********************************-->
    <script src="plugins/common/common.min.js"></script>
    <script src="js/custom.min.js"></script>
    <script src="js/settings.js"></script>
    <script src="js/gleek.js"></script>
    <script src="js/styleSwitcher.js"></script>
</body>

</html>