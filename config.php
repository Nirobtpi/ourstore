<?php
    $hostname = "localhost";
    $dbname = "ourstore";
    $username = "root";
    $password = "";


    try {
        $connection = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo "Connection Failed!" . $e->getMessage();
    }

    require_once("functions.php");

    function APP_URL(){
        echo "http://localhost/OurStore";
    }
    function GET_APP_URL(){
        return "http://localhost/OurStore";
    }
 
?>
