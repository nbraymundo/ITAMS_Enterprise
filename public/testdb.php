<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

try {

    $pdo = new PDO(
        "mysql:host=127.0.0.1;port=3306;dbname=itams_enterprise;charset=utf8mb4",
        "root",
        ""
    );

    echo "<h2 style='color:green'>SUCCESS</h2>";

    echo "<br>";

    echo "Server Version: ";

    echo $pdo->getAttribute(PDO::ATTR_SERVER_VERSION);

} catch (PDOException $e) {

    echo "<h2 style='color:red'>FAILED</h2>";

    echo "<pre>";
    echo $e->getMessage();
    echo "</pre>";

}