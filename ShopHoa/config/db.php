<?php
// Thông tin kết nối MySQL
$servername = "localhost:3306";   // hoặc 127.0.0.1
$username   = "root";        // mặc định XAMPP là root
$password   = "";            // mặc định rỗng
$dbname     = "ShopHoa"; // tên database bạn đã tạo trong phpMyAdmin

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Đặt charset UTF-8 để tránh lỗi tiếng Việt
$conn->set_charset("utf8mb4");
?>
