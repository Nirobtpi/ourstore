<?php
// get column data single table 
function dubbol($col, $value)
{
    global $connection;
    $stm = $connection->prepare("SELECT $col FROM users WHERE $col=?");
    $stm->execute(array($value));
    $result = $stm->rowCount();

    return $result;
}

// user data function ////
function getProfile($id)
{
    global $connection;
    $stm = $connection->prepare("SELECT * FROM users WHERE id=?");
    $stm->execute(array($id));
    $result = $stm->fetch(PDO::FETCH_ASSOC);

    return $result;
}


// get column Count  dinamic /////
function GetColumnCount($tbl, $col, $value)
{
    global $connection;
    $stm = $connection->prepare("SELECT $col FROM $tbl WHERE $col=?");
    $stm->execute(array($value));
    $result = $stm->rowCount();

    return $result;
}

// Get All Table Data /////
function GetTableData($tbl)
{
    global $connection;
    $stm = $connection->prepare("SELECT * FROM $tbl WHERE user_id=?");
    $stm->execute(array($_SESSION['user']['id']));
    $result = $stm->fetchAll(PDO::FETCH_ASSOC);

    return $result;
}
function GetTableData2($tbl)
{
    global $connection;
    $stm = $connection->prepare("SELECT * FROM $tbl WHERE id=?");
    $stm->execute(array($_SESSION['user']['id']));
    $result = $stm->fetchAll(PDO::FETCH_ASSOC);

    return $result;
}
// Get SIngle Table Data //// 
function GetSingleData($tbl, $id)
{
    global $connection;
    $stm = $connection->prepare("SELECT * FROM $tbl WHERE user_id=? AND id=?");
    $stm->execute(array($_SESSION['user']['id'], $id));
    $result = $stm->fetch(PDO::FETCH_ASSOC);

    return $result;
}


// Delete Table Data /////
function DeleteTableData($tbl, $id)
{
    global $connection;
    $stm = $connection->prepare("DELETE  FROM $tbl WHERE user_id=? AND id=?");
    $delete = $stm->execute(array($_SESSION['user']['id'], $id));
    return $delete;
}

// Get Productes Category Name and Get  SIngle Name

function getProductCategoryName($tbl, $col, $id)
{
    global $connection;
    $stm = $connection->prepare("SELECT $col FROM $tbl WHERE id=?");
    $stm->execute(array($id));
    $result = $stm->fetch(PDO::FETCH_ASSOC);

    return $result[$col];
}
function getGroupsName($col, $id, $pid)
{
    global $connection;
    $stm = $connection->prepare("SELECT $col FROM groups WHERE id=? AND product_id=?");
    $stm->execute(array($id, $pid));
    $result = $stm->fetch(PDO::FETCH_ASSOC);

    return $result[$col];
}

function GetAllValue($tbl, $col)
{
    $total_sales = 0;
    $sales = GetTableData($tbl);
    foreach ($sales as $sale) {
        $total_sales = $total_sales + $sale[$col];
    };
    return $total_sales;
}

function SelectProductes($id)
{
    global $connection;
    $stm = $connection->prepare("SELECT id FROM productes WHERE user_id=? ");
    $stm->execute(array($id));
    $result = $stm->rowCount();

    return $result;
}
// function SelectSels($id){
//     global $connection;
//     $stm = $connection->prepare("SELECT id FROM sales WHERE user_id=? ");
//     $stm->execute(array($id));
//     $result = $stm->rowCount();

//     return $result;
// }
// function SelectPurchase($id){
//     global $connection;
//     $stm = $connection->prepare("SELECT id FROM purchases WHERE user_id=? ");
//     $stm->execute(array($id));
//     $result = $stm->rowCount();

//     return $result;
// }
function me($tbl, $col, $user_id)
{
    global $connection;
    $stm = $connection->prepare("SELECT MONTHNAME(created_at) as month,COUNT($col) as Id FROM $tbl WHERE user_id =?  GROUP BY MONTH(created_at)");
    $stm->execute(array($user_id));
    $result2 = $stm->fetchAll(PDO::FETCH_ASSOC);

    return $result2;
}





function getvalue($saba)
{
    if (isset($_POST[$saba])) {
        echo $_POST[$saba];
    }
}

function get_header()
{
    require_once("includes/header.php");
}
function get_footer()
{
    require_once("includes/footer.php");
}


// Send OTP On Mobile Number
function SendSMS($to, $message)
{
    $token = "85a94a9807036ee4b95d20956a818191";
    $url = "http://api.greenweb.com.bd/api.php?json";

    $data = array(
        'to' => "$to",
        'message' => "$message",
        'token' => "$token"
    );
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_ENCODING, '');
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $smsresult = curl_exec($ch);
    $smsresult = json_decode($smsresult, true);
    $status = $smsresult[0]['status'];
    return $status;
    //Error Display
    // echo curl_error($ch);
}
