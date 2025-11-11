<?php
include_once('header_admin.php');
?>

<main style="padding:20px;">
    <h2>Trang quản trị Admin</h2>
    <p>Chào mừng <strong><?php echo htmlspecialchars($_SESSION['AdminHoTen']); ?></strong> đến với bảng điều khiển Admin.</p>
    <p>Chọn chức năng từ menu phía trên để quản lý hệ thống.</p>
</main>

</body>
</html>
