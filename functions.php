<?php
    function dubbol($col, $value){
        global $connection;
        $stm = $connection->prepare("SELECT $col FROM users WHERE $col=?");
        $stm->execute(array($value));
        $result = $stm->rowCount();

        return $result;
    }

    // user data function 
    function getProfile($id){
        global $connection;
        $stm=$connection->prepare("SELECT * FROM users WHERE id=?");
        $stm->execute(array($id));
        $result=$stm->fetch(PDO::FETCH_ASSOC);

        return $result;
    }
   





    function getvalue($saba){
        if(isset($_POST[$saba])){
            echo $_POST[$saba];
        }
    }

    function get_header(){
        require_once("header.php");
    }
    function get_footer(){
        require_once("footer.php");
    }
?>