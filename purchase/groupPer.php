<?php
require_once("../config.php");
get_header();

$user_id = $_SESSION['user']['id'];
$id = $_SESSION['user']['id'];

if (isset($_POST['add_new_pro'])) {
    $product_name = $_POST['product'];
    $manufacture_name = $_POST['manu_name'];
    $group_name = $_POST['group_name'];
    $per_item_price = $_POST['per_item_price'];
    $per_item_m_price = $_POST['per_item_m_price'];
    $quantity = $_POST['quantity'];
    $expair_date = $_POST['expire_date'];


    if (empty($item_price)) {
        $error = "Price Is Required!";
    }
    elseif(empty($group_name)){
        $error="Nirob";
    }
    elseif (!is_numeric($item_price)) {
        $error = "Price Must Be Number!";
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
    } else {

        $now = date('Y-m-d H:i:s');
        $total_price = $per_item_price * $quantity;
        $total_M_price = $per_item_m_price * $quantity;

        // gropu table 
        $stm = $connection->prepare("INSERT INTO groups2(user_id,group_name,product_name,manu_name,quantity,expire_date,per_item_price,per_item_m_price,total_item_price,total_item_m_price,created_at)VALUES(?,?,?,?,?,?,?,?,?,?,?)");
        $stm->execute(array($user_id, $group_name, $product_name, $manufacture_name, $quantity, $expair_date, $per_item_price, $per_item_m_price, $total_price, $total_M_price, $now));

        // purchases table 
        // $stm = $connection->prepare("INSERT INTO purchases(user_id,manufacture_id,product_id,group_name,quantity,per_item_price,per_item_m_price,total_item_price,total_item_m_price,created_at)VALUES(?,?,?,?,?,?,?,?,?,?)");
        // $stm->execute(array($user_id, $manufacture_id, $product_id, $group_name, $quantity, $item_price, $manu_price, $total_price, $total_M_price, $now));

        $success = "Create Successfully!";
    }
}



?>
<form action="" method="POST">
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

        <tbody id="Append">
            <tr class="me">
                <td>
                    <select name="product" class="form-control" id="product">
                        <option value="Hp">Hp</option>
                        <option value="Acer">Acer</option>
                        <option value="Asus">Asus</option>
                        <option value="Walton">Walton</option>
                    </select>
                </td>
                <td>
                    <select name="manu_name" class="form-control" id="">
                        <option value="Hp">Hp</option>
                        <option value="Asus">Asus</option>
                        <option value="Dell">Dell</option>
                        <option value="Walton">Walton</option>
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
            <!-- <tr> <button type="submit" class="btn btn-success">Add Now</button></tr> -->
        </tbody>
        <!-- <tr>
            <td colspan="0" class="text-end"><button type="button" class="btn btn-primary">Add Now</button></td>
        </tr> -->
        <tr>
            <!-- <td colspan="5" class="text-start"><button type="submit" name="add_new_pro" class="btn btn-primary">Add Purchase</button></td> -->
            <td colspan="5" class="text-end"><button type="button" id="addrow" class="btn btn-primary">Add New</button></td>
        </tr>
        <button type="submit" name="add_new_pro" class="btn btn-primary">Add Purchase</button>
</form>


</table>


<?php
get_footer();
?>