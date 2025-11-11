<?php
// Kết nối database
include 'db.php';

// Lấy danh sách sản phẩm
$sql = "SELECT * FROM hoa";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Shop Hoa Tươi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #fff8f0;
        }
        header {
            width: 100%;
            display: block;
            clear: both;
            position: relative;
            float: left;
            margin-top: 10px;
        }
        /* Reset cơ bản */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .wrapper {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 15px 20px;
            background-color: #fff;
            border-bottom: 1px solid #ddd;
            flex-wrap: wrap;
        }

        /* Logo */
        .logo img {
            max-height: 60px;
            transition: transform 0.3s;
        }
        .logo img:hover {
            transform: scale(1.1);
        }

        /* Search */
        .search {
            flex: 1;
            display: flex;
            align-items: center;
            gap: 10px;
            position: relative;
        }

        .search input {
            flex: 1;
            padding: 8px 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
            transition: border 0.3s;
        }
        .search input:focus {
            outline: none;
            border-color: #ff6b81;
        }

        .btnsearch {
            padding: 8px 15px;
            background-color: #ff6b81;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            transition: background 0.3s;
        }
        .btnsearch:hover {
            background-color: #ff4757;
        }

        /* Hotline và Zalo */
        .support {
            display: flex;
            flex-direction: column;
            font-size: 12px;
            color: #333;
            text-decoration: none;
            margin-left: 10px;
            text-align: center;
        }
        .support strong {
            font-size: 14px;
            color: #ff6b81;
        }
        .support span {
            font-size: 12px;
            color: #555;
        }

        .zaloOA img {
            width: 35px;
            height: 35px;
            cursor: pointer;
            margin-left: 10px;
        }

        .zalo-oa {
            position: absolute;
            top: 45px;
            left: 0;
            display: none;
            background: #fff;
            border: 1px solid #ddd;
            padding: 5px;
            z-index: 100;
        }

        .close-zalo {
            position: absolute;
            top: 5px;
            right: 5px;
            cursor: pointer;
            color: #ff6b81;
            font-weight: bold;
        }

        /* Giỏ hàng */
        .cart a {
            display: flex;
            align-items: center;
            gap: 5px;
            text-decoration: none;
            color: #333;
            padding: 5px 10px;
            border-radius: 5px;
            transition: background 0.3s;
        }
        .cart a:hover {
            background-color: #ffefef;
        }
        .cart img {
            height: 24px;
        }

        /* Tài khoản */
        .my-account {
            position: relative;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .my-account img {
            height: 35px;
            border-radius: 50%;
        }

        .my-account a {
            text-decoration: none;
            color: #333;
            font-size: 14px;
        }

        .signin-dropdown {
            position: absolute;
            top: 45px;
            right: 0;
            width: 220px;
            background: #fff;
            border: 1px solid #ddd;
            padding: 10px;
            display: none;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            border-radius: 5px;
        }

        .my-account:hover .signin-dropdown {
            display: block;
        }

        .sign-in,
        .register,
        .login-gg,
        .login-fb {
            display: block;
            margin: 5px 0;
            text-decoration: none;
            color: #ff6b81;
            font-weight: bold;
            font-size: 13px;
        }

        .dac strong,
        .npf strong {
            display: block;
            margin-bottom: 5px;
            font-size: 13px;
        }

        .dac a,
        .npf ul li {
            font-size: 12px;
            color: #555;
        }

        .npf ul {
            list-style: disc;
            margin-left: 15px;
        }

    </style>
</head>
<body>

<div class="wrapper clearfix">
        <div class="logo">
            <a href="/" title="Shop hoa yêu thương"><img src="/images/logo-hoa-yeu-thuong.png"></a>
        </div>
        <div class="search">
            <input id="txtSearch" type="text" placeholder="Tìm sản phẩm" onkeypress="txtSearchKeyUp()">
            <a href="javascript:void(0);" onclick="SearchItem();" class="btnsearch">Tìm kiếm</a>
            <a href="tel:02873002010" class="support">
                <strong>Hotline Miền Nam</strong>
                <span>028 73002010</span>
            </a>
            <a href="tel:02873002010" class="support">
                <strong>Hotline Miền Bắc</strong>
                <span>024 73002010</span>
            </a>
            <a href="javascript:void(0);" class="support zaloOA" onclick="ShowZalo(this);">
                <img src="/images/zalo-chat-icon.png">
            </a>
            <div class="zalo-oa">
                <script src="https://sp.zalo.me/plugins/sdk.js"></script>
                <div class="zalo-follow-button" data-oaid="1438598198492740243" data-cover="no" data-article="3" data-width="195" data-height="365" style="overflow: hidden; display: inline-block;"><iframe frameborder="0" allowfullscreen="" scrolling="yes" width="195px" height="365px" src="https://sp.zalo.me/plugins/follow?oaid=1438598198492740243&amp;cover=no&amp;width=195px&amp;height=365px&amp;article=3&amp;color=yes&amp;domain=hoayeuthuong.com&amp;android=false&amp;ios=false"></iframe></div>
                <a href="javascript:void(0);" class="close-zalo" onclick="$('.zalo-oa').toggle();">X</a>
            </div>
        </div>
        <div class="cart">
            <a id="shopping-cart" href="javascript:void(0);"><img src="/images/shopping-bag.png"><strong>Giỏ hàng</strong></a>
        </div>
        <div class="my-account">
            <img id="ctl00_ucHeader_imgUser" src="/images/user.png" style="border-width:0px;">
            <a id="ctl00_ucHeader_hplMyAccount" title="Tài khoản" href="/account/account.aspx?lang=vn">Tài khoản</a>
            <div id="ctl00_ucHeader_pnlSignin" class="signin-dropdown">
	
                <a href="/account/account.aspx?lang=vn" title="Sign in" class="sign-in">Sign in</a>
                <div class="dac">
                    <strong>Bạn chưa chưa có tài khoản?</strong>
                    <a href="/account/account.aspx?lang=vn" title="Nhấn vào đây" class="register">Nhấn vào đây</a>
                </div>
                <a href="javascript:void(0);" class="login-fb" onclick="LoginFB()" style="display:none;">Login with Facebook</a>
                <a href="javascript:void(0);" id="btnSignInGG" class="login-gg">Sign in with Google</a>
                <a href="/account/forgot.aspx?lang=vn">Quên mật khẩu</a>
                <div class="npf">
                    <strong>Lợi ích khi đăng ký</strong>
                    <ul>
                        <li>Được giảm giá từ 3-10%</li>
                        <li>Nhận được các chương trình khuyến mãi</li>
                    </ul>
                </div>
            
</div>
            
        </div>
    </div>

<nav>
    <a href="index.php">Trang chủ</a>
    <a href="danhmuc.php">Danh mục</a>
    <a href="giohang.php">Giỏ hàng</a>
    <a href="lienhe.php">Liên hệ</a>
</nav>

<div class="container">
    <?php
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo '<div class="product-card">';
            echo '<img src="images/'.$row["hinhanh"].'" alt="'.$row["ten"].'">';
            echo '<h3>'.$row["ten"].'</h3>';
            echo '<p>'.$row["mota"].'</p>';
            echo '<p class="price">'.number_format($row["gia"], 0, ',', '.').' VNĐ</p>';
            echo '<a class="btn" href="chitiet.php?id='.$row["id"].'">Xem chi tiết</a>';
            echo '</div>';
        }
    } else {
        echo "<p>Chưa có sản phẩm nào!</p>";
    }
    ?>
</div>

<footer>
    <p>&copy; 2025 Shop Hoa Tươi. All rights reserved.</p>
</footer>

</body>
</html>
