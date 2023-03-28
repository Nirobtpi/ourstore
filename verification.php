<?php
require_once("config.php");
session_start();



if (!isset($_SESSION['user_email']) and !isset($_SESSION['user_mobile'])) {
    header("location:login.php");
}




if (isset($_POST['email_verification'])) {
    $user_code = $_POST['email_code'];

    $emailCode = $connection->prepare("SELECT email_code FROM users WHERE email=?");
    $emailCode->execute(array($_SESSION['user_email']));
    $getemailcode = $emailCode->fetch(PDO::FETCH_ASSOC);


    if (empty($user_code)) {
        $error = "Email Code is Required!";
    } elseif ($getemailcode['email_code'] != $user_code) {
        $error = "Email Code is Wrong!";
    } else {
        $stm = $connection->prepare("UPDATE users SET email_code=?,email_status=? WHERE email=?");
        $stm->execute(array(null, 1, $_SESSION['user_email']));

        $_SESSION['email_verify'] = 1;


        $success = "Email Validation Success!";
        // header("location:index.php");
    }
}


if (isset($_POST['mobile_verification'])) {
    $mobile_code = $_POST['mobile_code'];

    $mobilecode = $connection->prepare("SELECT mobile_code FROM users WHERE mobile=?");
    $mobilecode->execute(array($_SESSION['user_mobile']));
    $getmobilecode = $mobilecode->fetch(PDO::FETCH_ASSOC);

    if (empty($mobile_code)) {
        $error = "Mobile Code is Required!";
    } elseif ($getmobilecode['mobile_code'] != $mobile_code) {
        $error = "Mobile Code is Wrong!";
    } else {
        $stm = $connection->prepare("UPDATE users SET mobile_code=?,mobile_status=? WHERE mobile=?");
        $stm->execute(array(null, 1, $_SESSION['user_mobile']));

        $_SESSION['mobile_verify'] = 1;


        // header("location:login.php");
?>
        <script>
            setTimeout(function() {
                window.location.href = "login.php"
            },2000)
        </script>
<?php
    }
}
?>


<!DOCTYPE html>
<html class="h-100" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Our Store - User Verification</title>
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
                                <a class="text-center" href="verification.php">
                                    <h2>Verification</h2>
                                </a>

                                <?php if (isset($error)) : ?>
                                    <div class="alert alert-danger">
                                        <?php echo $error; ?>
                                    </div>
                                <?php endif; ?>

                                <?php if (isset($_SESSION['email_verify']) != 1) : ?>
                                    <form method="POST" action="" class="mt-5 mb-5 login-input">
                                        <?php if (!isset($_POST['email_verification'])) : ?>
                                            <div class="alert alert-success">
                                                Please Cheek Your Email:<?php echo $_SESSION['user_email'] ?> , Then Submit The Otp Code.
                                            </div>
                                        <?php endif; ?>

                                        <div class="form-group">
                                            <input type="text" name="email_code" class="form-control" placeholder="Email Code">
                                        </div>
                                        <button type="submit" name="email_verification" class="btn login-form__btn submit w-100">Email Verification</button>
                                    </form>
                                <?php else : ?>
                                    <div class="alert alert-success">
                                        your verification success!
                                    </div>
                                <?php endif; ?>

                                <?php if (isset($_SESSION['mobile_verify']) != 1) : ?>
                                    <form method="POST" action="" class="mt-5 mb-5 login-input">
                                        <?php if (!isset($_POST['mobile_verification'])) : ?>
                                            <div class="alert alert-success">
                                                Please Cheek Your Phone Number:<?php echo $_SESSION['user_mobile'] ?> , Then Submit The Otp Code.
                                            </div>
                                        <?php endif; ?>
                                        <div class="form-group">
                                            <input type="text" name="mobile_code" class="form-control" placeholder="Phone Code">
                                        </div>
                                        <button type="submit" name="mobile_verification" class="btn login-form__btn submit w-100">Mobile Verification</button>
                                    </form>
                                <?php else : ?>
                                    <div class="alert alert-success">
                                        your verification success!
                                    </div>
                                <?php endif; ?>
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
    <?php

    if (isset($_SESSION['email_verify']) and isset($_SESSION['mobile_verify'])) {

        $stm = $connection->prepare("UPDATE users SET status=? WHERE email_status=? AND mobile_status=? AND email=? AND mobile=?");
        $stm->execute(array("Active", 1, 1, $_SESSION['user_email'], $_SESSION['user_mobile']));

        unset($_SESSION['email_verify']);
        unset($_SESSION['mobile_verify']);

        unset($_SESSION['user_email']);
        unset($_SESSION['user_mobile']);
    }


    ?>

    <script src="plugins/common/common.min.js"></script>
    <script src="js/custom.min.js"></script>
    <script src="js/settings.js"></script>
    <script src="js/gleek.js"></script>
    <script src="js/styleSwitcher.js"></script>
</body>

</html>