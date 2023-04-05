<?php
require_once("../config.php");
get_header();
$user_id = $_SESSION['user']['id'];
$id = $_SESSION['user']['id'];

if (isset($_POST['registration_form'])) {
    $name = $_POST['name'];
    $username = $_POST['username'];
    $business_name = $_POST['business_name'];
    $address = $_POST['address'];
    $gender = $_POST['gender'];
    $photo = $_FILES['nirob']['name'];
    $date_of_birth = $_POST['date_of_birth'];

    $target_dir = "../uplodes/profile/";
    $target_file = $target_dir . basename($_FILES["nirob"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));



    $stm = $connection->prepare("SELECT username FROM users WHERE username=? AND id=?");
    $stm->execute(array($username, $id));
    $ownUserNameCount = $stm->rowCount();

    // datacount 
    $userCount = dubbol('username', $username);

    if (empty($name)) {
        $error = "Name Is Required!";
    } elseif (empty($username)) {
        $error = "Username Is Required!";
    } elseif ($userCount != 0 and $ownUserNameCount != 1) {
        $error = "Username Already Used!";
    } elseif (empty($business_name)) {
        $error = "Business Name Is Required!";
    } elseif (empty($address)) {
        $error = "Address Is Required!";
    } elseif (empty($date_of_birth)) {
        $error = "Date Of Birth Is Required!";
    } elseif (empty($photo)) {
        $error = "Photo Is Required!";
    } elseif ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
        $error = "Sorry, only JPG, JPEG, PNG  files are allowed.";
    } elseif ($_FILES["nirob"]["size"] > 2000000) {
        $error = "Photo Must Be Used Less Then 2mb!";
    } else {

        $new_name = $id . "-" . rand(1111, 9999) . "-" . time() . '.' . $imageFileType;
        move_uploaded_file($_FILES["nirob"]["tmp_name"], $target_dir . $new_name);


        $created_at = date('Y-m-d H:i:s');
        $username = strtolower($username);

        $stm = $connection->prepare("UPDATE users SET name=?,username=?,business_name=?,address=?,gender=?,date_of_birth=?,photo=?,created_at=? WHERE id=?");
        $stm->execute(array($name, $username, $business_name, $address, $gender, $date_of_birth, $new_name, $created_at, $id));

        $success = "Data Update Success!";
    }
}


?>

<div class="login-form-bg h-100">
    <div class="container h-100">
        <div class="row justify-content-center h-100">
            <div class="col-xl-8">
                <div class="form-input-content py-5">
                    <div class="card login-form mb-0">
                        <div class="card-body pt-5">

                            <a class="text-center" href="profile-edit.php">
                                <h2>Update Profile</h2>
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

                            <form action="" method="POST" class="mt-5 mb-5 login-input" enctype="multipart/form-data">
                                <?php

                                $stm = $connection->prepare("SELECT * FROM users WHERE id=?");
                                $stm->execute(array($_SESSION['user']['id']));
                                $result = $stm->fetch(PDO::FETCH_ASSOC);

                                // print_r($result); 
                                ?>
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" class="form-control" id="name" value="<?php echo $result['name'] ?>">
                                </div>
                                <div class="form-group">
                                    <label for="username">User Name</label>
                                    <input type="text" name="username" class="form-control" id="username" value="<?php echo $result['username'] ?>">
                                </div>
                                <div class="form-group">
                                    <label for="bb">Business Name</label>
                                    <input type="text" name="business_name" class="form-control" id="bb" value="<?php echo $result['business_name'] ?>">
                                </div>
                                <div class="form-group">
                                    <label for="add">Address</label>
                                    <textarea id="add" name="address" placeholder="Address" class="form-control"><?php echo $result['address'] ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="photo">Photo</label>
                                    <input type="file" name="nirob" class="form-control" id="photo" value="<?php echo $result['photo'] ?>">
                                </div>
                                <div class="form-group radio">
                                    <label for="">Gender</label>
                                    <br>
                                    <label><input <?php if ($result['gender'] == "Male") {
                                        echo 'checked';
                                    }; ?> type="radio" name="gender" value="Male">Male</label>
                                    <br>
                                    <label><input <?php if ($result['gender'] == "Female") {
                                        echo "checked";
                                    }; ?> type="radio" name="gender" value="Female">Female</label>
                                </div>
                                <div class="form-group">
                                    <label for="bt">Date Of Birth</label>
                                    <input id="bt" type="date" name="date_of_birth" class="form-control" placeholder="Date Of Birth" value="<?php echo $result['date_of_birth'] ?>">
                                </div>
                                <button class="btn login-form__btn submit w-100" type="submit" name="registration_form">Update Now</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php get_footer() ?>