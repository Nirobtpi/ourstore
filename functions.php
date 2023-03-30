<?php
// get column data single table 
    function dubbol($col, $value){
        global $connection;
        $stm = $connection->prepare("SELECT $col FROM users WHERE $col=?");
        $stm->execute(array($value));
        $result = $stm->rowCount();

        return $result;
    }

    // user data function ////
    function getProfile($id){
        global $connection;
        $stm = $connection->prepare("SELECT * FROM users WHERE id=?");
        $stm->execute(array($id));
        $result = $stm->fetch(PDO::FETCH_ASSOC);

        return $result;
    }


    // get column Count  dinamic /////
    function GetColumnCount($tbl,$col, $value){
        global $connection;
        $stm = $connection->prepare("SELECT $col FROM $tbl WHERE $col=?");
        $stm->execute(array($value));
        $result = $stm->rowCount();

        return $result;
    }

    // Get All Table Data /////
    function GetTableData($tbl){
        global $connection;
        $stm=$connection->prepare("SELECT * FROM $tbl WHERE user_id=?");
        $stm->execute(array($_SESSION['user']['id']));
        $result=$stm->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
    // Get SIngle Table Data //// 
    function GetSingleData($tbl,$id){
        global $connection;
        $stm=$connection->prepare("SELECT * FROM $tbl WHERE user_id=? AND id=?");
        $stm->execute(array($_SESSION['user']['id'],$id));
        $result=$stm->fetch(PDO::FETCH_ASSOC);

        return $result;
    }
    // function GetSingleData1($tbl,$id){
    //     global $connection;
    //     $stm=$connection->prepare("SELECT * FROM $tbl WHERE user_id=? AND id=?");
    //     $stm->execute(array($_SESSION['user']['id'],$id));
    //     $result=$stm->fetch(PDO::FETCH_ASSOC);

    //     return $result;
    // }


    // Delete Table Data /////
    function DeleteTableData($tbl,$id){
        global $connection;
        $stm = $connection->prepare("DELETE  FROM $tbl WHERE user_id=? AND id=?");
        $delete=$stm->execute(array($_SESSION['user']['id'],$id));
        return $delete;
    }




 
   





    function getvalue($saba){
        if(isset($_POST[$saba])){
            echo $_POST[$saba];
        }
    }

    function get_header(){
        require_once("includes/header.php");
    }
    function get_footer(){
        require_once("includes/footer.php");
    }
?>