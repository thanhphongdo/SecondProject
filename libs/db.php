<?php
    $host = "localhost";
    $database = "khosach";
    $user = "root";
    $pass = "";
    $dsn = "mysql:host=" . $host  . ";dbname=" . $database;
    try {
        $dbh = new PDO($dsn, $user, $pass);
    }
    catch (PDOException $ex) {
        echo "Lỗi kết nối CSDL";
    }
?>