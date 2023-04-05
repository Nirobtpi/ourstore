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
                    <h4 class="card-title">All Groups</h4>
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
                                    <th>Group Name</th>
                                    <th>Product Name</th>
                                    <th>Quantity</th>
                                    <th>Expair Date</th>
                                    <th>Per Item Price</th>
                                    <th>Total Item Price</th>
                                    <th>Per Manu Price</th>
                                    <th>Total Manu Price</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $purchases = GetTableData('groups');

                                $i = 1;
                                foreach ($purchases as $purchase) :

                                ?>
                                    <tr>
                                        <td><?php echo $i;
                                            $i++; ?></td>

                                        <td><?php echo $purchase['group_name'] ?></td>
                                        <td><?php echo getProductCategoryName('productes', 'product_name', $purchase['product_id']) ?></td>
                                        <td><?php echo $purchase['quantity'] ?></td>
                                        <td><?php echo $purchase['expire_date'] ?></td>
                                        <td><?php echo $purchase['per_item_price'] ?></td>
                                        <td><?php echo $purchase['total_item_price'] ?></td>
                                        <td><?php echo $purchase['per_item_m_price'] ?></td>
                                        <td><?php echo $purchase['total_item_m_price'] ?></td>
                                        <td><?php echo date('d-m-Y', strtotime($purchase['created_at'])) ?></td>
                                        <td>
                                            <a href="singleview.php?id=<?php echo $purchase['id'] ?>" class="btn btn-success btn-sm"><i class="fa fa-eye"></i></a> &nbsp;&nbsp;
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