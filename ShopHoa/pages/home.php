<?php
include 'config/db.php';

// Lấy 8 hoa mới nhất
$sql = "SELECT * FROM Hoa ORDER BY NgayTao DESC LIMIT 8";
$result = $conn->query($sql);
?>

<!-- Banner -->
<div class="banner">
    <img src="https://hoayeuthuong.com/cms-images/banner/434477_2010-ngay-phu-nu-viet-nam.jpg" alt="Banner hoa">
</div>

<div class="container">
    <h2>🌸 SẢN PHẨM MỚI NHẤT 🌸</h2>
    <div class="product-grid">
        <?php while($row = $result->fetch_assoc()): ?>
            <div class="product-card">
                <img src="images/<?php echo $row['HinhAnh']; ?>" alt="<?php echo $row['TenHoa']; ?>">
                <h3><?php echo $row['TenHoa']; ?></h3>
                <?php if($row['GiaCu']): ?>
                    <p class="old-price"><?php echo number_format($row['GiaCu']); ?>₫</p>
                <?php endif; ?>
                <p class="price"><?php echo number_format($row['Gia']); ?>₫</p>
                <a href="pages/chitiet.php?id=<?php echo $row['MaHoa']; ?>" class="btn">Xem chi tiết</a>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<style>
.container { padding: 40px; text-align: center; }
.product-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 25px; }
.product-card { background: #fff; border-radius: 10px; padding: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
.product-card img { width: 100%; border-radius: 10px; height: 220px; object-fit: cover; }
.product-card h3 { margin: 10px 0; font-size: 16px; }
.price { color: #e91e63; font-weight: bold; }
.old-price { text-decoration: line-through; color: gray; font-size: 14px; }
.btn { display: inline-block; background: #e91e63; color: #fff; padding: 6px 14px; border-radius: 8px; text-decoration: none; }
.btn:hover { background: #c2185b; }
.banner img {
    width: 100%;
    height: 350px;
    object-fit: cover;
    display: block;
}


</style>
