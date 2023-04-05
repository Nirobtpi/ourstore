<?php
    session_start();
    require_once('../config.php');
    $id=$_REQUEST['id'];

    DeleteTableData('purchases',$id);
    header("location:index.php?success=Data Delete Successfully");

?>