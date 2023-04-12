<?php
require_once("../config.php");

get_header();

$user_id = $_SESSION['user']['id'];
$id = $_REQUEST['id'];



if (isset($_POST['add_new_form'])) {
    $product_name = $_POST['product_name'];
    $category_id = $_POST['category_id'];
    $description = $_POST['description'];

    $target_dir = "../uplodes/products/";
    $target_file = $target_dir . basename($_FILES["photo"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));



    if (empty($product_name)) {
        $error = "Product Name Required!";
    } elseif (empty($category_id)) {
        $error = "Category Name Required!";
    } elseif (empty($description)) {
        $error = "Description is Required!";
    } else {
        $image_link = getProductCategoryName('productes', 'photo', $id);

        if (!empty($_FILES['photo']['name'])) {

            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
                $error = "Sorry, only JPG, JPEG, PNG  files are allowed.";
            } else {
                $new_name = $id . "-" . rand(1111, 9999) . "-" . time() . '.' . $imageFileType;
                move_uploaded_file($_FILES["photo"]["tmp_name"], $target_dir . $new_name);

                if (file_exists($target_dir . $image_link)) {
                    unlink($target_dir . $image_link);
                }
            }
            $image_link =  $new_name;
        }

        $stm = $connection->prepare("UPDATE productes SET product_name=?,category_id=?,description=?,photo=? WHERE id=? ");
        $stm->execute(array($product_name, $category_id, $description, $image_link, $id));

        $success = "Product  Update Successfully!";
    }
}

// option 1

// if (!empty($_FILES['photo']['name'])) {

//     if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
//         $error = "Sorry, only JPG, JPEG, PNG  files are allowed.";
//     } else {
//         $new_name = $id . "-" . rand(1111, 9999) . "-" . time() . '.' . $imageFileType;
//         move_uploaded_file($_FILES["photo"]["tmp_name"], $target_dir . $new_name);

//         $stm = $connection->prepare("UPDATE productes SET product_name=?,category_id=?,description=?,photo=? WHERE id=? ");
//         $stm->execute(array($product_name, $category_id, $description, $new_name, $id));

//         $success = "Product  Update Successfully!";
//     }
// } else {
//     $stm = $connection->prepare("UPDATE productes SET product_name=?,category_id=?,description=? WHERE id=? ");
//     $stm->execute(array($product_name, $category_id, $description, $id));

//     $success = "Product  Update Successfully!";
// }

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
                    <h3 class="card-title">Add Categories</h3>
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
                        <?php
                        $product = GetSingleData('productes', $id);
                        ?>
                        <form action="" method="POST" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="product_name">Product Name:</label>
                                <input type="text" name="product_name" class="form-control input-default" value="<?php echo $product['product_name'] ?>" id="product_name">
                            </div>
                            <div class="form-group">
                                <label for="category_id">Select Category</label>
                                <select name="category_id" class="form-control" id=" category_id">
                                    <?php
                                    $categories = GetTableData('categories');
                                    foreach ($categories as $category) :
                                    ?>
                                        <option value="<?php echo $category['id'] ?>" <?php if ($product['category_id'] == $category['id']) {
                                                                                            echo 'selected';
                                                                                        } ?>>
                                            <?php echo $category['category_name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="description">Description:</label>
                                <textarea name="description" class="form-control summernote" id="description" cols="30" rows="5"><?php echo $product['description'] ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="photo">Photo&nbsp; <mark>Skip it; if you won't update photo</mark> </label>
                                <input type="file" name="photo" class="form-control input-default" id="photo">
                                <div class="preview mt-3">
                                    <img style="height: 80px; " src="../uplodes/products/<?php echo $product['photo'] ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <input type="submit" name="add_new_form" class="btn btn-success" value="Update">
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