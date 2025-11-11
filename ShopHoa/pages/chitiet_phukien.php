<?php
session_start();
require_once('../config/db.php');

// Kiểm tra MaPhuKien hợp lệ
if(!isset($_GET['ma']) || !is_numeric($_GET['ma'])){
    echo "<p>Liên kết không hợp lệ.</p>";
    exit;
}

$mapk = (int)$_GET['ma'];

// Lấy thông tin phụ kiện
$sql = "SELECT pk.*, lp.TenLoaiPK 
        FROM phukien pk 
        LEFT JOIN loaiphukien lp ON pk.MaLoaiPK = lp.MaLoaiPK 
        WHERE pk.MaPhuKien = $mapk";
$res = mysqli_query($conn, $sql);

if(!$res || mysqli_num_rows($res) == 0){
    echo "<p>❌ Không tìm thấy phụ kiện này.</p>";
    exit;
}

$pk = mysqli_fetch_assoc($res);
?>

<style>
.container-detail {
    display: flex;
    gap: 50px;
    padding: 40px 60px;
    min-height: 70vh;
    background-color: #111;
    color: #fff;
}
.img-detail {
    flex: 1;
    text-align: center;
}
.img-detail img {
    max-width: 100%;
    height: auto;
    border-radius: 10px;
    border: 1px solid #222;
    transition: transform 0.3s;
}
.img-detail img:hover {
    transform: scale(1.05);
}
.info-detail {
    flex: 1;
}
.info-detail h2 {
    color: #ffcc00;
    margin-bottom: 15px;
}
.info-detail p {
    color: #ccc;
    margin-bottom: 12px;
}
.info-detail .price {
    color: #ff9900;
    font-size: 22px;
    font-weight: bold;
    margin-bottom: 20px;
}
.btn-addcart, .btn-back {
    display: inline-block;
    padding: 10px 18px;
    background-color: #ff9900;
    color: #fff;
    text-decoration: none;
    border-radius: 5px;
    transition: 0.3s;
}
.btn-addcart:hover, .btn-back:hover {
    background-color: #ffcc00;
    color: #000;
}
</style>

<div class="container-detail">
    <div class="img-detail">
        <?php
        $img = !empty($pk['HinhAnh']) ? $pk['HinhAnh'] : 'no-image.png';
        echo '<img src="../images/'.htmlspecialchars($img).'" alt="'.htmlspecialchars($pk['TenPhuKien']).'">';
        ?>
    </div>
    <div class="info-detail">
        <h2><?php echo htmlspecialchars($pk['TenPhuKien']); ?></h2>
        <p><strong>Loại:</strong> <?php echo htmlspecialchars($pk['TenLoaiPK'] ?? 'Không xác định'); ?></p>
        <p class="price"><?php echo number_format($pk['Gia'], 0, ',', '.') ?> đ</p>
        <p><strong>Số lượng:</strong> <?php echo $pk['SoLuong']; ?></p>
        <p><strong>Trạng thái:</strong> <?php echo htmlspecialchars($pk['TrangThai']); ?></p>
        <p><?php echo nl2br(htmlspecialchars($pk['MoTa'])); ?></p>

        <div style="display:flex; gap:15px; margin-top:20px;">
            <a class="btn-back" href="../pages/phukien.php">← Quay lại</a>
            <?php if($pk['TrangThai'] == 'Còn hàng'): ?>
                <a class="btn-addcart" href="giohang_them.php?loai=phukien&ma=<?php echo $pk['MaPhuKien']; ?>">Thêm vào giỏ hàng</a>
            <?php else: ?>
                <p style="color:red; line-height:38px; margin:0;">Sản phẩm hiện hết hàng</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include_once('../includes/footer.php'); ?>
