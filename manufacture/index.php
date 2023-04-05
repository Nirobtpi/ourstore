<?php
require_once('../config.php');
get_header();
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
                    <h4 class="card-title">All Manufacture</h4>
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
                                    <th>id</th>
                                    <th>Manufacture Name</th>
                                    <th>Mobile</th>
                                    <th>Address</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $manufacures = GetTableData('manufacture');
                                $a = 1;
                                // print_r($manufacures);
                                foreach ($manufacures as $manufacture) :

                                ?>
                                    <tr>
                                        <td><?php echo $a;
                                            $a++; ?></td>
                                        <td><?php echo $manufacture['id'] ?></td>
                                        <td><?php echo $manufacture['name'] ?></td>
                                        <td><?php echo $manufacture['mobile'] ?></td>
                                        <td><?php echo $manufacture['address'] ?></td>
                                        <td><?php echo date('Y-d-m', strtotime($manufacture['created_at'])) ?></td>
                                        <td>
                                            <a href="../manufacture/edit.php?id=<?php echo $manufacture['id'] ?>" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></a>
                                            &nbsp;&nbsp;
                                            <a href="../manufacture/delete.php?id=<?php echo $manufacture['id'] ?>" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
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
<?php get_footer() ?>