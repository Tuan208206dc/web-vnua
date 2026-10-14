```php
<?php
session_start();
include "kn.php";

// Khoi tao gio hang neu chua co
if (!isset($_SESSION['gio_hang'])) {
    $_SESSION['gio_hang'] = array();
}

// Them mon vao gio hang
if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];

    $sql = "SELECT * FROM mon_uong
            WHERE id = $id AND trang_thai = 1";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $mon = mysqli_fetch_assoc($result);

        if (isset($_SESSION['gio_hang'][$id])) {
            $_SESSION['gio_hang'][$id]['so_luong']++;
        } else {
            $_SESSION['gio_hang'][$id] = array(
                'id' => $mon['id'],
                'ten_mon' => $mon['ten_mon'],
                'gia' => $mon['gia'],
                'so_luong' => 1
            );
        }
    }

    header("Location: gio_hang.php");
    exit();
}

// Cap nhat so luong
if (isset($_POST['cap_nhat'])) {
    if (isset($_POST['so_luong'])) {
        foreach ($_POST['so_luong'] as $id => $so_luong) {
            $id = (int) $id;
            $so_luong = (int) $so_luong;

            if ($so_luong <= 0) {
                unset($_SESSION['gio_hang'][$id]);
            } elseif (isset($_SESSION['gio_hang'][$id])) {
                $_SESSION['gio_hang'][$id]['so_luong'] = min($so_luong, 99);
            }
        }
    }
}

// Xoa mot mon khoi gio hang
if (isset($_GET['xoa'])) {
    $id = (int) $_GET['xoa'];
    unset($_SESSION['gio_hang'][$id]);

    header("Location: gio_hang.php");
    exit();
}

// Tinh tong tien
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
</nav>

<main>
    <h2>GIỎ HÀNG</h2>

    <?php if (empty($_SESSION['gio_hang'])) { ?>

        <p>Giỏ hàng đang trống.</p>
        <a href="index.php">Quay lại chọn món</a>

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

                <?php foreach ($_SESSION['gio_hang'] as $id => $mon) { ?>
                    <tr>
                        <td>
                            <?php echo htmlspecialchars($mon['ten_mon']); ?>
                        </td>

                        <td>
                            <?php echo number_format($mon['gia'], 0, ',', '.'); ?> đ
                        </td>

                        <td>
                            <input
                                type="number"
                                name="so_luong[<?php echo $id; ?>]"
                                value="<?php echo $mon['so_luong']; ?>"
                                min="0"
                                max="99"
                            >
                        </td>

                        <td>
                            <?php
                            echo number_format(
                                $mon['gia'] * $mon['so_luong'],
                                0,
                                ',',
                                '.'
                            );
                            ?> đ
                        </td>

                        <td>
                            <a href="gio_hang.php?xoa=<?php echo $id; ?>">
                                Xóa
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </table>

            <p class="gia">
                Tổng tiền:
                <?php echo number_format($tong_tien, 0, ',', '.'); ?> đ
            </p>

            <button type="submit" name="cap_nhat">
                Cập nhật giỏ hàng
            </button>

            <a href="dat_hang.php">Tiến hành đặt hàng</a>
        </form>

    <?php } ?>
</main>

</body>
</html>
```