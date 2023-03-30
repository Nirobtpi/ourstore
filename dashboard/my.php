<?php
require_once("../config.php");
$id = $_REQUEST['id'];
// echo $id;
if (isset($_POST['registration_form'])) {
    $name = $_POST['name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $mobile = $_POST['mobile'];
    $business_name = $_POST['business_name'];
    $address = $_POST['address'];
    $gender = $_POST['gender'];
    $date_of_birth = $_POST['date_of_birth'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $patten = '/^(?:\+88|88)?(01[3-9]\d{8})$/';

    // datacount 
    $userCount = dubbol('username', $username);
    $emailCount = dubbol('email', $email);
    $mobileCount = dubbol('mobile', $mobile);

    $stm = $connection->prepare("SELECT username FROM users WHERE username=? AND id=?");
    $stm->execute(array($username, $id));
    $ownUserNameCount = $stm->rowCount();

    if (empty($name)) {
        $error = "Name Is Required!";
    } elseif (empty($username)) {
        $error = "Username Is Required!";
    } elseif ($userCount != 0 and $ownUserNameCount != 1) {
        $error = "Username Already Used!";
    }
    // elseif (empty($email)) {
    //     $error = "Email Is Required!";
    // }
    elseif ($emailCount != 0 and $ownUserNameCount != 1) {
        $error = "Email Already Used!";
    }
    // elseif (empty($mobile)) {
    //     $error = "Email Is Required!";
    // } 
    elseif (!preg_match($patten, $mobile, $match)) {
        $error = "Enter a Valid Phone Number!";
    } elseif ($mobileCount != 0 and $ownUserNameCount != 1) {
        $error = "Phone Number Already Used!";
    } elseif (empty($business_name)) {
        $error = "Business Name Is Required!";
    }
    // elseif (empty($address)) {
    //     $error = "Address Is Required!";
    // }
    elseif (empty($date_of_birth)) {
        $error = "Date Of Birth Is Required!";
    }
    // elseif (empty($password)) {
    //     $error = "Password Is Required!";
    // }
    elseif (empty($confirm_password)) {
        $error = "Confirm Password Is Required!";
    } elseif ($password != $confirm_password) {
        $error = "Password No Match!";
    } elseif (strlen($password) < 6 or strlen($password) > 15) {
        $error = "Password Must Be Used 6 to 15 Digit!";
    } else {
        unset($_POST);

        $password = SHA1($password);
        $email_code = rand(111111, 999999);
        $mobile_code = rand(111111, 999999);
        $created_at = date('Y-m-d H:i:s');
        $username = strtolower($username);



        $stm = $connection->prepare("UPDATE users SET name=?,username=?,email=?,mobile=?,password=?,business_name=?,address=?,email_code=?,mobile_code=?,gender=?,date_of_birth=?,status=?,created_at=? WHERE id=?");

        $result = $stm->execute(array($name, $username, $email, $mobile, $password, $business_name, $address, $email_code, $mobile_code, $gender, $date_of_birth, "Pending", $created_at, $id));

        $success = "Nirob";
    }
}
get_header();

?>


<div class="login-form-bg h-100">
    <div class="container h-100">
        <div class="row justify-content-center h-100">
            <div class="col-xl-6">
                <div class="form-input-content py-5">
                    <div class="card login-form mb-0">
                        <div class="card-body pt-5">

                            <a class="text-center" href="index.php">
                                <h2>OurStore</h2>
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

                            <form action="" method="POST" class="mt-5 mb-5 login-input">
                                <div class="form-group">
                                    <input type="text" name="name" class="form-control" placeholder="Name" value="<?php getvalue('name') ?>">
                                </div>
                                <div class="form-group">
                                    <input type="text" name="username" class="form-control" placeholder="Username" value="<?php getvalue('username') ?>">
                                </div>
                                <div class="form-group">
                                    <input type="email" name="email" class="form-control" placeholder="Email" value="<?php getvalue('email') ?>">
                                </div>
                                <div class="form-group">
                                    <input type="text" name="mobile" class="form-control" placeholder="Phone Number" value="<?php getvalue('mobile') ?>">
                                </div>
                                <div class="form-group">
                                    <input type="text" name="business_name" class="form-control" placeholder="Business Name" value="<?php getvalue('business_name') ?>">
                                </div>
                                <div class="form-group">
                                    <textarea name="address" placeholder="Address" class="form-control"><?php getvalue('address') ?></textarea>
                                </div>
                                <div class="form-group radio">
                                    <label for="">Gender</label>
                                    <br>
                                    <label><input type="radio" name="gender" value="Male" checked>Male</label>
                                    <br>
                                    <label><input type="radio" name="gender" value="Female">Female</label>
                                </div>
                                <div class="form-group">
                                    <input type="date" name="date_of_birth" class="form-control" placeholder="Date Of Birth" value="<?php getvalue('date_of_birth') ?>">
                                </div>
                                <div class="form-group">
                                    <input type="password" name="password" class="form-control" placeholder="Password" value="<?php getvalue('password') ?>">
                                </div>
                                <div class="form-group">
                                    <input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password" value="<?php getvalue('confirm_password') ?>">
                                </div>
                                <button class="btn login-form__btn submit w-100" type="submit" name="registration_form">Registration</button>
                            </form>
                            <p class="mt-5 login-form__footer">Have account <a href="login.php" class="text-primary">Login</a> now</p>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>