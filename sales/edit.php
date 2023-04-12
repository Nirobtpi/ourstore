<?php
require_once('../config.php');
get_header();
$user_id = $_SESSION['user']['id'];
$id = $_SESSION['user']['id'];
$id = $_REQUEST['id'];

if (isset($_POST['update_form'])) {
    $customer_name = $_POST['customer_name'];
    $product_id = $_POST['product_id'];
    $manufacture_id = $_POST['manufacture_id'];
    $group_name = $_POST['group_name'];
    $expair_date = $_POST['expair_date'];
    $item_price = $_POST['price'];
    $manu_price = $_POST['manu_price'];
    $quantity = $_POST['quantity'];
    $total_price = $_POST['total_price'];
    $descount_type = $_POST['descount_type'];
    $discount_ammount = $_POST['discount_ammount'];
    $sub_total = $_POST['sub_total'];


    $db_date = getProductCategoryName('groups', 'expire_date', $group_name);
    $db_stock = getProductCategoryName('productes', 'stock', $product_id);


    if (empty($customer_name)) {
        $error = "Custome Name Is Required!";
    } elseif (empty($product_id)) {
        $error = "Product Is Number!";
    } elseif (empty($manu_price)) {
        $error = "Manufacture Price Is Required!";
    } elseif (!is_numeric($manu_price)) {
        $error = "Manufacture Price Must Be Number!";
    } elseif (empty($quantity)) {
        $error = "Quantity Must Be a Number!";
    } elseif (!is_numeric($quantity)) {
        $error = "Quantity Must Be a Number!";
    } elseif (empty($expair_date)) {
        $error = "Expair Date Is Required!";
    } elseif ($db_date < date('Y-m-d')) {
        $error = "Your Product is Expair!";
    } elseif ($quantity > $db_stock) {
        $error = "Product is Low!";
    } else {

        $pr_manu_price = $quantity * $manu_price;
        $final_profit = $sub_total - $pr_manu_price;

        // gropu table 
        $stm = $connection->prepare("UPDATE sales SET customer_name=?,product_id=?,manufacture_id=?,group_id=?,expire_date=?,quantity=?,item_price=?,manu_price=?,total_price=?,descount_type=?,discount_ammount=?,sub_total=?,profit=? WHERE id=?");
        $stm->execute(array($customer_name, $product_id, $manufacture_id, $group_name, $expair_date, $quantity, $item_price, $manu_price, $total_price, $descount_type, $discount_ammount, $sub_total, $final_profit, $id));

        // stock - 
        $st = $connection->prepare("UPDATE productes SET stock=stock-? WHERE id=?");
        $st->execute(array($quantity, $product_id));

        $success = "Sales Successfully!";
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
                    <h3 class="card-title">Update Sales</h3>
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
                        $sales = GetSingleData('sales', $id);
                        ?>
                        <fv class="basic-form">
                            <form action="" method="POST">
                                <div class="form-group">
                                    <label for="customer_name">Customer Name:</label>
                                    <input type="text" name="customer_name" class="form-control input-default" value="<?php echo $sales['customer_name'] ?>" id="customer_name" required>
                                </div>
                                <div class="form-group">
                                    <label for="product_id">Select Product:</label>
                                    <select name="product_id" class="form-control" id="product_id">
                                        <option value="#">Select Product</option>
                                        <?php
                                        $productes = GetTableData('productes');
                                        foreach ($productes as $product) :
                                        ?>
                                            <option value="<?php echo $product['id'] ?>" <?php if ($product['id'] == $sales['product_id']) {
                                                                                                echo 'selected';
                                                                                            } ?>><?php echo $product['product_name'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="manufacture_name">Manufacture:</label>
                                    <input type="text" name="manufacture_name" class="form-control input-default" value="<?php echo getProductCategoryName('manufacture', 'name', $sales['manufacture_id']) ?>" id="manufacture_name" readonly>

                                    <input type="hidden" name="manufacture_id" id="manufacture_id">
                                </div>
                                <div class="form-group">
                                    <label for="group_name">Group Name:</label>
                                    <select name="group_name" class="form-control" id="group_name">
                                        <option value="<?php echo $sales['group_id'] ?>" <?php if ($product['id'] == $sales['group_id']) {
                                                                                                echo "selected";
                                                                                            } ?>><?php echo getProductCategoryName('groups', 'group_name', $sales['group_id'])  ?>
                                        </option>

                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="expair_date">Expair Date:</label>
                                    <input type="text" name="expair_date" class="form-control input-default" value="<?php echo $sales['expire_date'] ?>" id="expair_date" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="price">Price:</label>
                                    <input type="text" name="price" class="form-control input-default" value="<?php echo $sales['item_price'] ?>" id="price" readonly required>
                                </div>
                                <div class="form-group">
                                    <label for="manu_price">Manufacture Price:</label>
                                    <input type="text" value="<?php echo $sales['manu_price'] ?>" name="manu_price" class="form-control input-default" id="manu_price" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="quantity">Quantity: <span id="av_stock" class="badge badge-info"></span></label>
                                    <input type="number" name="quantity" class="form-control input-default" value="<?php echo $sales['quantity'] ?>" id="quantity" required>
                                    <input type="hidden" name="stock" id="stock">
                                </div>
                                <div class="form-group">
                                    <label for="total_price">Total Price:</label>
                                    <input type="text" name="total_price" class="form-control input-default" id="total_price" value="<?php echo $sales['total_price'] ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="descount_type">Discount Type:</label>
                                    <select name="descount_type" class="form-control" id="descount_type">
                                        <option value="none" <?php if ($sales['descount_type'] == 'none') {
                                                                    echo 'selected';
                                                                } ?>>None</option>
                                        <option value="fixed" <?php if ($sales['descount_type'] == 'fixed') {
                                                                    echo 'selected';
                                                                } ?>>Fixed</option>
                                        <option value="percentage" <?php if ($sales['descount_type'] == 'percentage') {
                                                                        echo 'selected';
                                                                    } ?>>Percentage</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="discount_ammount">Discount Amount:</label>
                                    <input type="text" value="<?php echo $sales['discount_ammount'] ?>" name="discount_ammount" class="form-control input-default" id="discount_ammount">
                                </div>
                                <div class="form-group">
                                    <label for="sub_total">Sub Total:</label>
                                    <input type="text" value="<?php echo $sales['sub_total'] ?>" name="sub_total" class="form-control input-default" id="sub_total" readonly>
                                </div>
                                <div class="form-group">
                                    <input type="submit" name="update_form" class="btn btn-success" value="Update Now">
                                </div>
                            </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
</div>
<!-- #/ container -->
<?php get_footer()
?>
<script>
    // Get Product Data 
    $('#product_id').on('change', function() {
        let product_id = $(this).val();

        // console.log(product_id);

        $.ajax({
            type: "POST",
            url: "ajax.php",
            data: {
                product_id: product_id,
            },
            success: function(response) {

                let productResult = JSON.parse(response);

                console.log(productResult);
                if (productResult.count == 0) {
                    $('#ajaxError').show().text(productResult.message);
                    // alert(productResult.message);
                } else {
                    $('#ajaxError').hide();
                    $('#manufacture_name').val(productResult.manufacture_name);
                    $('#manufacture_id').val(productResult.manufacture_id);
                    $('#stock').val(productResult.stock);
                    let stock1 = $('#av_stock').text("Available Stock :" + productResult.stock);

                    // Groups 
                    $('#group_name').empty();
                    let groups = productResult.groups;
                    $('#group_name').append("<option value='#'>Select Group</option>"),
                        $.each(groups, function(i, item) {
                            $('<option value="' + groups[i].id + '">').html(
                                '<span>' + groups[i].group_name + '</span>'
                            ).appendTo('#group_name')
                        });
                }

            }
        })
    });

    // Get Ajax Data 

    $('#group_name').on('change', function() {
        let group_id = $(this).val();

        $.ajax({
            type: "POST",
            url: "ajax.php",
            data: {
                group_id: group_id,
            },
            success: function(response) {
                let groupRaselt = JSON.parse(response);

                $('#expair_date').val(groupRaselt.expire_date);
                $('#price').val(groupRaselt.per_item_price);
                $('#manu_price').val(groupRaselt.per_item_m_price);
            }
        });

    });

    // Get Calculet Total Price
    $('#quantity').on('keyup', function() {
        let quantity = $(this).val();
        let price = $('#price').val();
        let stock = $('#stock').val();

        if (price.length == 0) {
            $('#ajaxError').show().text("Please Select Product And Group First!");
        } else if (!jQuery.isNumeric(quantity)) {
            $("#ajaxError").show().text("Qunatity Must Be A Number");
        } else if (quantity > stock) {
            $("#ajaxError").show().text("Product Stock Is Low");
        } else {
            $('#ajaxError').hide();
            let total_price = price * quantity;
            $("#total_price").val(total_price);
            $("#sub_total").val(total_price);
        }

    });

    // DisCount Total Price 

    $('#discount_ammount').on('keyup', function() {
        let type = $('#descount_type').val();
        let discount_ammount = $(this).val();

        if (type == "fixed") {
            if (!jQuery.isNumeric(discount_ammount)) {
                $("#ajaxError").show().text("Discount Ammount Must Be A Number");
            } else {
                $('#ajaxError').hide();
                let total__price = $("#total_price").val();
                let new_sub_total = total__price - discount_ammount;
                $("#sub_total").val(new_sub_total);
            }
        } else if (type == "percentage") {
            if (!jQuery.isNumeric(discount_ammount)) {
                $("#ajaxError").show().text("Discount Ammount Must Be A Number");
            } else {
                $('#ajaxError').hide();
                let total___price = $("#total_price").val();
                let percentage_amount = total___price * discount_ammount / 100;
                let new__sub_total = total___price - percentage_amount;
                $("#sub_total").val(new__sub_total);
            }
        } else {
            $('#discount_ammount').val('');
            // let total__price = $("#total_price").val();
            let new_total = $("#total_price").val();
            $("#sub_total").val(new_total);
        }
    });
    $('#descount_type').on('change', function() {
        let dis_type = $(this).val();

        if (dis_type == "none") {
            $('#discount_ammount').val('');
            // let total__price = $("#total_price").val();
            let new_total = $("#total_price").val();
            $("#sub_total").val(new_total);
        }

    });
</script>


<!-- Qp7!.)Fg,MrV-->
<!-- codesnhq_nirob -->