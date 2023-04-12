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
                    <h4 class="card-title">All Sales</h4>
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
                                    <th>Manufacture</th>
                                    <th>Group</th>
                                    <th>Sub Total</th>
                                    <th>Quantity</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sales = GetTableData('sales');
                                // print_r($purchases);

                                $i = 1;
                                foreach ($sales as $sale) :

                                ?>
                                    <tr>
                                        <td><?php echo $i;
                                            $i++; ?></td>
                                        <td><?php echo getProductCategoryName('productes', 'product_name', $sale['product_id']) ?></td>
                                        <td><?php echo getProductCategoryName('manufacture', 'name', $sale['manufacture_id']) ?></td>
                                        <td><?php echo getProductCategoryName('groups', 'group_name', $sale['group_id']) ?></td>
                                        <td><?php echo $sale['sub_total'] ?></td>
                                        <td><?php echo $sale['quantity'] ?></td>
                                        <td><?php echo date('d-m-Y', strtotime($sale['created_at'])) ?></td>
                                        <td>
                                            <a href="singleview.php?id=<?php echo $sale['id'] ?>" class="btn btn-success btn-sm"><i class="fa fa-eye"></i></a> &nbsp;&nbsp;

                                            <a href="edit.php?id=<?php echo $sale['id'] ?>" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a> &nbsp;&nbsp;

                                            <a href="delete.php?id=<?php echo $sale['id'] ?>" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
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