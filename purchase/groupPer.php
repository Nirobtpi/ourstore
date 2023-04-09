<?php
require_once("../config.php");
get_header();

$user_id = $_SESSION['user']['id'];
$id = $_SESSION['user']['id'];

if (isset($_POST['add_new_pro'])) {
    $group_name = $_POST['group_name'];
    $product_id = $_POST['product'];
    $expire_date = $_POST['expire_date'];
    $quantity = $_POST['quantity'];
    $per_item_price = $_POST['per_item_price'];
    $per_item_m_price = $_POST['per_item_m_price'];

    if (empty($group_name)) {
        $error = "Group Name Is Required!";
    } elseif (empty($expire_date)) {
        $error = "Expair Date Is Required!";
    } elseif (empty($quantity)) {
        $error = "Quantity Is Required!";
    } elseif (!is_numeric($quantity)) {
        $error = "Quantity Must Be A Number!";
    } elseif (empty($per_item_price)) {
        $error = "Per Item Price Is Required!";
    } elseif (!is_numeric($per_item_price)) {
        $error = "Per Item Price Must Be A Number!";
    } elseif (empty($per_item_m_price)) {
        $error = "Per Item Manufacture Price Is Required!";
    } elseif (!is_numeric($per_item_m_price)) {
        $error = "Per Item manufacture Price Must Be A Number!";
    } else {

        $now = date('Y-m-d H:i:s');
        $total_item_price = $per_item_price * $quantity;
        $total_item_M_price = $per_item_m_price * $quantity;

        // gropu table 
        $stm = $connection->prepare("INSERT INTO groups(user_id,group_name,product_id,quantity,expire_date,per_item_price,per_item_m_price,total_item_price,total_item_m_price,created_at)VALUES(?,?,?,?,?,?,?,?,?,?)");
        $stm->execute(array($user_id, $group_name, $product_id, $quantity, $expire_date, $per_item_price, $per_item_m_price, $total_item_price, $total_item_M_price, $now));

        $success = "Success!";
    }
}



?>
<table class="table header-border">

    <thead>
        <tr>
            <!-- <th>#</th> -->
            <th>Product Name</th>
            <th>Manufacture</th>
            <th>Group</th>
            <th>Expire</th>
            <th>Quantity</th>
            <th>Item Price</th>
            <th>Manufacture Price</th>
            <!-- <th>Total Price</th> -->
            <th>Action</th>
        </tr>
    </thead>
    <form action="" method="POST">
        <?php if (isset($error)) : ?>
            <div class="alert alert-danger">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>
        <?php if (isset($success)) : ?>
            <div class="alert alert-success">
                <?php echo $success; ?>
            </div>
        <?php endif; ?>
        <tbody id="Append">
            <tr class="me">
                <td>

                    <select name="product" class="form-control" id="product">
                        <?php
                        $pro_name = GetTableData('productes');
                        foreach ($pro_name as $pro) :
                        ?>
                            <option value="<?php echo $pro['id'] ?>"><?php echo $pro['product_name'] ?></option>
                        <?php endforeach; ?>
                    </select>

                </td>
                <td>
                    <select name="manu_name" class="form-control" id="">
                        <?php
                        $pro_name = GetTableData('manufacture');
                        foreach ($pro_name as $pro) :
                        ?>
                            <option value="<?php echo $pro['id'] ?>"><?php echo $pro['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
                <td><input type="text" class="form-control" name="group_name" placeholder="Group Name"></td>
                <td><input type="date" class="form-control" name="expire_date" placeholder="Expire" id=""></td>
                <td><input type="number" class="form-control" name="quantity" placeholder="Quantity" id=""></td>
                <td><input type="number" class="form-control" name="per_item_price" placeholder="Item Price" id=""></td>
                <td><input type="number" class="form-control" name="per_item_m_price" placeholder="Manufacture Price" id=""></td>
                <td>
                    <a onclick="return confirm('Are You Sure?')" href="javascript:void(0)" class="btn btn-sm btn-danger remove1"><i class="fa fa-times"></i></a>
                </td>
            </tr>
        </tbody>
        <tr>
            <td colspan="5" class="text-start"><button type="submit" name="add_new_pro" class="btn btn-primary">Add Purchase</button></td>
            <td colspan="5" class="text-end"><button type="button" id="addrow" class="btn btn-primary">Add New</button></td>
        </tr>
    </form>


</table>


<?php
get_footer();
?>