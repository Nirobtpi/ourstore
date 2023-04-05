<?php
require_once("../config.php");
get_header();
$user_id = $_SESSION['user']['id'];
$id = $_SESSION['user']['id'];


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
                    <h4 class="card-title">All Categories</h4>
                    <div class="table-responsive">
                        <table class="table header-border">
                            <?php if (isset($_REQUEST['success'])) : ?>
                                <div class="alert alert-success">
                                    Data Delete Successfully!
                                </div>
                            <?php endif; ?>
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Product Name</th>
                                    <th>Category Name</th>
                                    <th>Photo</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $categories = GetTableData('productes');

                                $a = 1;
                                foreach ($categories as $category) :
                                ?>
                                    <tr>
                                        <td><?php echo $a;
                                            $a++; ?></td>
                                        <td><?php echo $category['product_name']; ?></td>

                                        <td><?php echo getProductCategoryName('categories','category_name',$category['category_id']); ?></td>
                                        
                                        <td><img width="100" src="../uplodes/products/<?php echo $category['photo']; ?>" alt=""></td>

                                        <td><?php echo date('d-m-y', strtotime($category['created_at'])); ?></td>

                                        <td>
                                            <a href="edit.php?id=<?php echo $category['id'] ?>" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></a> &nbsp;&nbsp;

                                            <a onclick="return confirm('Are You Sure?')" href="delete.php?id=<?php echo $category['id'] ?>" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<!-- #/ container -->
<?php get_footer()
?>