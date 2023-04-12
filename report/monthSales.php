<?php
require_once('../config.php');
get_header();
$user_id = $_SESSION['user']['id'];
$id = $_SESSION['user']['id'];

if (isset($_POST['find'])) {
    $month_name = $_POST['month_name'];

    $stm = $connection->prepare("SELECT * FROM sales WHERE MONTH(created_at)=? AND user_id=?");
    $stm->execute(array($month_name, $user_id));
    $monthly_result = $stm->fetchAll(PDO::FETCH_ASSOC);
}

if (isset($_POST['find_pruchases'])) {
    $month_name = $_POST['month_name'];

    $stm = $connection->prepare("SELECT * FROM purchases WHERE MONTH(created_at)=? AND user_id=?");
    $stm->execute(array($month_name, $user_id));
    $Purchases_result = $stm->fetchAll(PDO::FETCH_ASSOC);
}

if (isset($_POST['date_to_date'])) {
    $from_date = $_POST['from_date'];
    $to_date = $_POST['to_date'];
    if (empty($from_date)) {
        $error = "Empty Date";
    }

    $stm = $connection->prepare("SELECT * FROM groups WHERE created_at BETWEEN ? AND ? AND user_id=?");
    $stm->execute(array($from_date, $to_date, $user_id));
    $date_to_date_result = $stm->fetchAll(PDO::FETCH_ASSOC);
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
        <div class="col-lg-8 col-xl-8">
            <h2>Month To Month Sales Details</h2>
            <div class="card">
                <div class="card-body">
                    <div class="basic-form">
                        <form action="" method="POST">
                            <div class="form-group">
                                <label for="month"></label>
                                <select name="month_name" class="form-control" id="month">
                                    <option value="1">January</option>
                                    <option value="2">February</option>
                                    <option value="3">March</option>
                                    <option value="4">April</option>
                                    <option value="5">May</option>
                                    <option value="6">June</option>
                                    <option value="7">July</option>
                                    <option value="8">August</option>
                                    <option value="9">September</option>
                                    <option value="10">October</option>
                                    <option value="11">November</option>
                                    <option value="12">December</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <input type="submit" name="find" class="btn btn-success" value="Find Now">
                            </div>
                        </form>
                    </div>

                    <?php if (isset($_POST['find'])) : ?>

                        <h3 class="card-title"> Month ( <?php echo date('F', mktime(0, 0, 0, $_POST['month_name'], 10))  ?> ) Sales Report</h3>
                        <hr>
                        <div class="table-responsive">
                            <table class="table header-border">
                                <thead>
                                    <tr>
                                        <td>#</td>
                                        <td>Customer Name:</td>
                                        <td>Product Name:</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $a = 1;
                                    foreach ($monthly_result as $row) : {
                                            $monthly_result = GetTableData('productes');
                                        }
                                    ?>
                                        <tr>
                                            <td><?php echo $a;
                                                $a++; ?></td>
                                            <td><?php echo $row['customer_name'] ?></td>
                                            <td><?php echo getProductCategoryName('productes', 'product_name', $row['product_id']) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else : ?>
                        <h3 class="card-title">Current Month ( <?php echo date('F') ?> ) Sales Report</h3>
                        <hr>
                        <div class="table-responsive">
                            <table class="table header-border">
                                <tbody>
                                    <tr>
                                        <td>#</td>
                                        <td>Customer Name:</td>
                                        <td>Product Name:</td>
                                        <!-- <td>Purchases:</td> -->
                                    </tr>
                                </tbody>
                                <tbody>
                                    <?php
                                    $currentMonth = date('m');
                                    $stm = $connection->prepare("SELECT * FROM sales WHERE MONTH(created_at)=? AND user_id=?");
                                    $stm->execute(array($currentMonth, $user_id));
                                    $result = $stm->fetchAll(PDO::FETCH_ASSOC);
                                    ?>
                                    <?php
                                    $a = 1;
                                    foreach ($result as $row) : {
                                            $data = GetTableData('productes');
                                        }
                                    ?>
                                        <tr>
                                            <td><?php echo $a;
                                                $a++; ?></td>
                                            <td><?php echo $row['customer_name'] ?></td>
                                            <td><?php echo getProductCategoryName('productes', 'product_name', $row['product_id']) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>

                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <!-- purchases Details -->
    <div class="row">
        <div class="col-lg-12 col-xl-12">
            <h2>Month to Month Purchases Details</h2>
            <div class="card">
                <div class="card-body">
                    <div class="basic-form">
                        <form action="" method="POST">
                            <div class="form-group">
                                <label for="month"></label>
                                <select name="month_name" class="form-control" id="month">
                                    <option value="1">January</option>
                                    <option value="2">February</option>
                                    <option value="3">March</option>
                                    <option value="4">April</option>
                                    <option value="5">May</option>
                                    <option value="6">June</option>
                                    <option value="7">July</option>
                                    <option value="8">August</option>
                                    <option value="9">September</option>
                                    <option value="10">October</option>
                                    <option value="11">November</option>
                                    <option value="12">December</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <input type="submit" name="find_pruchases" class="btn btn-success" value="Purchases Find now">
                            </div>
                        </form>
                    </div>

                    <?php if (isset($_POST['find_pruchases'])) : ?>

                        <h3 class="card-title"> Month ( <?php echo date('F', mktime(0, 0, 0, $_POST['month_name'], 10))  ?> ) Purchases Report</h3>
                        <hr>
                        <div class="table-responsive">
                            <table class="table header-border">
                                <thead>
                                    <tr>
                                        <td>#</td>
                                        <td>Name:</td>
                                        <td>Product Name:</td>
                                        <td>Manufacture Name:</td>
                                        <td>Group Name:</td>
                                        <td>Quantity:</td>
                                        <td>Total Invast:</td>
                                        <td>Created At:</td>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $a = 1;
                                    foreach ($Purchases_result as $row) : {
                                            $data = GetTableData('productes');
                                            $data2 = GetTableData2('users');
                                            $data2 = GetTableData2('manufacture');
                                            // print_r($data2);
                                        }
                                    ?>
                                        <tr>
                                            <td><?php echo $a;
                                                $a++; ?></td>
                                            <td><?php echo getProductCategoryName('users', 'name', $row['user_id']) ?></td>
                                            <td><?php echo getProductCategoryName('productes', 'product_name', $row['product_id']) ?></td>
                                            <td><?php echo getProductCategoryName('manufacture', 'name', $row['manufacture_id']) ?></td>
                                            <td><?php echo $row['group_name'] ?></td>
                                            <td><?php echo $row['quantity'] ?></td>
                                            <td><?php echo $row['per_item_m_price'] ?></td>
                                            <td><?php echo date('d-m-Y', strtotime($row['created_at'])) ?></td>

                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>

                            </table>
                        </div>
                    <?php else : ?>
                        <h3 class="card-title">Current Month ( <?php echo date('F') ?> ) Purchases Report</h3>
                        <br>
                        <div class="table-responsive">
                            <table class="table header-border">
                                <thead>
                                    <tr>
                                        <td>#</td>
                                        <td>Name:</td>
                                        <td>Product Name:</td>
                                        <td>Manufacture Name:</td>
                                        <td>Group Name:</td>
                                        <td>Quantity:</td>
                                        <td>Total Invast:</td>
                                        <td>Created At:</td>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $currentMonth = date('m');
                                    $stm = $connection->prepare("SELECT * FROM purchases WHERE MONTH(created_at)=? AND user_id=?");
                                    $stm->execute(array($currentMonth, $user_id));
                                    $result = $stm->fetchAll(PDO::FETCH_ASSOC);
                                    ?>
                                    <?php
                                    $a = 1;
                                    foreach ($result as $row) : {
                                            $data = GetTableData('productes');
                                            $data2 = GetTableData2('users');
                                            $data2 = GetTableData2('manufacture');
                                            // print_r($data2);
                                        }
                                    ?>
                                        <tr>
                                            <td><?php echo $a;
                                                $a++; ?></td>
                                            <td><?php echo getProductCategoryName('users', 'name', $row['user_id']) ?></td>
                                            <td><?php echo getProductCategoryName('productes', 'product_name', $row['product_id']) ?></td>
                                            <td><?php echo getProductCategoryName('manufacture', 'name', $row['manufacture_id']) ?></td>
                                            <td><?php echo $row['group_name'] ?></td>
                                            <td><?php echo $row['quantity'] ?></td>
                                            <td><?php echo $row['per_item_m_price'] ?></td>
                                            <td><?php echo date('d-m-Y', strtotime($row['created_at'])) ?></td>

                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>

                </div>

            </div>
        </div>
    </div>


    <!-- date to date Filtering  -->

    <div class="row">
        <div class="col-lg-12 col-xl-12">
            <h2>Date to Date Group Details</h2>
            <?php if (isset($error)) : ?>
                <div class="alert alert-danger">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>
            <div class="card">
                <div class="card-body">
                    <div class="basic-form">
                        <form action="" method="POST">
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="from_date">Form Date</label>
                                        <input type="date" name="from_date" class="form-control">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="to_date">To Date</label>
                                        <input type="date" name="to_date" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="submit" name="date_to_date" class="btn btn-success" value="Purchases Find now">
                                </div>
                            </div>
                        </form>
                    </div>

                    <?php if (isset($_POST['date_to_date'])) : ?>
                        <h3 class="card-title">From Date <?php echo $_POST['from_date'] ?> And TO Date <?php echo $_POST['to_date'] ?> Purchases Report</h3>
                        <hr>
                        <div class="table-responsive">
                            <table class="table header-border">
                                <thead>
                                    <tr>
                                        <td>#</td>
                                        <td>Group Name:</td>
                                        <td>Product Name:</td>
                                        <td>Expire Date:</td>
                                        <td>Stock:</td>
                                        <td>Created At:</td>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $a = 1;
                                    foreach ($date_to_date_result as $row) : {
                                            $data = GetTableData('productes');
                                            $data2 = GetTableData2('users');
                                            $data2 = GetTableData2('manufacture');
                                            // print_r($data2);
                                        }
                                    ?>
                                        <tr>
                                            <td><?php echo $a;
                                                $a++; ?></td>
                                            <td><?php echo $row['group_name'] ?></td>
                                            <td><?php echo getProductCategoryName('productes', 'product_name', $row['product_id']) ?></td>
                                            <td><?php echo $row['expire_date'] ?></td>
                                            <td><?php echo getProductCategoryName('productes', 'stock', $row['product_id'])  ?></td>
                                            <td><?php echo $row['created_at'] ?></td>


                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>

                            </table>
                        </div>
                    <?php else : ?>
                        <h3 class="card-title">Current Month ( <?php echo date('F') ?> ) Purchases Report</h3>
                        <br>
                        <div class="table-responsive">
                            <table class="table header-border">
                                <thead>
                                    <tr>
                                        <td>#</td>
                                        <td>Name:</td>
                                        <td>Product Name:</td>
                                        <td>Manufacture Name:</td>
                                        <td>Group Name:</td>
                                        <td>Quantity:</td>
                                        <td>Total Invast:</td>
                                        <td>Created At:</td>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $currentMonth = date('m');
                                    $stm = $connection->prepare("SELECT * FROM purchases WHERE MONTH(created_at)=? AND user_id=?");
                                    $stm->execute(array($currentMonth, $user_id));
                                    $result = $stm->fetchAll(PDO::FETCH_ASSOC);
                                    ?>
                                    <?php
                                    $a = 1;
                                    foreach ($result as $row) : {
                                            $data = GetTableData('productes');
                                            $data2 = GetTableData2('users');
                                            $data2 = GetTableData2('manufacture');
                                            // print_r($data2);
                                        }
                                    ?>
                                        <tr>
                                            <td><?php echo $a;
                                                $a++; ?></td>
                                            <td><?php echo getProductCategoryName('users', 'name', $row['user_id']) ?></td>
                                            <td><?php echo getProductCategoryName('productes', 'product_name', $row['product_id']) ?></td>
                                            <td><?php echo getProductCategoryName('manufacture', 'name', $row['manufacture_id']) ?></td>
                                            <td><?php echo $row['group_name'] ?></td>
                                            <td><?php echo $row['quantity'] ?></td>
                                            <td><?php echo $row['per_item_m_price'] ?></td>
                                            <td><?php echo date('d-m-Y', strtotime($row['created_at'])) ?></td>

                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- #/ container -->
<?php get_footer(); ?>