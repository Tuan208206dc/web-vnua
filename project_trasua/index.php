```php
<?php
include "kn.php";

// Lay tu khoa tim kiem
$tu_khoa = "";

if (isset($_GET['tu_khoa'])) {
    $tu_khoa = trim($_GET['tu_khoa']);
}

// Lay danh sach mon uong
$sql = "SELECT * FROM mon_uong WHERE trang_thai = 1";

if ($tu_khoa != "") {
    $tu_khoa_sql = mysqli_real_escape_string($conn, $tu_khoa);

    $sql = "SELECT * FROM mon_uong
            WHERE trang_thai = 1
            AND ten_mon LIKE '%$tu_khoa_sql%'";
}

// Sap xep mon uong theo ID
$sql .= " ORDER BY id DESC";

// Thuc hien truy van
$result = mysqli_query($conn, $sql);

// Kiem tra truy van
if (!$result) {
    die("Loi truy van: " . mysqli_error($conn));
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

    <!-- Phan dau trang -->
    <header>
        <h1>TIỆM TRÀ SỮA</h1>
        <p>Thơm ngon trong từng ly</p>
    </header>

    <!-- Thanh dieu huong -->
    <nav>
        <a href="index.php">Trang chủ</a>
        <a href="index.php">Menu</a>
        <a href="gio_hang.php">Giỏ hàng</a>
        <a href="tra_cuu_don.php">Tra cứu đơn hàng</a>
    </nav>

    <!-- Noi dung chinh -->
    <main>

        <h2>MENU TRÀ SỮA</h2>

        <!-- Form tim kiem -->
        <form action="index.php" method="GET" class="tim-kiem">

            <input
                type="text"
                name="tu_khoa"
                placeholder="Nhập tên món trà sữa..."
                value="<?php echo htmlspecialchars($tu_khoa, ENT_QUOTES, 'UTF-8'); ?>"
            >

            <button type="submit">Tìm kiếm</button>

            <?php if ($tu_khoa != "") { ?>
                <a href="index.php">Xóa tìm kiếm</a>
            <?php } ?>

        </form>

        <!-- Danh sach mon uong -->
        <div class="menu">

            <?php
            if (mysqli_num_rows($result) > 0) {

                while ($row = mysqli_fetch_assoc($result)) {
            ?>

                    <div class="mon-uong">

                        <h3>
                            <?php
                            echo htmlspecialchars(
                                $row['ten_mon'],
                                ENT_QUOTES,
                                'UTF-8'
                            );
                            ?>
                        </h3>

                        <p class="gia">
                            <?php
                            echo number_format($row['gia'], 0, ',', '.');
                            ?> đ
                        </p>

                        <p>
                            <?php
                            echo htmlspecialchars(
                                $row['mo_ta'] ?? '',
                                ENT_QUOTES,
                                'UTF-8'
                            );
                            ?>
                        </p>

                        <a href="gio_hang.php?id=<?php echo (int)$row['id']; ?>">
                            Đặt món
                        </a>

                    </div>

            <?php
                }

            } else {
            ?>

                <p>
                    <?php
                    if ($tu_khoa != "") {
                        echo "Không tìm thấy món trà sữa phù hợp.";
                    } else {
                        echo "Hiện chưa có món uống nào.";
                    }
                    ?>
                </p>

            <?php
            }
            ?>

        </div>

    </main>

    <!-- Chan trang -->
    <footer>
        <p>© 2026 - Tiệm Trà Sữa</p>
    </footer>

</body>

</html>

<?php
// Giai phong bo nho truy van
mysqli_free_result($result);

// Dong ket noi database
mysqli_close($conn);
?>
```