<?php
$servername = "localhost"; $username = "root"; $password = ""; $database = "database001";
try {
    $conn = new PDO("mysql:host=$servername", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "CREATE DATABASE IF NOT EXISTS $database";
    $conn->exec($sql);

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $table1 = "shoppingcart"; $table2 = "history"; $table3 = "profile";
        $sql1 = "CREATE TABLE IF NOT EXISTS $table1 (id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, username VARCHAR(40) NOT NULL, email VARCHAR(30))";
        $sql2 = "CREATE TABLE IF NOT EXISTS $table2 (id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, username VARCHAR(40) NOT NULL, email VARCHAR(30))";
        $sql3 = "CREATE TABLE IF NOT EXISTS $table3 (id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, username VARCHAR(40) NOT NULL, email VARCHAR(30))";
        $conn->exec($sql1); $conn->exec($sql2); $conn->exec($sql3);
    }catch(PDOException $e){
        echo $sql . "<br>" . $e->getMessage();
    }

    $conn = null;

}catch(PDOException $e){
    echo $sql . "<br>" . $e->getMessage();
}

$conn = null;

?>