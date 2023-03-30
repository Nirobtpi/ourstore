<?php
require_once("../config.php");

get_header();

$user_id = $_SESSION['user']['id'];



if (isset($_POST['add_new_form'])) {
    $category_name = $_POST['cat_name'];
    $category_slug = $_POST['cat_slug'];
   
    $slugCount= GetColumnCount('categories', 'category_slug', $category_slug);

    $pattern = "/^[a-z-0-9]+$/";


    if (empty($category_name)) {
        $error = "Category Name Required!";
    } elseif (empty($category_slug)) {
        $error = "New Password Required!";
    } elseif (empty($category_slug)) {
        $error = "Category Slug  Required!";
    } elseif($slugCount != 0){
        $error="Categories Slug Already Used!";
    } elseif(!preg_match($pattern, $category_slug)){
        $error= "Don't Used Any Whitespace Or  Special Or Uppercase Characters!";
    }
    else {
        $now=date('Y-m-d H:i:s');
        $stm = $connection->prepare("INSERT INTO categories(user_id,category_name,category_slug,created_at)VALUES(?,?,?,?) ");
        $stm->execute(array($user_id, $category_name, strtolower($category_slug),$now));

        $success = "Category  Create Successfully!";
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
        <div class="col-lg-6 col-xl-6">
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
                        <form action="" method="POST">
                            <div class="form-group">
                                <label for="cat_name">Category Name:</label>
                                <input type="text" name="cat_name" class="form-control input-default" placeholder="Categories Name" id="cat_name">
                            </div>
                            <div class="form-group">
                                <label for="cat_slug">Category Slug</label>
                                <input type="text" name="cat_slug" class="form-control input-default" placeholder="Category Slug" id="cat_slug">
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