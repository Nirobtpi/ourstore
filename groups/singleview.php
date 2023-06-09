<?php
require_once("../config.php");
get_header();
$id=$_REQUEST['id'];
$purchasesDetailesEx = GetSingleData('groups', $id);

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
                    <h4 class="card-title">Groups Details</h4>
                    <hr>
                    <div class="table-responsive">
                        <table class="table header-border">
                            <tbody>
                                <tr>
                                    <td>Group Name:</td>
                                    <td><?php echo $purchasesDetailesEx['group_name'] ?></td>
                                </tr>
                                <tr>
                                    <td>Product Name:</td>
                                    <td><?php echo getProductCategoryName('productes', 'product_name', $purchasesDetailesEx['product_id']) ?></td>
                                </tr>
                                <tr>
                                    <td>Quantity:</td>
                                    <td><?php echo $purchasesDetailesEx['quantity'] ?></td>
                                </tr>

                                <tr>
                                    <td>Expair Date:</td>
                                    <td><?php echo $purchasesDetailesEx['expire_date'] ?></td>
                                </tr>

                                <tr>
                                    <td>Pet Item Price:</td>
                                    <td><?php echo $purchasesDetailesEx['per_item_price'] ?> Tk</td>
                                </tr>
                                <tr>
                                    <td>Total Item Price:</td>
                                    <td><?php echo $purchasesDetailesEx['total_item_price'] ?> Tk</td>
                                </tr>
                                <tr>
                                    <td>Pet Item Manufacture Price:</td>
                                    <td><?php echo $purchasesDetailesEx['per_item_m_price'] ?> Tk</td>
                                </tr>
                                <tr>
                                    <td>Total Manufacture Price:</td>
                                    <td><?php echo $purchasesDetailesEx['total_item_m_price'] ?> Tk</td>
                                </tr>
                                <tr>
                                    <td>Created Date:</td>
                                    <td><?php echo date('d-m-Y', strtotime($purchasesDetailesEx['created_at'])) ?></td>
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