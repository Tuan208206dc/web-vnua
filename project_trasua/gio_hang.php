<?php
session_start();
include "kn.php";

if (!isset($_SESSION['gio_hang'])) {
    $_SESSION['gio_hang'] = array();
}

if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];

    if ($id > 0) {
        $sql = "SELECT * FROM mon_uong WHERE id = ? AND trang_thai = 1";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result_mon = mysqli_stmt_get_result($stmt);
        $mon = mysqli_fetch_assoc($result_mon);
        mysqli_stmt_close($stmt);

        if ($mon) {
            if (isset($_SESSION['gio_hang'][$id])) {
                $_SESSION['gio_hang'][$id]['so_luong']++;
            } else {
                $_SESSION['gio_hang'][$id] = array(
                    "id" => (int) $mon['id'],
                    "ten_mon" => $mon['ten_mon'],
                    "gia" => (float) $mon['gia'],
                    "so_luong" => 1
                );
            }
        }
    }

    header("Location: gio_hang.php");
    exit();
}

if (isset($_POST['cap_nhat'])) {
    if (isset($_POST['so_luong']) && is_array($_POST['so_luong'])) {
        foreach ($_POST['so_luong'] as $id => $so_luong) {
            $id = (int) $id;
            $so_luong = (int) $so_luong;

            if ($so_luong <= 0) {
                unset($_SESSION['gio_hang'][$id]);
            } elseif (isset($_SESSION['gio_hang'][$id])) {
                $_SESSION['gio_hang'][$id]['so_luong'] = $so_luong;
            }
        }
    }

    header("Location: gio_hang.php");
    exit();
}

if (isset($_GET['xoa'])) {
    $id = (int) $_GET['xoa'];
    unset($_SESSION['gio_hang'][$id]);

    header("Location: gio_hang.php");
    exit();
}

$tong_tien = 0;

foreach ($_SESSION['gio_hang'] as $mon) {
    $tong_tien += $mon['gia'] * $mon['so_luong'];
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ hàng - Tiệm Trà Sữa</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<header>
    <h1>TIỆM TRÀ SỮA</h1>
    <p>Giỏ hàng của bạn</p>
</header>

<nav>
    <a href="index.php">Trang chủ</a>
    <a href="gio_hang.php">Giỏ hàng</a>
    <a href="tra_cuu_don.php">Tra cứu đơn hàng</a>
</nav>

<main>
    <h2>GIỎ HÀNG</h2>

    <?php if (empty($_SESSION['gio_hang'])) { ?>
        <p>Giỏ hàng đang trống.</p>
        <a href="index.php">Quay lại menu</a>
    <?php } else { ?>
        <form action="gio_hang.php" method="POST">
            <table>
                <tr>
                    <th>Tên món</th>
                    <th>Đơn giá</th>
                    <th>Số lượng</th>
                    <th>Thành tiền</th>
                    <th>Thao tác</th>
                </tr>
                <?php foreach ($_SESSION['gio_hang'] as $mon) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($mon['ten_mon']); ?></td>
                        <td><?php echo number_format($mon['gia'], 0, ',', '.'); ?> đ</td>
                        <td>
                            <input
                                type="number"
                                name="so_luong[<?php echo (int)$mon['id']; ?>]"
                                min="0"
                                value="<?php echo (int)$mon['so_luong']; ?>"
                            >
                        </td>
                        <td>
                            <?php echo number_format($mon['gia'] * $mon['so_luong'], 0, ',', '.'); ?> đ
                        </td>
                        <td>
                            <a href="gio_hang.php?xoa=<?php echo (int)$mon['id']; ?>">
                                Xóa
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </table>

            <button type="submit" name="cap_nhat">Cập nhật giỏ hàng</button>
        </form>

        <h3>Tổng tiền: <?php echo number_format($tong_tien, 0, ',', '.'); ?> đ</h3>
        <a href="dat_hang.php">Tiến hành đặt hàng</a>
        <p><a href="index.php">Tiếp tục chọn món</a></p>
    <?php } ?>
</main>
</body>
</html>
