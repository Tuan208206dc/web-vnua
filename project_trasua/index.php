<?php
include "kn.php";

$tu_khoa = "";

if (isset($_GET['tu_khoa'])) {
    $tu_khoa = trim($_GET['tu_khoa']);
}

if ($tu_khoa != "") {
    $sql = "SELECT * FROM mon_uong
            WHERE trang_thai = 1 AND ten_mon LIKE ?
            ORDER BY id DESC";
    $stmt = mysqli_prepare($conn, $sql);
    $tu_khoa_sql = "%" . $tu_khoa . "%";
    mysqli_stmt_bind_param($stmt, "s", $tu_khoa_sql);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
} else {
    $sql = "SELECT * FROM mon_uong
            WHERE trang_thai = 1
            ORDER BY id DESC";
    $result = mysqli_query($conn, $sql);
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tiệm Trà Sữa</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<header>
    <h1>TIỆM TRÀ SỮA</h1>
    <p>Thưởng thức những món trà sữa yêu thích</p>
</header>

<nav>
    <a href="index.php">Trang chủ</a>
    <a href="gio_hang.php">Giỏ hàng</a>
    <a href="tra_cuu_don.php">Tra cứu đơn hàng</a>
</nav>

<main>
    <h2>MENU ĐỒ UỐNG</h2>

    <form action="index.php" method="GET">
        <input
            type="text"
            name="tu_khoa"
            placeholder="Nhập tên món cần tìm"
            value="<?php echo htmlspecialchars($tu_khoa); ?>"
        >
        <button type="submit">Tìm kiếm</button>
        <a href="index.php">Xóa tìm kiếm</a>
    </form>

    <?php if (!$result || mysqli_num_rows($result) == 0) { ?>
        <p>Không tìm thấy món uống phù hợp.</p>
    <?php } else { ?>
        <table>
            <tr>
                <th>Tên món</th>
                <th>Mô tả</th>
                <th>Giá bán</th>
                <th>Thao tác</th>
            </tr>
            <?php while ($mon = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($mon['ten_mon']); ?></td>
                    <td><?php echo htmlspecialchars($mon['mo_ta'] ?? ''); ?></td>
                    <td><?php echo number_format($mon['gia'], 0, ',', '.'); ?> đ</td>
                    <td>
                        <a href="gio_hang.php?id=<?php echo (int)$mon['id']; ?>">
                            Thêm vào giỏ
                        </a>
                    </td>
                </tr>
            <?php } ?>
        </table>
    <?php } ?>
</main>
</body>
</html>
