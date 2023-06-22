<?php 
try {
    $host = "localhost";
    $dbname = "lb_pdo_workers";
    $username = "root";
    $password = "";    
    $connection = new PDO("mysql:host=$host;dbname=$dbname;", $username, $password);
    } catch (PDOException $ex) {
        echo "Connection failed: " . $ex->getMessage();
    }
?>