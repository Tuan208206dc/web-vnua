<?php
session_start();
include "kn.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: dang_nhap.php");
    exit();
}

$thong_bao = "";

if (isset($_POST['them_mon'])) {
    $ten_mon = trim($_POST['ten_mon']);
    $gia = (float) $_POST['gia'];
    $hinh_anh = trim($_POST['hinh_anh']);
    $mo_ta = trim($_POST['mo_ta']);

    if ($ten_mon == "" || $gia <= 0) {
        $thong_bao = "Vui lòng nhập tên món và giá hợp lệ!";
    } else {
        $sql = "INSERT INTO mon_uong
                (ten_mon, gia, hinh_anh, mo_ta, trang_thai)
                VALUES (?, ?, ?, ?, 1)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sdss", $ten_mon, $gia, $hinh_anh, $mo_ta);

        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);
            header("Location: quan_ly_mon.php");
            exit();
        } else {
            $thong_bao = "Thêm món thất bại!";
        }

        mysqli_stmt_close($stmt);
    }
}

if (isset($_POST['sua_mon'])) {
    $id = (int) $_POST['id'];
    $ten_mon = trim($_POST['ten_mon']);
    $gia = (float) $_POST['gia'];
    $hinh_anh = trim($_POST['hinh_anh']);
    $mo_ta = trim($_POST['mo_ta']);

    if ($ten_mon == "" || $gia <= 0) {
        $thong_bao = "Vui lòng nhập tên món và giá hợp lệ!";
    } else {
        $sql = "UPDATE mon_uong
                SET ten_mon = ?, gia = ?, hinh_anh = ?, mo_ta = ?
                WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sdssi", $ten_mon, $gia, $hinh_anh, $mo_ta, $id);

        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);
            header("Location: quan_ly_mon.php");
            exit();
        } else {
            $thong_bao = "Cập nhật món thất bại!";
        }

        mysqli_stmt_close($stmt);
    }
}

if (isset($_GET['an'])) {
    $id = (int) $_GET['an'];
    $sql = "UPDATE mon_uong SET trang_thai = 0 WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("Location: quan_ly_mon.php");
    exit();
}

$mon_sua = null;

if (isset($_GET['sua'])) {
    $id = (int) $_GET['sua'];
    $sql = "SELECT * FROM mon_uong WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result_sua = mysqli_stmt_get_result($stmt);
    $mon_sua = mysqli_fetch_assoc($result_sua);
    mysqli_stmt_close($stmt);
}

$sql = "SELECT * FROM mon_uong ORDER BY id DESC";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý món uống</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<header>
    <h1>TIỆM TRÀ SỮA</h1>
    <p>Trang quản trị món uống</p>
</header>

<nav>
    <a href="index.php">Trang chủ</a>
    <a href="quan_ly_mon.php">Quản lý món</a>
    <a href="quan_ly_don.php">Quản lý đơn hàng</a>
    <a href="thong_ke.php">Thống kê</a>
    <a href="dang_xuat.php">Đăng xuất</a>
</nav>

<main>
    <h2>QUẢN LÝ MÓN UỐNG</h2>
    <p>Xin chào admin: <strong><?php echo htmlspecialchars($_SESSION['admin_name']); ?></strong></p>

    <?php if ($thong_bao != "") { ?>
        <p><?php echo htmlspecialchars($thong_bao); ?></p>
    <?php } ?>

    <h3><?php echo $mon_sua ? "Sửa món uống" : "Thêm món uống mới"; ?></h3>

    <form action="quan_ly_mon.php" method="POST">
        <?php if ($mon_sua) { ?>
            <input type="hidden" name="id" value="<?php echo (int)$mon_sua['id']; ?>">
        <?php } ?>

        <p>
            <label>Tên món:</label><br>
            <input
                type="text"
                name="ten_mon"
                required
                value="<?php echo $mon_sua ? htmlspecialchars($mon_sua['ten_mon']) : ''; ?>"
            >
        </p>

        <p>
            <label>Giá bán:</label><br>
            <input
                type="number"
                name="gia"
                min="1000"
                step="1"
                required
                value="<?php echo $mon_sua ? (int)$mon_sua['gia'] : ''; ?>"
            >
        </p>

        <p>
            <label>Đường dẫn hình ảnh:</label><br>
            <input
                type="text"
                name="hinh_anh"
                value="<?php echo $mon_sua ? htmlspecialchars($mon_sua['hinh_anh'] ?? '') : ''; ?>"
            >
        </p>

        <p>
            <label>Mô tả:</label><br>
            <textarea name="mo_ta"><?php echo $mon_sua ? htmlspecialchars($mon_sua['mo_ta'] ?? '') : ''; ?></textarea>
        </p>

        <?php if ($mon_sua) { ?>
            <button type="submit" name="sua_mon">Lưu thay đổi</button>
            <a href="quan_ly_mon.php">Hủy sửa</a>
        <?php } else { ?>
            <button type="submit" name="them_mon">Thêm món</button>
        <?php } ?>
    </form>

    <hr>

    <h3>Danh sách món uống</h3>
    <table>
        <tr>
            <th>ID</th>
            <th>Tên món</th>
            <th>Giá</th>
            <th>Trạng thái</th>
            <th>Thao tác</th>
        </tr>
        <?php while ($mon = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?php echo (int)$mon['id']; ?></td>
                <td><?php echo htmlspecialchars($mon['ten_mon']); ?></td>
                <td><?php echo number_format($mon['gia'], 0, ',', '.'); ?> đ</td>
                <td><?php echo $mon['trang_thai'] == 1 ? "Đang bán" : "Đã ẩn"; ?></td>
                <td>
                    <a href="quan_ly_mon.php?sua=<?php echo (int)$mon['id']; ?>">Sửa</a>
                    <?php if ($mon['trang_thai'] == 1) { ?>
                        |
                        <a
                            href="quan_ly_mon.php?an=<?php echo (int)$mon['id']; ?>"
                            onclick="return confirm('Bạn có chắc muốn ẩn món này?')"
                        >Ẩn món</a>
                    <?php } ?>
                </td>
            </tr>
        <?php } ?>
    </table>
</main>
</body>
</html>
