<?php
session_start();
if(!isset($_SESSION['AdminHoTen'])) {
    header("Location: login_admin.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
    <style>
        body { font-family: Arial; margin:0; padding:0; background:#f9f9f9; }
        header { background:#1a1a1a; color:#fff; padding:15px 30px; display:flex; justify-content:space-between; align-items:center; }
        header h1 { margin:0; font-size:20px; }
        nav ul { list-style:none; display:flex; gap:20px; margin:0; padding:0; }
        nav ul li a { color:#fff; text-decoration:none; font-weight:bold; }
        nav ul li a:hover { color:#ffcc33; }
        .logout { color:#ff6666; text-decoration:none; margin-left:15px; }
    </style>
</head>
<body>
<header>
    <h1>Admin: <?php echo htmlspecialchars($_SESSION['AdminHoTen']); ?></h1>
    <nav>
        <ul>
            <li><a href="QLNHANVIEN/ql_nhanvien.php">Quản lý Nhân viên</a></li>
            <li><a href="QLHOA/ql_hoa.php">Quản lý Hoa</a></li>
            <li><a href="QLPHUKIEN/ql_phukien.php">Quản lý Phụ kiện</a></li>
            <li><a href="QLDONHANG/ql_donhang.php">Quản lý Đơn Hàng</a></li>
            <li><a href="ql_hoa.php">Quản lý Khách Hàng</a></li>
            <li><a href="ql_baiviet.php">Quản lý Bài viết</a></li>
            <li><a href="ql_banner.php">Quản lý Banner</a></li>
            <li><a href="ql_chinhanh.php">Quản lý Chi nhánh</a></li>
            <li><a href="ql_hoa.php">Quản lý NCC</a></li>
            <li><a href="dangxuat_admin.php" class="logout">Đăng xuất</a></li>
        </ul>
    </nav>
</header>
<hr style="margin:0;">
