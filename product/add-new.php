<?php
require_once("../config.php");

get_header();

$user_id = $_SESSION['user']['id'];



if (isset($_POST['add_new_form'])) {
    $product_name = $_POST['product_name'];
    $category_id = $_POST['category_id'];
    $description = $_POST['description'];
    $photo = $_FILES['photo'];

    $terget_dir="../uplodes/products/";
    $terget_file=$terget_dir . basename($_FILES['photo']['name']);
    $fileExtention= strtolower(pathinfo($terget_file,PATHINFO_EXTENSION));



    if (empty($product_name)) {
        $error = "Product Name Required!";
    } elseif (empty($category_id)) {
        $error = "Category Name Required!";
    } elseif (empty($_FILES['photo']['name'])) {
        $error = "Photo is  Required!";
    } elseif (empty($description)) {
        $error = "Description is Required!";
    }
     elseif($fileExtention != 'jpg' AND $fileExtention != 'jpeg' AND $fileExtention != 'png' AND $fileExtention != 'gif'){
        $error="Photo Must Be Used Jpeg Jpg Png Or Gif format";
    } 
    else {

        $new_photo_name=$user_id . "-" . rand(1111,9999) . "-" . time(). ".".$fileExtention;
        move_uploaded_file($_FILES["photo"]["tmp_name"], $terget_dir . $new_photo_name);

        $now = date('Y-m-d H:i:s');

        $stm = $connection->prepare("INSERT INTO productes(user_id,product_name,category_id,description,photo,created_at)VALUES(?,?,?,?,?,?) ");
        $stm->execute(array($user_id, $product_name, $category_id, $description, $new_photo_name, $now));

        $success = "Product  Create Successfully!";
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
                    <h3 class="card-title">Add Productes</h3>
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
                                <label for="product_name">Product Name:</label>
                                <input type="text" name="product_name" class="form-control input-default" placeholder="Product Name" id="product_name">
                            </div>
                            <div class="form-group">
                                <label for="category_id">Select Category</label>
                                <select name="category_id" class="form-control" id=" category_id">
                                    <?php
                                    $categories = GetTableData('categories');
                                    foreach ($categories as $category) :
                                    ?>
                                        <option value="<?php echo $category['id'] ?>"><?php echo $category['category_name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="description">Description:</label>
                                <textarea name="description" class="form-control summernote" id="description" cols="30" rows="5"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="photo">Photo:</label>
                                <input type="file" name="photo" class="form-control input-default" id="photo">
                            </div>

                            <div class="form-group">
                                <input type="submit" name="add_new_form" class="btn btn-success" value="Create">
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