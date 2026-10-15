<?php
session_start();
include "kn.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: dang_nhap.php");
    exit();
}

$sql_tong = "SELECT COUNT(*) AS tong_don FROM don_hang";
$result_tong = mysqli_query($conn, $sql_tong);
$data_tong = mysqli_fetch_assoc($result_tong);
$tong_don = $data_tong['tong_don'];

$sql_hoan_thanh = "SELECT COUNT(*) AS so_don
                   FROM don_hang
                   WHERE trang_thai = 'Hoàn thành'";
$result_hoan_thanh = mysqli_query($conn, $sql_hoan_thanh);
$data_hoan_thanh = mysqli_fetch_assoc($result_hoan_thanh);
$so_don_hoan_thanh = $data_hoan_thanh['so_don'];

$sql_doanh_thu = "SELECT COALESCE(SUM(tong_tien), 0) AS doanh_thu
                  FROM don_hang
                  WHERE trang_thai = 'Hoàn thành'";
$result_doanh_thu = mysqli_query($conn, $sql_doanh_thu);
$data_doanh_thu = mysqli_fetch_assoc($result_doanh_thu);
$doanh_thu = $data_doanh_thu['doanh_thu'];

$sql_tuan = "SELECT COUNT(*) AS so_don,
                    COALESCE(SUM(tong_tien), 0) AS doanh_thu
             FROM don_hang
             WHERE trang_thai = 'Hoàn thành'
             AND ngay_dat >= DATE_SUB(CURDATE(), INTERVAL WEEKDAY(CURDATE()) DAY)
             AND ngay_dat < DATE_ADD(
                 DATE_SUB(CURDATE(), INTERVAL WEEKDAY(CURDATE()) DAY),
                 INTERVAL 7 DAY
             )";
$result_tuan = mysqli_query($conn, $sql_tuan);
$data_tuan = mysqli_fetch_assoc($result_tuan);

$sql_thang = "SELECT COUNT(*) AS so_don,
                     COALESCE(SUM(tong_tien), 0) AS doanh_thu
              FROM don_hang
              WHERE trang_thai = 'Hoàn thành'
              AND ngay_dat >= DATE_FORMAT(CURDATE(), '%Y-%m-01')
              AND ngay_dat < DATE_ADD(DATE_FORMAT(CURDATE(), '%Y-%m-01'), INTERVAL 1 MONTH)";
$result_thang = mysqli_query($conn, $sql_thang);
$data_thang = mysqli_fetch_assoc($result_thang);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thống kê doanh thu</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<header>
    <h1>TIỆM TRÀ SỮA</h1>
    <p>Thống kê hoạt động kinh doanh</p>
</header>

<nav>
    <a href="index.php">Trang chủ</a>
    <a href="quan_ly_mon.php">Quản lý món</a>
    <a href="quan_ly_don.php">Quản lý đơn hàng</a>
    <a href="thong_ke.php">Thống kê</a>
    <a href="dang_xuat.php">Đăng xuất</a>
</nav>

<main>
    <h2>THỐNG KÊ KINH DOANH</h2>

    <h3>Tổng quan</h3>
    <table>
        <tr><th>Nội dung</th><th>Kết quả</th></tr>
        <tr><td>Tổng số đơn hàng</td><td><?php echo (int)$tong_don; ?> đơn</td></tr>
        <tr><td>Số đơn đã hoàn thành</td><td><?php echo (int)$so_don_hoan_thanh; ?> đơn</td></tr>
        <tr><td>Tổng doanh thu</td><td><strong><?php echo number_format($doanh_thu, 0, ',', '.'); ?> đ</strong></td></tr>
    </table>

    <h3>Thống kê theo tuần hiện tại</h3>
    <table>
        <tr><th>Nội dung</th><th>Kết quả</th></tr>
        <tr><td>Số đơn hoàn thành</td><td><?php echo (int)$data_tuan['so_don']; ?> đơn</td></tr>
        <tr><td>Doanh thu trong tuần</td><td><?php echo number_format($data_tuan['doanh_thu'], 0, ',', '.'); ?> đ</td></tr>
    </table>

    <h3>Thống kê theo tháng hiện tại</h3>
    <table>
        <tr><th>Nội dung</th><th>Kết quả</th></tr>
        <tr><td>Số đơn hoàn thành</td><td><?php echo (int)$data_thang['so_don']; ?> đơn</td></tr>
        <tr><td>Doanh thu trong tháng</td><td><?php echo number_format($data_thang['doanh_thu'], 0, ',', '.'); ?> đ</td></tr>
    </table>

    <p>Doanh thu chỉ tính các đơn có trạng thái <strong>Hoàn thành</strong>.</p>
</main>
</body>
</html>
