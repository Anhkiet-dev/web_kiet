<?php
if(!isset($_GET['MaHoa']) || !is_numeric($_GET['MaHoa'])){
    echo "<p>Sản phẩm không tồn tại</p>";
    exit;
}

$mahoa = (int)$_GET['MaHoa'];

$stmt = $conn->prepare("
    SELECT h.*, l.TenLoai, c.TenChuDe
    FROM Hoa h
    LEFT JOIN LoaiHoa l ON h.MaLoai = l.MaLoai
    LEFT JOIN ChuDe c ON h.MaChuDe = c.MaChuDe
    WHERE h.MaHoa = ?
");
$stmt->bind_param("i", $mahoa);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows == 0){
    echo "<p>Sản phẩm không tồn tại</p>";
    exit;
}

$hoa = $result->fetch_assoc();
$stmt->close();
?>

<style>
.product-detail {
    display: flex;
    gap: 40px;
    max-width: 100%;
    margin: 40px auto;
    background-color: #1a1a1a;
    padding: 30px;
    border-radius: 10px;
    color: #fff;
}
.product-detail .image-col {
    flex: 1;
    text-align: center;
}
.product-detail .image-col img {
    width: 100%;
    max-width: 400px;
    border-radius: 10px;
    object-fit: cover;
}
.product-detail .info-col {
    flex: 1;
}
.product-detail .info-col h1 {
    color: #ff3333;
    margin-bottom: 15px;
}
.product-detail .info-col p {
    font-size: 16px;
    margin-bottom: 10px;
}
.product-detail .price {
    color: #ffcc00;
    font-weight: bold;
    font-size: 20px;
    margin-bottom: 15px;
}
.product-detail form input[type="number"] {
    width: 60px;
    padding: 5px;
    margin-right: 10px;
    border-radius: 5px;
    border: 1px solid #ccc;
}
.product-detail form button {
    background-color: #ff9900;
    color: #fff;
    border: none;
    padding: 8px 15px;
    border-radius: 5px;
    cursor: pointer;
    margin-right: 10px;
}
.product-detail form button:hover {
    background-color: #e68a00;
}
.product-detail a.back-link {
    display: inline-block;
    margin-top: 20px;
    color: #ff9900;
    text-decoration: none;
}
.product-detail a.back-link:hover {
    text-decoration: underline;
}
@media(max-width:768px){
    .product-detail {
        flex-direction: column;
        text-align: center;
    }
    .product-detail .info-col {
        margin-top: 20px;
    }
}
</style>

<div class="product-detail">
    <div class="image-col">
        <img src="images/<?php echo htmlspecialchars($hoa['HinhAnh']); ?>" alt="<?php echo htmlspecialchars($hoa['TenHoa']); ?>">
    </div>
    <div class="info-col">
        <h1><?php echo htmlspecialchars($hoa['TenHoa']); ?></h1>
        <p>Loại: <?php echo htmlspecialchars($hoa['TenLoai']); ?></p>
        <p>Chủ đề: <?php echo htmlspecialchars($hoa['TenChuDe']); ?></p>
        <p>Màu sắc: <?php echo htmlspecialchars($hoa['MauSac']); ?></p>
        <p class="price">Giá: <?php echo number_format($hoa['Gia'],0,",","."); ?> đ</p>
        <p>Trạng thái: <?php echo htmlspecialchars($hoa['TrangThai']); ?></p>
        <p><?php echo nl2br(htmlspecialchars($hoa['MoTa'])); ?></p>

        <div style="display:flex; gap:15px; margin-top:20px;">
            <!-- Nút quay lại cố định về pages/HoaTuoi.php -->
           <a href="index.php?page=HoaTuoi" class="back-link">← Quay lại trang Hoa Tươi</a>
            <?php if($hoa['TrangThai'] == 'Còn hàng'): ?>
                <!-- Thêm vào giỏ hàng gọi file giohang_them.php -->
                <a class="btn-addcart" href="giohang_them.php?loai=hoa&ma=<?php echo $hoa['MaHoa']; ?>">Thêm vào giỏ hàng</a>
            <?php else: ?>
                <p style="color:red; line-height:38px; margin:0;">Sản phẩm hiện hết hàng</p>
            <?php endif; ?>
        </div>
    </div>
</div>

