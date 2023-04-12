<?php
require_once("../config.php");
get_header();
// $user_id = $_SESSION['user']['id'];
// $id = $_SESSION['user']['id'];
$id = $_REQUEST['id'];

$purchasesDetailes = GetSingleData('sales', $id);
// $purchasesDetailesEx = GetSingleData('groups', $id);
// echo $purchasesDetailesEx['name'];
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
                    <h4 class="card-title">Sales Details</h4>
                    <hr>
                    <div class="table-responsive">
                        <table class="table header-border">
                            <tbody>
                                <tr>
                                    <td>Customer Name:</td>
                                    <td><?php echo $purchasesDetailes['customer_name'] ?></td>
                                </tr>
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
                                    <td><?php echo  getProductCategoryName('groups', 'group_name', $purchasesDetailes['group_id'])  ?></td>
                                </tr>
                                <tr>
                                    <td>Expire Date:</td>
                                    <td><?php echo  getProductCategoryName('groups', 'expire_date', $purchasesDetailes['group_id'])  ?></td>
                                </tr>
                                <tr>
                                    <td>Quantity:</td>
                                    <td><?php echo $purchasesDetailes['quantity'] ?></td>
                                </tr>
                                <tr>
                                    <td>Discount:</td>

                                    <td><?php
                                        if ($purchasesDetailes['descount_type'] == "fixed") {
                                            echo $purchasesDetailes['discount_ammount'] . "Tk";
                                        }
                                        else if ($purchasesDetailes['descount_type'] == "percentage") {
                                            echo $purchasesDetailes['discount_ammount'] . "%";
                                        } else {
                                            echo "None";
                                        }

                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Sub Price:</td>
                                    <td><?php echo $purchasesDetailes['sub_total'] ?> Tk</td>
                                </tr>
                                <tr>
                                    <td>Profit:</td>
                                    <td><?php echo $purchasesDetailes['profit'] ?> Tk</td>
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