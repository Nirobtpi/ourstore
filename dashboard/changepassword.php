<?php
require_once("../config.php");
get_header();
$profile = getProfile($_SESSION['user']['id']);



if(isset($_POST['change_pass_form'])){
    $current_password=$_POST['current_password'];
    $new_password=$_POST['new_password'];
    $confirm_new_password=$_POST['confirm_new_password'];

    $db_password=$profile['password'];
    $current_password_hash=SHA1($current_password);

    if(empty($current_password)){
        $error="Current Password Required!";
    }
    elseif(empty($new_password)){
        $error="New Password Required!";
    }
    elseif(empty($confirm_new_password)){
        $error="Confirm New Password Required!";
    }
    elseif($confirm_new_password != $new_password){
        $error="New Password and Confirm New Password does't match!";
    }
    elseif($db_password != $current_password_hash){
        $error="Current Password Is Wrong!";
    }
    else{
        $new_password_hash=SHA1($new_password);
        $stm=$connection->prepare("UPDATE users SET password=? WHERE id=?");
        $stm->execute(array($new_password_hash, $_SESSION['user']['id']));

        $success="Password Change";
    }
}

?>

<div class="row page-titles mx-0">
    <div class="col p-md-0">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
            <li class="breadcrumb-item active"><a href="javascript:void(0)">Change Password</a></li>
        </ol>
    </div>
</div>
<!-- row -->

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-6 col-xl-6">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title">Change Password</h3>
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
                        <script>
                            setTimeout(function(){
                                window.location.href="../includes/logout.php";
                            },2000)
                        </script>
                    <?php endif; ?>
                    <div class="basic-form">
                        <form action="" method="POST">
                            <div class="form-group">
                                <input type="password" name="current_password" class="form-control input-default" placeholder="Current Password">
                            </div>
                            <div class="form-group">
                                <input type="password" name="new_password" class="form-control input-flat" placeholder="New Password ">
                            </div>
                            <div class="form-group">
                                <input type="password" name="confirm_new_password" class="form-control input-flat" placeholder="Confirm New Password ">
                            </div>
                            <div class="form-group">
                                <input type="submit" name="change_pass_form" class="btn btn-success" value="Change Password">
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