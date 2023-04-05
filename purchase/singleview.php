<?php
require_once("../config.php");
get_header();
// $user_id = $_SESSION['user']['id'];
// $id = $_SESSION['user']['id'];
$id=$_REQUEST['id'];

$purchasesDetailes = GetSingleData('purchases', $id);
$purchasesDetailesEx = GetSingleData('groups', $id);
// $proDetailes = GetSingleData('productes', $id)

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
                    <h4 class="card-title">Purchase Details</h4>
                    <hr>
                    <div class="table-responsive">
                        <table class="table header-border">
                            <tbody>
                                <tr>
                                    <td>Product Name:</td>
                                    <td><?php echo getProductCategoryName('productes', 'product_name', $purchasesDetailes['product_id']) ?></td>
                                </tr>
                                <tr>
                                    <td>Manufacture Name:</td>
                                    <td><?php echo getProductCategoryName('manufacture', 'name', $purchasesDetailes['manufacture_id']) ?></td>
                                </tr>
                                <tr>
                                    <td>Group Name:</td>
                                    <td><?php echo $purchasesDetailes['group_name'] ?></td>
                                </tr>
                                <tr>
                                    <td>Expair Date:</td>
                                    <td><?php echo $purchasesDetailesEx['expire_date'] ?></td>
                                </tr>
                                <tr>
                                    <td>Quantity:</td>
                                    <td><?php echo $purchasesDetailes['quantity'] ?></td>
                                </tr>
                                <tr>
                                    <td>Pet Item Price:</td>
                                    <td><?php echo $purchasesDetailes['per_item_price'] ?> Tk</td>
                                </tr>
                                <tr>
                                    <td>Total Item Price:</td>
                                    <td><?php echo $purchasesDetailes['total_item_price'] ?> Tk</td>
                                </tr>
                                <tr>
                                    <td>Pet Item Manufacture Price:</td>
                                    <td><?php echo $purchasesDetailes['per_item_m_price'] ?> Tk</td>
                                </tr>
                                <tr>
                                    <td>Total Manufacture Price:</td>
                                    <td><?php echo $purchasesDetailes['total_item_m_price'] ?> Tk</td>
                                </tr>
                                <tr>
                                    <td>Created Date:</td>
                                    <td><?php echo date('d-m-Y', strtotime($purchasesDetailes['created_at'])) ?></td>
                                </tr>

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