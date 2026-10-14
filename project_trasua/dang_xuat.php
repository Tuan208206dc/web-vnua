
<?php
session_start();

// Xoa toan bo thong tin dang nhap
$_SESSION = array();

// Huy session
session_destroy();

// Quay ve trang dang nhap
header("Location: dang_nhap.php");
exit();
?>
