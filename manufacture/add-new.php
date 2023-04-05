<?php
require_once('../config.php');
get_header();
$user_id=$_SESSION['user']['id'];

    if(isset($_POST['add_new_form'])){
        $manu_name=$_POST['manu_name'];
        $mobile=$_POST['mobile'];
        $address=$_POST['address'];
        $patten= '/^(?:\+88|88)?(01[3-9]\d{8})$/';

        $mobileCount= GetColumnCount('manufacture','mobile',$mobile);

        if(empty($manu_name)){
            $error="Manufacture Name is Required!";
        }
        elseif(empty($mobile)){
            $error="Phone Number is Required!";
        }
        elseif($mobileCount !=0){
            $error="Phone Number Already Used!";
        } elseif(!preg_match($patten,$mobile)){
            $error="Please Enter A Valid Number!";
        }
        elseif (empty($address)) {
        $error = "Address is Required!";
        }else{
            $now=date('Y-m-d H:i:s');

            $stm=$connection->prepare("INSERT INTO manufacture(user_id,name,mobile,address,created_at)VALUES(?,?,?,?,?)");
            $stm->execute(array($user_id,$manu_name,$mobile,$address,$now));

            $success="Manufacture Add Successfully!";
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
                    <h3 class="card-title">Add Manufacture</h3>
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
                            <div class="form-group">
                                <label for="manu_name">Name:</label>
                                <input type="text" name="manu_name" class="form-control input-default" placeholder="Manufacture Name" id="manu_name">
                            </div>
                            <div class="form-group">
                                <label for="mobile">Phone Number:</label>
                                <input type="text" name="mobile" class="form-control input-default" placeholder="Phone Number" id="mobile">
                            </div>
                            <div class="form-group">
                                <label for="address">Address:</label>
                                <textarea name="address" class="form-control summernote" id="address" cols="30" rows="5"></textarea>
                            </div>

                            <div class="form-group">
                                <input type="submit" name="add_new_form" class="btn btn-success" value="Create Manufacture">
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