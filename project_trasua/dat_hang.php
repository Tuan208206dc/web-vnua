```php
<?php
session_start();
include "kn.php";

// Kiem tra gio hang
if (!isset($_SESSION['gio_hang']) || empty($_SESSION['gio_hang'])) {
    header("Location: gio_hang.php");
    exit();
}

$thong_bao = "";
$ma_don_hang = 0;

// Tinh tong tien
$tong_tien = 0;

foreach ($_SESSION['gio_hang'] as $mon) {
    $tong_tien += $mon['gia'] * $mon['so_luong'];
}

// Xu ly khi khach bam dat hang
if (isset($_POST['dat_hang'])) {
    $ten_khach = trim($_POST['ten_khach']);
    $so_dien_thoai = trim($_POST['so_dien_thoai']);
    $dia_chi = trim($_POST['dia_chi']);

    // Kiem tra thong tin
    if ($ten_khach == "" || $so_dien_thoai == "" || $dia_chi == "") {
        $thong_bao = "Vui long nhap day du thong tin!";
    } elseif (!preg_match('/^[0-9]{10,11}$/', $so_dien_thoai)) {
        $thong_bao = "So dien thoai phai co 10 hoac 11 chu so!";
    } else {
        // Bat dau giao dich
        mysqli_begin_transaction($conn);

        try {
            // Luu thong tin don hang
            $sql = "INSERT INTO don_hang
                    (ten_khach, so_dien_thoai, dia_chi, tong_tien)
                    VALUES (?, ?, ?, ?)";

            $stmt = mysqli_prepare($conn, $sql);

            mysqli_stmt_bind_param(
                $stmt,
                "sssd",
                $ten_khach,
                $so_dien_thoai,
                $dia_chi,
                $tong_tien
            );

            mysqli_stmt_execute($stmt);

            // Lay ma don hang vua tao
            $ma_don_hang = mysqli_insert_id($conn);

            mysqli_stmt_close($stmt);

            // Luu chi tiet tung mon trong don hang
            $sql_chi_tiet = "INSERT INTO chi_tiet_don_hang
                            (don_hang_id, mon_uong_id, so_luong, don_gia)
                            VALUES (?, ?, ?, ?)";

            $stmt_chi_tiet = mysqli_prepare($conn, $sql_chi_tiet);

            foreach ($_SESSION['gio_hang'] as $mon) {
                $don_hang_id = $ma_don_hang;
                $mon_uong_id = (int) $mon['id'];
                $so_luong = (int) $mon['so_luong'];
                $don_gia = (float) $mon['gia'];

                mysqli_stmt_bind_param(
                    $stmt_chi_tiet,
                    "iiid",
                    $don_hang_id,
                    $mon_uong_id,
                    $so_luong,
                    $don_gia
                );

                mysqli_stmt_execute($stmt_chi_tiet);
            }

            mysqli_stmt_close($stmt_chi_tiet);

            // Hoan tat giao dich
            mysqli_commit($conn);

            // Xoa gio hang sau khi dat thanh cong
            unset($_SESSION['gio_hang']);

            $thong_bao = "Dat hang thanh cong!";

        } catch (Throwable $e) {
            mysqli_rollback($conn);
            $thong_bao = "Dat hang that bai. Vui long thu lai!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt hàng - Tiệm Trà Sữa</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<header>
    <h1>TIỆM TRÀ SỮA</h1>
    <p>Đặt hàng trực tuyến</p>
</header>

<nav>
    <a href="index.php">Trang chủ</a>
    <a href="gio_hang.php">Giỏ hàng</a>
</nav>

<main>
    <h2>THÔNG TIN ĐẶT HÀNG</h2>

    <?php if ($ma_don_hang > 0) { ?>

        <p><?php echo htmlspecialchars($thong_bao); ?></p>

        <h3>Mã đơn hàng: <?php echo $ma_don_hang; ?></h3>

        <p>
            Tổng tiền:
            <?php echo number_format($tong_tien, 0, ',', '.'); ?> đ
        </p>

        <p>
            Bạn hãy lưu lại mã đơn hàng và số điện thoại
            để tra cứu đơn hàng sau này.
        </p>

        <a href="index.php">Tiếp tục xem menu</a>

    <?php } else { ?>

        <?php if ($thong_bao != "") { ?>
            <p><?php echo htmlspecialchars($thong_bao); ?></p>
        <?php } ?>

        <h3>Danh sách món đã chọn</h3>

        <table>
            <tr>
                <th>Tên món</th>
                <th>Số lượng</th>
                <th>Thành tiền</th>
            </tr>

            <?php foreach ($_SESSION['gio_hang'] as $mon) { ?>
                <tr>
                    <td>
                        <?php echo htmlspecialchars($mon['ten_mon']); ?>
                    </td>

                    <td>
                        <?php echo $mon['so_luong']; ?>
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
                </tr>
            <?php } ?>
        </table>

        <h3>
            Tổng tiền:
            <?php echo number_format($tong_tien, 0, ',', '.'); ?> đ
        </h3>

        <form action="dat_hang.php" method="POST">
            <p>
                <label>Họ và tên:</label><br>
                <input
                    type="text"
                    name="ten_khach"
                    required
                    value="<?php
                    echo isset($_POST['ten_khach'])
                        ? htmlspecialchars($_POST['ten_khach'])
                        : '';
                    ?>"
                >
            </p>

            <p>
                <label>Số điện thoại:</label><br>
                <input
                    type="text"
                    name="so_dien_thoai"
                    required
                    maxlength="11"
                    value="<?php
                    echo isset($_POST['so_dien_thoai'])
                        ? htmlspecialchars($_POST['so_dien_thoai'])
                        : '';
                    ?>"
                >
            </p>

            <p>
                <label>Địa chỉ nhận hàng:</label><br>
                <textarea
                    name="dia_chi"
                    required
                ><?php
                echo isset($_POST['dia_chi'])
                    ? htmlspecialchars($_POST['dia_chi'])
                    : '';
                ?></textarea>
            </p>

            <button type="submit" name="dat_hang">
                Xác nhận đặt hàng
            </button>
        </form>

    <?php } ?>
</main>

</body>
</html>
```