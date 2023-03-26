<?php
    function dubbol($col, $value){
        global $connection;
        $stm = $connection->prepare("SELECT $col FROM users WHERE $col=?");
        $stm->execute(array($value));
        $result = $stm->rowCount();

        return $result;
    }
    function getvalue($saba){
        if(isset($_POST[$saba])){
            echo $_POST[$saba];
        }
    }
?>