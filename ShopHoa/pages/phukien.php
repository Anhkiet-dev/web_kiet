<style>
.container-phukien {
    display: flex;
    background-color: #111;
    color: #fff;
    padding: 40px 60px;
    gap: 30px;
    min-height: 80vh;
}
.sidebar-phukien {
    width: 250px;
}
.sidebar-phukien h3 {
    background-color: #ff9900;
    color: #fff;
    text-align: center;
    padding: 12px;
    border-radius: 5px;
    font-size: 18px;
}
.sidebar-phukien ul {
    list-style: none;
    padding: 0;
    margin-top: 15px;
}
.sidebar-phukien ul li {
    border-bottom: 1px solid #333;
}
.sidebar-phukien ul li a {
    color: #ddd;
    display: block;
    padding: 10px 12px;
    text-decoration: none;
    transition: 0.3s;
}
.sidebar-phukien ul li a:hover,
.sidebar-phukien ul li.active a {
    background-color: #222;
    color: #ff9900;
}
.main-phukien {
    flex: 1;
}
.main-phukien h2 {
    color: #ffcc00;
    border-bottom: 2px solid #ff9900;
    padding-bottom: 8px;
    margin-bottom: 5px;
}
.main-phukien p.desc {
    color: #ccc;
    margin-bottom: 25px;
    font-style: italic;
}
.product-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
    gap: 25px;
}
.product-item {
    background: #1a1a1a;
    border-radius: 10px;
    text-align: center;
    padding: 15px;
    transition: all 0.3s;
    position: relative;
    border: 1px solid #222;
}
.product-item:hover {
    transform: translateY(-5px);
    border-color: #ff9900;
}
.product-item img {
    width: 100%;
    height: 230px;
    border-radius: 10px;
    object-fit: cover;
}
.product-item h4 {
    margin-top: 10px;
    font-size: 16px;
    color: #fff;
}
.price {
    color: #ffcc00;
    font-weight: bold;
    font-size: 18px;
    margin-top: 5px;
}
.tag {
    position: absolute;
    top: 10px;
    left: 10px;
    background: #ff6600;
    color: #fff;
    font-size: 12px;
    padding: 4px 8px;
    border-radius: 4px;
}
.btn-detail {
    display: inline-block;
    margin-top: 8px;
    padding: 6px 10px;
    background: #ff9900;
    color: #fff;
    text-decoration: none;
    border-radius: 4px;
    font-size: 14px;
    transition: 0.3s;
}
.btn-detail:hover { background: #ffcc00; color: #000; }
</style>

<div class="container-phukien">
    <!-- SIDEBAR -->
    <div class="sidebar-phukien">
        <h3>LOẠI PHỤ KIỆN</h3>
        <ul>
            <?php
            $sql_loai = "SELECT MaLoaiPK, TenLoaiPK FROM loaiphukien ORDER BY TenLoaiPK ASC";
            $res_loai = mysqli_query($conn, $sql_loai);
            $maloai = isset($_GET['maloai']) ? (int)$_GET['maloai'] : 0;

            if ($res_loai && mysqli_num_rows($res_loai) > 0) {
                while ($row = mysqli_fetch_assoc($res_loai)) {
                    $active = ($maloai == $row['MaLoaiPK']) ? ' class="active"' : '';
                    echo '<li'.$active.'><a href="index.php?page=phukien&maloai='.$row['MaLoaiPK'].'">'.htmlspecialchars($row['TenLoaiPK']).'</a></li>';
                }
            } else {
                echo '<li><em>Chưa có loại phụ kiện nào</em></li>';
            }
            ?>
        </ul>
    </div>

    <!-- MAIN -->
    <div class="main-phukien">
        <?php
        if ($maloai) {
            // Lấy tên loại phụ kiện
            $sql_ten = "SELECT TenLoaiPK FROM loaiphukien WHERE MaLoaiPK = $maloai";
            $res_ten = mysqli_query($conn, $sql_ten);
            $tenloai = ($res_ten && mysqli_num_rows($res_ten) > 0)
                ? mysqli_fetch_assoc($res_ten)['TenLoaiPK']
                : 'Không xác định';

            echo "<h2>Phụ kiện: " . htmlspecialchars($tenloai) . "</h2>";
            echo "<p class='desc'>Các sản phẩm thuộc loại $tenloai.</p>";

            // Lấy danh sách phụ kiện
            $sql_pk = "SELECT * FROM phukien WHERE MaLoaiPK = $maloai AND TrangThai = 'Còn hàng' ORDER BY MaPhuKien DESC";
            $res_pk = mysqli_query($conn, $sql_pk);

            if ($res_pk && mysqli_num_rows($res_pk) > 0) {
                echo '<div class="product-grid">';
                while ($p = mysqli_fetch_assoc($res_pk)) {
                    $img = !empty($p['HinhAnh']) ? $p['HinhAnh'] : 'no-image.png';
                    echo '<div class="product-item">';
                    echo '<span class="tag">FREESHIP</span>';
                    echo '<a href="index.php?page=chitietphukien&ma=' . $p['MaPhuKien'] . '">';
                    echo '<img src="images/' . htmlspecialchars($img) . '" alt="' . htmlspecialchars($p['TenPhuKien']) . '">';
                    echo '</a>';
                    echo '<h4>' . htmlspecialchars($p['TenPhuKien']) . '</h4>';
                    echo '<p class="price">' . number_format($p['Gia'], 0, ',', '.') . ' đ</p>';
                    echo '<a class="btn-detail" href="index.php?page=chitietphukien&ma=' . $p['MaPhuKien'] . '">Xem chi tiết</a>';
                    echo '</div>';
                }
                echo '</div>';
            } else {
                echo "<p>❌ Chưa có phụ kiện nào trong loại này.</p>";
            }
        } else {
            echo "<h2>Chọn loại phụ kiện để xem sản phẩm</h2>";
            echo "<p class='desc'>Vui lòng chọn một loại phụ kiện ở sidebar để xem danh sách sản phẩm.</p>";
        }
        ?>
    </div>
</div>
