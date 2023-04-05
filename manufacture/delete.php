<?php 
    require_once('../config.php');
    session_start();
    $id=$_REQUEST['id'];
    DeleteTableData('manufacture',$id);
    header("location:../manufacture?success=Data Delete Successfully");


?>