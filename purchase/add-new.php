<?php
    require_once('../config.php');
    get_header();
    $user_id = $_SESSION['user']['id'];
    $id = $_SESSION['user']['id'];

    if(isset($_POST['add_new_purchase_form'])){
        $product_id=$_POST['product_id'];
        $manufacture_id=$_POST['manufacture_id'];
        $group_name=$_POST['group_name'];
        $item_price=$_POST['price'];
        $manu_price=$_POST['manu_price'];
        $quantity=$_POST['quantity'];
        $expair_date=$_POST['expair_date'];

        $groupCount= GetColumnCount('groups', 'group_name',$group_name);


        if(empty($item_price)){
            $error="Price Is Required!";
        } elseif(!is_numeric($item_price)){
            $error="Price Must Be Number!";
        } elseif(empty($manu_price)){
            $error="Manufacture Price Is Required!";
        } elseif(!is_numeric($manu_price)){
            $error="Manufacture Price Must Be Number!";
        } elseif(empty($quantity)){
            $error="Quantity Must Be a Number!";
        } elseif(!is_numeric($quantity)){
            $error="Quantity Must Be a Number!";
        } elseif(empty($expair_date)){
            $error="Expair Date Is Required!";
        }elseif($groupCount !=0){
            $error="Group Name Alredy Used!";
        } else{

            $now=date('Y-m-d H:i:s');
            $total_price= $item_price*$quantity;
            $total_M_price= $manu_price*$quantity;

            // gropu table 
            $stm=$connection->prepare("INSERT INTO groups(user_id,group_name,product_id,quantity,expire_date,per_item_price,per_item_m_price,total_item_price,total_item_m_price,created_at)VALUES(?,?,?,?,?,?,?,?,?,?)");
            $stm->execute(array($user_id,$group_name, $product_id, $quantity, $expair_date,$item_price, $manu_price, $total_price, $total_M_price,$now));

            // purchases table 
            $stm=$connection->prepare("INSERT INTO purchases(user_id,manufacture_id,product_id,group_name,quantity,per_item_price,per_item_m_price,total_item_price,total_item_m_price,created_at)VALUES(?,?,?,?,?,?,?,?,?,?)");
            $stm->execute(array($user_id, $manufacture_id, $product_id, $group_name, $quantity, $item_price, $manu_price, $total_price, $total_M_price,$now));

            // Update product Stock 
            $stm2=$connection->prepare("UPDATE productes SET stock=stock+? WHERE id=? AND user_id=?");
            $stm2->execute(array($quantity,$product_id,$user_id));
  
            $success = "Create Successfully!";
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
                    <h3 class="card-title">Add New Purchase</h3>
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
                        <form action="" method="POST" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="product_id">Select Product:</label>
                                <select name="product_id" class="form-control" id=" product_id">
                                    <?php
                                    $productes = GetTableData('productes');
                                    foreach ($productes as $product) :
                                    ?>
                                        <option value="<?php echo $product['id'] ?>"><?php echo $product['product_name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="manufacture_id">Select Manufacture:</label>
                                <select name="manufacture_id" class="form-control" id=" manufacture_id">
                                    <?php
                                    $manufactures = GetTableData('manufacture');
                                    foreach ($manufactures as $manufacture) :
                                    ?>
                                        <option value="<?php echo $manufacture['id'] ?>"><?php echo $manufacture['name'] . " - " . $manufacture['mobile'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="group_name">Group Name:</label>
                                <input type="text" name="group_name" class="form-control input-default" placeholder="Group Name" id="group_name">
                            </div>
                            <div class="form-group">
                                <label for="price">Price:</label>
                                <input type="text" name="price" class="form-control input-default" placeholder="Price" id="price">
                            </div>
                            <div class="form-group">
                                <label for="manu_price">Manufacture Price:</label>
                                <input type="text" name="manu_price" class="form-control input-default" placeholder="Manufacture Price" id="manu_price">
                            </div>
                            <div class="form-group">
                                <label for="quantity">Quantity:</label>
                                <input type="text" name="quantity" class="form-control input-default" placeholder="Quantity" id="quantity">
                            </div>
                            <div class="form-group">
                                <label for="expair_date">Expair Date:</label>
                                <input type="date" name="expair_date" class="form-control input-default" id="expair_date">
                            </div>

                            <div class="form-group">
                                <input type="submit" name="add_new_purchase_form" class="btn btn-success" value="Purchase Now">
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