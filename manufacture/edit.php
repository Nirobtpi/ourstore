<?php
require_once('../config.php');
get_header();
$user_id = $_SESSION['user']['id'];
$id = $_REQUEST['id'];

if (isset($_POST['update_form'])) {
    $manu_name = $_POST['manu_name'];
    $mobile = $_POST['mobile'];
    $address = $_POST['address'];

    $stm = $connection->prepare("SELECT mobile FROM manufacture WHERE mobile=? AND id=?");
    $stm->execute(array($mobile,$id));
    $manufacture = $stm->rowCount();

    $mobileCount = GetColumnCount('manufacture', 'mobile', $mobile);

    if (empty($manu_name)) {
        $error = "Manufacture Name is Required!";
    } elseif (empty($mobile)) {
        $error = "Phone Number is Required!";
    } elseif ($mobileCount != 0 AND $manufacture !=1) {
        $error = "Phone Number Already Used!";
    } elseif (empty($address)) {
        $error = "Address is Required!";
    } else {
        $now = date('Y-m-d H:i:s');

        $stm = $connection->prepare("UPDATE manufacture SET name=?,mobile=?,address=? WHERE id=?");
        $stm->execute(array($manu_name, $mobile, $address, $id));

        $success = "Manufacture Update Successfully!";

        ?>
            <script>
                setTimeout(function(){
                    window.location.href='index.php';
                },2000);
            </script>
        <?php

    }
}

?>

<div class="row page-titles mx-0">
    <div class="col p-md-0">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
            <li class="breadcrumb-item active"><a href="javascript:void(0)">Categories</a></li>
        </ol>
    </div>
</div>
<!-- row -->

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 col-xl-12">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title">Update Manufacture</h3>
                    <hr>
                    <?php if (isset($error)) : ?>
                        <div class="alert alert-danger">
                            <?php echo $error ?>
                        </div>
                    <?php endif; ?>
                    <?php if (isset($success)) : ?>
                        <div class="alert alert-success">
                            <?php echo $success ?>
                        </div>
                    <?php endif; ?>
                    <div class="basic-form">
                        <form action="" method="POST" enctype="multipart/form-data">
                            <?php
                            $updateManu = GetSingleData('manufacture', $id);


                            ?>
                            <div class="form-group">
                                <label for="manu_name">Name:</label>
                                <input type="text" name="manu_name" class="form-control input-default" value="<?php echo $updateManu['name']; ?>" id="manu_name">
                            </div>
                            <div class="form-group">
                                <label for="mobile">Phone Number:</label>
                                <input type="text" name="mobile" class="form-control input-default" value="<?php echo $updateManu['mobile']; ?>" id="mobile">
                            </div>
                            <div class="form-group">
                                <label for="address">Address:</label>
                                <textarea name="address" class="form-control summernote" id="address" cols="30" rows="5"><?php echo $updateManu['address']; ?></textarea>
                            </div>

                            <div class="form-group">
                                <input type="submit" name="update_form" class="btn btn-success" value="Update Manufacture">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<!-- #/ container -->
<?php get_footer()
?>