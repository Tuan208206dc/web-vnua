<?php

$conn = mysqli_connect(
    "localhost",
    "root",
    "",
    "db_quanly_sanpham"
);

if (!$conn) {
    die("Kết nối thất bại");
}

?>