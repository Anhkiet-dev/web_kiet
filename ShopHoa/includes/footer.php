<?php
// includes/footer.php
?>
<footer>
    <div class="footer-container">
        <div class="footer-column">
            <h3>SHOP HOA FLOWER’LNA</h3>
            <p>Chuyên cung cấp hoa tươi, quà tặng và dịch vụ điện hoa trên toàn quốc.<br>
            Cam kết chất lượng – giao hàng nhanh – giá cả hợp lý.</p>
            <p><strong>Hotline:</strong>1234567<br>
        </div>

        <div class="footer-column">
            <h3>VỀ CHÚNG TÔI</h3>
            <ul>
                <li><a href="#">Giới thiệu</a></li>
                <li><a href="#">Chính sách giao hàng</a></li>
                <li><a href="#">Chính sách đổi trả</a></li>
                <li><a href="#">Hướng dẫn đặt hàng</a></li>
                <li><a href="#">Liên hệ</a></li>
            </ul>
        </div>

        <div class="footer-column">
            <h3>LIÊN HỆ</h3>
            <p><i class="fa-solid fa-location-dot"></i> 123 Nguyễn Trãi, Q.1, TP.HCM</p>
            <p><i class="fa-solid fa-phone"></i> 0123 456 789</p>
            <p><i class="fa-solid fa-envelope"></i> contact@flowerlna.com</p>
            <div class="social-icons">
                <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                <a href="#"><i class="fa-brands fa-instagram"></i></a>
                <a href="#"><i class="fa-brands fa-tiktok"></i></a>
                <a href="#"><i class="fa-brands fa-youtube"></i></a>
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <p>© 2025 <strong>Shop Hoa FLOWER’LNA</strong>. All rights reserved.</p>
    </div>
</footer>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
footer {
    background: #111;
    color: #ddd;
    font-family: Arial, Helvetica, sans-serif;
    margin-top: 50px;
}

.footer-container {
    display: flex;
    justify-content: space-around;
    flex-wrap: wrap;
    padding: 40px 20px;
    border-top: 2px solid #333;
}

.footer-column {
    width: 300px;
    margin: 15px;
}

.footer-column h3 {
    color: #ffcc33;
    margin-bottom: 15px;
    font-size: 18px;
}

.footer-column p, 
.footer-column li {
    font-size: 14px;
    line-height: 1.8;
    color: #ccc;
}

.footer-column ul {
    list-style: none;
    padding: 0;
}

.footer-column ul li a {
    color: #ccc;
    text-decoration: none;
    transition: color 0.3s;
}

.footer-column ul li a:hover {
    color: #ff3366;
}

.social-icons a {
    display: inline-block;
    color: #fff;
    background: #333;
    margin: 5px;
    padding: 8px;
    border-radius: 50%;
    transition: all 0.3s;
}

.social-icons a:hover {
    background: #ff3366;
}

.footer-bottom {
    text-align: center;
    padding: 15px 0;
    background: #000;
    font-size: 13px;
    color: #aaa;
    border-top: 1px solid #222;
}
</style>
