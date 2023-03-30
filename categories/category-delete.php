<?php
session_start();
    require_once('../config.php');
    $id=$_REQUEST['id'];

    DeleteTableData('categories',$id);
    header('location:'. GET_APP_URL().'/categories?success="Data Delete Successfully!"')
    

?>