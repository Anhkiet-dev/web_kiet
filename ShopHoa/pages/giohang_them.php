<?php
session_start();

// Kết nối DB trực tiếp
$conn = new mysqli('localhost', 'root', '', 'ShopHoa', 3307);
if($conn->connect_error){
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Kiểm tra GET
if(!isset($_GET['loai']) || !isset($_GET['ma'])){
    header("Location: ../index.php");
    exit;
}

$loai = $_GET['loai'];  // 'hoa' hoặc 'phukien'
$ma = (int)$_GET['ma'];

// Kiểm tra sản phẩm tồn tại và còn hàng
if($loai === 'hoa'){
    $sql = "SELECT MaHoa FROM hoa WHERE MaHoa = $ma AND TrangThai = 'Còn hàng'";
} elseif($loai === 'phukien'){
    $sql = "SELECT MaPhuKien FROM phukien WHERE MaPhuKien = $ma AND TrangThai = 'Còn hàng'";
} else {
    header("Location: ../index.php");
    exit;
}

$res = $conn->query($sql);
if(!$res || $res->num_rows == 0){
    // Sản phẩm không tồn tại hoặc hết hàng
    header("Location: ../index.php?page=giohang");
    exit;
}

// Khởi tạo giỏ hàng nếu chưa có
if(!isset($_SESSION['giohang'])) $_SESSION['giohang'] = [];
if(!isset($_SESSION['giohang'][$loai])) $_SESSION['giohang'][$loai] = [];

// Thêm sản phẩm vào giỏ hàng
if(isset($_SESSION['giohang'][$loai][$ma])){
    $_SESSION['giohang'][$loai][$ma] += 1;
} else {
    $_SESSION['giohang'][$loai][$ma] = 1;
}

// Lưu trang trước đó (nếu cần cho nút "Tiếp tục mua sắm")
$_SESSION['trangtruoc'] = $_SERVER['HTTP_REFERER'] ?? '../index.php';

// Redirect về giỏ hàng
header("Location: ../index.php?page=giohang");
exit;
?>
