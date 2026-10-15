<?php
include "kn.php";

$so_dien_thoai = "";
$don_hang = null;
$da_tim = false;
$stmt = null;

if (isset($_POST['tra_cuu'])) {
    $so_dien_thoai = trim($_POST['so_dien_thoai']);
    $da_tim = true;

    if ($so_dien_thoai != "") {
        $sql = "SELECT * FROM don_hang
                WHERE so_dien_thoai = ?
                ORDER BY ngay_dat DESC";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $so_dien_thoai);
        mysqli_stmt_execute($stmt);
        $don_hang = mysqli_stmt_get_result($stmt);
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tra cứu đơn hàng - Tiệm Trà Sữa</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<header>
    <h1>TIỆM TRÀ SỮA</h1>
    <p>Tra cứu đơn hàng của bạn</p>
</header>

<nav>
    <a href="index.php">Trang chủ</a>
    <a href="gio_hang.php">Giỏ hàng</a>
    <a href="tra_cuu_don.php">Tra cứu đơn hàng</a>
</nav>

<main>
    <h2>TRA CỨU ĐƠN HÀNG</h2>

    <form action="tra_cuu_don.php" method="POST">
        <p>
            <label>Nhập số điện thoại đã đặt hàng:</label><br>
            <input
                type="text"
                name="so_dien_thoai"
                required
                maxlength="11"
                value="<?php echo htmlspecialchars($so_dien_thoai); ?>"
            >
        </p>
        <button type="submit" name="tra_cuu">Tra cứu</button>
    </form>

    <?php if ($da_tim) { ?>
        <h3>Kết quả tra cứu</h3>

        <?php if ($so_dien_thoai == "") { ?>
            <p>Vui lòng nhập số điện thoại.</p>
        <?php } elseif (!$don_hang || mysqli_num_rows($don_hang) == 0) { ?>
            <p>Không tìm thấy đơn hàng với số điện thoại này.</p>
        <?php } else { ?>
            <?php while ($dh = mysqli_fetch_assoc($don_hang)) { ?>
                <hr>
                <h3>Đơn hàng số: <?php echo (int)$dh['id']; ?></h3>
                <p>Người đặt: <?php echo htmlspecialchars($dh['ten_khach']); ?></p>
                <p>Địa chỉ nhận hàng: <?php echo htmlspecialchars($dh['dia_chi']); ?></p>
                <p>Ngày đặt: <?php echo htmlspecialchars($dh['ngay_dat']); ?></p>
                <p>Trạng thái: <strong><?php echo htmlspecialchars($dh['trang_thai']); ?></strong></p>
                <p>
                    Tổng tiền:
                    <strong><?php echo number_format($dh['tong_tien'], 0, ',', '.'); ?> đ</strong>
                </p>

                <h4>Chi tiết món đã đặt</h4>
                <?php
                $id_don_hang = (int) $dh['id'];
                $sql_chi_tiet = "SELECT ct.so_luong, ct.don_gia, m.ten_mon
                                 FROM chi_tiet_don_hang ct
                                 JOIN mon_uong m ON ct.mon_uong_id = m.id
                                 WHERE ct.don_hang_id = ?";
                $stmt_ct = mysqli_prepare($conn, $sql_chi_tiet);
                mysqli_stmt_bind_param($stmt_ct, "i", $id_don_hang);
                mysqli_stmt_execute($stmt_ct);
                $chi_tiet = mysqli_stmt_get_result($stmt_ct);
                ?>
                <table>
                    <tr>
                        <th>Tên món</th>
                        <th>Số lượng</th>
                        <th>Đơn giá</th>
                        <th>Thành tiền</th>
                    </tr>
                    <?php while ($ct = mysqli_fetch_assoc($chi_tiet)) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($ct['ten_mon']); ?></td>
                            <td><?php echo (int)$ct['so_luong']; ?></td>
                            <td><?php echo number_format($ct['don_gia'], 0, ',', '.'); ?> đ</td>
                            <td><?php echo number_format($ct['don_gia'] * $ct['so_luong'], 0, ',', '.'); ?> đ</td>
                        </tr>
                    <?php } ?>
                </table>
                <?php mysqli_stmt_close($stmt_ct); ?>
            <?php } ?>
        <?php } ?>
    <?php } ?>
</main>
</body>
</html>
<?php
if ($stmt) {
    mysqli_stmt_close($stmt);
}
?>
