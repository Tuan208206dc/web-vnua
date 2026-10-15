<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "db_trasua";

$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    die("Kết nối cơ sở dữ liệu thất bại.");
}

mysqli_set_charset($conn, "utf8mb4");
?>
