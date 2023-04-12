<?php
    session_start();
    require_once('../config.php');
    $id=$_REQUEST['id'];

    DeleteTableData('sales',$id);
    header("location:index.php?success=Data Delete Successfully");
