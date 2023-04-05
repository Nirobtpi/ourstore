<?php
session_start();
    require_once('../config.php');
    $id=$_REQUEST['id'];

    DeleteTableData('productes',$id);
    header('location:'. GET_APP_URL().'/product?success="Data Delete Successfully!"')
    

?>