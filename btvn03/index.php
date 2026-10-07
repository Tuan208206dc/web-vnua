<?php
require_once "kn.php";

$id = "";
$ten_sp = "";
$gia = "";
$so_luong = "";
$mo_ta = "";

// Thêm và sửa
if (isset($_POST["luu"])) {
    $id = $_POST["id"];
    $ten_sp = $_POST["ten_sp"];
    $gia = $_POST["gia"];
    $so_luong = $_POST["so_luong"];
    $mo_ta = $_POST["mo_ta"];

    if ($id == "") {
        $sql = "INSERT INTO san_pham(ten_sp, gia, so_luong, mo_ta)
                VALUES('$ten_sp', '$gia', '$so_luong', '$mo_ta')";
    } else {
        $sql = "UPDATE san_pham
                SET ten_sp='$ten_sp', gia='$gia',
                    so_luong='$so_luong', mo_ta='$mo_ta'
                WHERE id=$id";
    }

    mysqli_query($conn, $sql);
    header("Location: index.php");
    exit;
}

// Xóa
if (isset($_GET["xoa"])) {
    $id = $_GET["xoa"];

    mysqli_query($conn, "DELETE FROM san_pham WHERE id=$id");

    header("Location: index.php");
    exit;
}

// lấy dữ liệu để sửa
if (isset($_GET["sua"])) {
    $id = $_GET["sua"];

    $kq = mysqli_query($conn, "SELECT * FROM san_pham WHERE id=$id");
    $sp = mysqli_fetch_assoc($kq);

    $ten_sp = $sp["ten_sp"];
    $gia = $sp["gia"];
    $so_luong = $sp["so_luong"];
    $mo_ta = $sp["mo_ta"];
}

// lấy danh sách
$ds = mysqli_query($conn, "SELECT * FROM san_pham");
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý sản phẩm</title>
</head>

<body>

<h2>Quản lý sản phẩm</h2>

<form method="post">

    <input type="hidden" name="id" value="<?php echo $id; ?>">

    Tên:
    <input type="text" name="ten_sp"
           value="<?php echo $ten_sp; ?>" required>

    Giá:
    <input type="number" name="gia"
           value="<?php echo $gia; ?>" required>

    Số lượng:
    <input type="number" name="so_luong"
           value="<?php echo $so_luong; ?>" required>

    Mô tả:
    <input type="text" name="mo_ta"
           value="<?php echo $mo_ta; ?>">

    <button type="submit" name="luu">
        <?php
        if ($id == "") {
            echo "Thêm";
        } else {
            echo "Cập nhật";
        }
        ?>
    </button>

</form>

<br>

<table border="1">

<tr>
    <th>ID</th>
    <th>Tên</th>
    <th>Giá</th>
    <th>Số lượng</th>
    <th>Mô tả</th>
    <th>Chức năng</th>
</tr>

<?php while ($sp = mysqli_fetch_assoc($ds)) { ?>

<tr>
    <td><?php echo $sp["id"]; ?></td>
    <td><?php echo $sp["ten_sp"]; ?></td>
    <td><?php echo $sp["gia"]; ?></td>
    <td><?php echo $sp["so_luong"]; ?></td>
    <td><?php echo $sp["mo_ta"]; ?></td>

    <td>
        <a href="?sua=<?php echo $sp["id"]; ?>">Sửa</a>

        <a href="?xoa=<?php echo $sp["id"]; ?>">
            Xóa
        </a>
    </td>
</tr>

<?php } ?>

</table>

</body>
</html>