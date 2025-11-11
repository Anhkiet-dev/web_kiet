<?php
// includes/header.php
session_start();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Shop Hoa FLOWER'LNA</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
    * { margin:0; padding:0; box-sizing:border-box; }
    body { font-family: Arial, Helvetica, sans-serif; background:#fff; }
    header { background: #1a1a1a; color:#f1f1f1; }
    .top-header { display:flex; align-items:center; justify-content:space-between; padding:10px 60px; gap:30px; }
    .logo img { height:90px; width:auto; display:block; }
    .search-box { flex:1; max-width:420px; display:flex; justify-content:center; }
    .search-box form { display:flex; width:100%; }
    .search-box input[type="text"] { width:100%; padding:10px 14px; border:1px solid #666; border-radius:25px 0 0 25px; background:#2a2a2a; color:#fff; outline:none; transition:all 0.3s; }
    .search-box input[type="text"]:focus { border-color:#ff6699; }
    .search-box button { padding:10px 18px; border:none; background:#ff3366; color:white; font-weight:bold; border-radius:0 25px 25px 0; cursor:pointer; transition: background 0.3s; }
    .search-box button:hover { background:#ff6699; }
    .right-icons { display:flex; align-items:center; justify-content:flex-end; gap:25px; }
    .hotline { text-align:right; font-size:14px; color:#ffc107; line-height:18px; }
    .hotline span { display:block; color:#fff; font-weight:bold; font-size:13px; margin-bottom:3px; }
    .zalo-btn { background:#0048ff; color:#fff; padding:4px 10px; border-radius:6px; text-decoration:none; font-size:12px; display:inline-block; margin-top:4px; transition:background 0.3s; }
    .zalo-btn:hover { background:#006aff; }
    .right-icons a { color:white; text-decoration:none; display:flex; align-items:center; gap:6px; font-size:14px; transition:color 0.3s ease; }
    .right-icons a:hover { color:#ffcc33; }
    .right-icons i { font-size:18px; }
    .header_nav { list-style:none; display:flex; justify-content:center; align-items:center; background:#000; padding:0; margin:0; border-top:1px solid #333; border-bottom:1px solid #333; position:relative; z-index:100; }
    .header_nav > li { position:relative; margin:0 15px; }
    .header_nav > li > a, .header_nav > li > h2 > a { color:#f1f1f1; text-decoration:none; font-weight:bold; font-size:15px; display:block; padding:14px 10px; text-transform:uppercase; letter-spacing:0.5px; transition: color 0.3s ease; }
    .header_nav > li:hover > a, .header_nav > li:hover > h2 > a { color:#ffcc33; }
    .header_nav li.has_child div { display:none; position:absolute; top:100%; left:0; background:#111; border-radius:0 0 5px 5px; box-shadow:0 4px 10px rgba(0,0,0,0.3); padding:10px 0; min-width:240px; }
    .header_nav li.has_child:hover div { display:block; }
    .header_nav li.has_child div h3 { margin:0; padding:0; }
    .header_nav li.has_child div h3 a { display:block; padding:10px 15px; color:#fff; font-size:14px; text-decoration:none; border-bottom:1px solid #222; transition:all 0.3s ease; }
    .header_nav li.has_child div h3 a:hover { background:#ff3366; color:#fff; padding-left:20px; }
    .header_nav li.has_child div h3:last-child a { border-bottom:none; }
    </style>
</head>
<body>

<header>
    <div class="top-header">
        <!-- Logo -->
        <div class="logo">
            <a href="../index.php"><img src="images/logoshop.png" alt="Hoa FLOWER'LNA"></a>
        </div>

        <!-- Search box -->
        <div class="search-box">
            <form action="search.php" method="get" style="width:100%; display:flex;">
                <input type="text" name="keyword" placeholder="Tìm sản phẩm...">
                <button type="submit">Tìm kiếm</button>
            </form>
        </div>

        <!-- Hotline + Icons -->
        <div class="right-icons">
            <div class="hotline">
                <span>HOTLINE</span> 123567<br>
                <a class="zalo-btn" href="#">Zalo</a>
            </div>

            <a href="pages/giohang.php"><i class="fa-solid fa-bag-shopping"></i> Giỏ hàng</a>

            <?php
            // Kiểm tra đăng nhập
            if(isset($_SESSION['HoTen'])) {
                $user_name = $_SESSION['HoTen'];
                echo '<span><i class="fa-solid fa-user"></i> '.htmlspecialchars($user_name).'</span> | ';
                echo '<a href="pages/dangxuat.php" style="color:#ff6666;">Đăng xuất</a>';
            } else {
                echo '<a href="pages/dangnhap.php"><i class="fa-solid fa-user"></i> Tài khoản</a>';
            }
            ?>
        </div>

    </div>

    <!-- Menu -->
    <ul class="header_nav">
        <li><strong><a href="index.php?page=home">Trang chủ</a></strong></li>
        <li class="has_child"><h2><a href="index.php?page=ChuDe">Chủ đề</a></h2></li>
        <li class="has_child"><h2><a href="index.php?page=HoaTuoi">Hoa tươi</a></h2></li>
        <li class="has_child"><h2><a href="index.php?page=MauSac">Màu sắc</a></h2></li>
        <li class="has_child"><h2><a href="index.php?page=PhuKien">Phụ Kiện</a></h2></li>
    </ul>
</header>
