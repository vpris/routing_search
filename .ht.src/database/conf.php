<?php

// Database connection credentials
$user = "root";
$pass = "root";
$debug = false;

if (file_exists(__DIR__ . '/config_local.php')) {
    include __DIR__ . '/config_local.php';
}

ob_start();

try {

    $con = new PDO("mysql:dbname=tests; host=127.0.0.1", $user, $pass);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    $con->exec("set names utf8");
}

catch (PDOException $e) {
    if ($debug) {
        die ("Connection Failed: " . $e->getMessage());
    } else {
        die('Connection Failed');
    }

}
