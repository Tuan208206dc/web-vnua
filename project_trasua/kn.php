
<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "db_trasua";

// Ket noi den MySQL
$conn = mysqli_connect($servername, $username, $password, $database);

// Kiem tra ket noi
if (!$conn) {
    die("Ket noi that bai: " . mysqli_connect_error());
}

// Su dung tieng Viet
mysqli_set_charset($conn, "utf8mb4");
?>
