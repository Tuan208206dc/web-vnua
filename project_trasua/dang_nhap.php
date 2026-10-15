<?php
session_start();
include "kn.php";

$thong_bao = "";

if (isset($_POST['dang_nhap'])) {
    $ten_dang_nhap = trim($_POST['ten_dang_nhap']);
    $mat_khau = $_POST['mat_khau'];

    $sql = "SELECT * FROM tai_khoan_admin WHERE ten_dang_nhap = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $ten_dang_nhap);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) == 1) {
        $admin = mysqli_fetch_assoc($result);

        if (password_verify($mat_khau, $admin['mat_khau'])) {
            session_regenerate_id(true);
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_name'] = $admin['ten_dang_nhap'];

            mysqli_stmt_close($stmt);
            header("Location: quan_ly_mon.php");
            exit();
        } else {
            $thong_bao = "Sai tên đăng nhập hoặc mật khẩu!";
        }
    } else {
        $thong_bao = "Sai tên đăng nhập hoặc mật khẩu!";
    }

    mysqli_stmt_close($stmt);
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập quản trị</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<header>
    <h1>TIỆM TRÀ SỮA</h1>
    <p>Đăng nhập quản trị viên</p>
</header>

<main>
    <h2>ĐĂNG NHẬP ADMIN</h2>

    <?php if ($thong_bao != "") { ?>
        <p><?php echo htmlspecialchars($thong_bao); ?></p>
    <?php } ?>

    <form action="dang_nhap.php" method="POST">
        <p>
            <label>Tên đăng nhập:</label><br>
            <input type="text" name="ten_dang_nhap" required>
        </p>
        <p>
            <label>Mật khẩu:</label><br>
            <input type="password" name="mat_khau" required>
        </p>
        <button type="submit" name="dang_nhap">Đăng nhập</button>
    </form>

    <p><a href="index.php">Quay lại trang chủ</a></p>
</main>
</body>
</html>
