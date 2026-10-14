
<?php
session_start();
include "kn.php";

// Kiem tra dang nhap
if (!isset($_SESSION['admin_id'])) {
    header("Location: dang_nhap.php");
    exit();
}

// Cap nhat trang thai don hang
if (isset($_POST['cap_nhat'])) {
    $id = (int) $_POST['id'];
    $trang_thai = $_POST['trang_thai'];

    $trang_thai_hop_le = array(
        "Chờ xác nhận",
        "Đang giao",
        "Hoàn thành",
        "Đã hủy"
    );

    if (in_array($trang_thai, $trang_thai_hop_le, true)) {
        $sql = "UPDATE don_hang SET trang_thai = ? WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);

        mysqli_stmt_bind_param($stmt, "si", $trang_thai, $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }

    header("Location: quan_ly_don.php");
    exit();
}

// Lay danh sach don hang
$sql = "SELECT * FROM don_hang ORDER BY ngay_dat DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý đơn hàng</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<header>
    <h1>TIỆM TRÀ SỮA</h1>
    <p>Quản lý đơn hàng</p>
</header>

<nav>
    <a href="index.php">Trang chủ</a>
    <a href="quan_ly_mon.php">Quản lý món</a>
    <a href="quan_ly_don.php">Quản lý đơn hàng</a>
    <a href="thong_ke.php">Thống kê</a>
    <a href="dang_xuat.php">Đăng xuất</a>
</nav>

<main>
    <h2>DANH SÁCH ĐƠN HÀNG</h2>

    <?php if (mysqli_num_rows($result) == 0) { ?>
        <p>Chưa có đơn hàng nào.</p>
    <?php } else { ?>

        <table>
            <tr>
                <th>Mã đơn</th>
                <th>Khách hàng</th>
                <th>Số điện thoại</th>
                <th>Địa chỉ</th>
                <th>Tổng tiền</th>
                <th>Ngày đặt</th>
                <th>Trạng thái</th>
                <th>Cập nhật</th>
            </tr>

            <?php while ($don = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo $don['id']; ?></td>

                    <td>
                        <?php echo htmlspecialchars($don['ten_khach']); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($don['so_dien_thoai']); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($don['dia_chi']); ?>
                    </td>

                    <td>
                        <?php
                        echo number_format(
                            $don['tong_tien'],
                            0,
                            ',',
                            '.'
                        );
                        ?> đ
                    </td>

                    <td>
                        <?php echo htmlspecialchars($don['ngay_dat']); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($don['trang_thai']); ?>
                    </td>

                    <td>
                        <form action="quan_ly_don.php" method="POST">
                            <input
                                type="hidden"
                                name="id"
                                value="<?php echo $don['id']; ?>"
                            >

                            <select name="trang_thai">
                                <?php
                                $cac_trang_thai = array(
                                    "Chờ xác nhận",
                                    "Đang giao",
                                    "Hoàn thành",
                                    "Đã hủy"
                                );

                                foreach ($cac_trang_thai as $tt) {
                                ?>
                                    <option
                                        value="<?php echo $tt; ?>"
                                        <?php
                                        echo $don['trang_thai'] == $tt
                                            ? "selected"
                                            : "";
                                        ?>
                                    >
                                        <?php echo $tt; ?>
                                    </option>
                                <?php } ?>
                            </select>

                            <button type="submit" name="cap_nhat">
                                Lưu
                            </button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </table>

    <?php } ?>
</main>

</body>
</html>
