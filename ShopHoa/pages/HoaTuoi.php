<style>
.container-hoatuoi {
    display: flex;
    background-color: #111;
    color: #fff;
    padding: 40px 60px;
}

/* SIDEBAR */
.sidebar-hoatuoi {
    width: 250px;
    margin-right: 30px;
}
.sidebar-hoatuoi h3 {
    background-color: #ff9900;
    color: #fff;
    text-align: center;
    padding: 12px;
    border-radius: 5px;
    font-size: 18px;
}
.sidebar-hoatuoi ul {
    list-style: none;
    padding: 0;
    margin-top: 15px;
}
.sidebar-hoatuoi ul li {
    border-bottom: 1px solid #333;
}
.sidebar-hoatuoi ul li a {
    color: #ddd;
    display: block;
    padding: 10px 12px;
    text-decoration: none;
    transition: 0.3s;
}
.sidebar-hoatuoi ul li a:hover {
    background-color: #222;
    color: #ff9900;
}

/* MAIN CONTENT */
.main-hoatuoi {
    flex: 1;
}
.main-hoatuoi h2 {
    color: #ffcc00;
    border-bottom: 2px solid #ff9900;
    padding-bottom: 8px;
    margin-bottom: 20px;
}

/* GRID */
.product-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(230px, 1fr));
    gap: 25px;
}
.product-item {
    background: #1a1a1a;
    border-radius: 10px;
    text-align: center;
    padding: 15px;
    transition: all 0.3s;
    position: relative;
}
.product-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 0 10px #ff9900;
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
}

/* TAG */
.tag {
    position: absolute;
    top: 10px;
    left: 10px;
    background-color: #ff3300;
    color: #fff;
    padding: 5px 10px;
    font-size: 12px;
    border-radius: 4px;
    font-weight: bold;
}
</style>

<div class="container-hoatuoi">

    <!-- SIDEBAR -->
    <div class="sidebar-hoatuoi">
        <h3>LOẠI HOA</h3>
        <ul>
            <?php
            $sql_loai = "SELECT * FROM LoaiHoa ORDER BY TenLoai ASC";
            $res_loai = mysqli_query($conn, $sql_loai);
            while ($loai = mysqli_fetch_assoc($res_loai)) {
                echo '<li><a href="?loai='.$loai['MaLoai'].'">'.$loai['TenLoai'].'</a></li>';
            }
            ?>
        </ul>
    </div>

    <!-- MAIN -->
    <div class="main-hoatuoi">
        <?php
        // Lấy mã loại hoa từ URL
        $maloai = isset($_GET['loai']) ? intval($_GET['loai']) : 0;

        // Tiêu đề trang
        if ($maloai) {
            $res = mysqli_query($conn, "SELECT TenLoai FROM LoaiHoa WHERE MaLoai = $maloai");
            $row = mysqli_fetch_assoc($res);
            $tieude = "Loại hoa: " . $row['TenLoai'];
        } else {
            $tieude = "Tất cả sản phẩm hoa tươi";
        }

        echo "<h2>$tieude</h2>";

        // Lọc sản phẩm theo loại và trạng thái
        $where = "WHERE h.TrangThai='Còn hàng'";
        if ($maloai) $where .= " AND h.MaLoai = $maloai";

        $sql = "
            SELECT h.*, l.TenLoai
            FROM Hoa h
            LEFT JOIN LoaiHoa l ON h.MaLoai = l.MaLoai
            $where
            ORDER BY h.NgayTao DESC
        ";

        $res = mysqli_query($conn, $sql);

        if (mysqli_num_rows($res) > 0) {
            echo '<div class="product-grid">';
            while ($p = mysqli_fetch_assoc($res)) {
                // Ảnh sản phẩm, nếu không có thì dùng no-image.png
                $img = !empty($p['HinhAnh']) ? $p['HinhAnh'] : 'no-image.png';
                $imgPath = "images/" . $img;

                // Tag sản phẩm (SALE, NEW, HOT, FREESHIP)
                $tagHtml = ($p['Tag'] != 'NONE') ? '<span class="tag '.$p['Tag'].'">'.$p['Tag'].'</span>' : '';

                // Link chi tiết hoa qua index.php?page=chitiethoa
                $linkChiTiet = "index.php?page=chitiethoa&MaHoa=".$p['MaHoa'];

                echo "
                <div class='product-item'>
                    $tagHtml
                    <a href='$linkChiTiet'>
                        <img src='$imgPath' alt='".htmlspecialchars($p['TenHoa'])."'>
                    </a>
                    <h4>".htmlspecialchars($p['TenHoa'])."</h4>";

                // Hiển thị giá (nếu có giá cũ, hiển thị strike)
                if (!empty($p['GiaCu']) && $p['GiaCu'] > $p['Gia']) {
                    echo "<p class='price'>
                            <del style='color:#777; font-size:14px;'>".number_format($p['GiaCu'],0,',','.')." đ</del> 
                            <span style='color:#ffcc00;'>".number_format($p['Gia'],0,',','.')." đ</span>
                        </p>";
                } else {
                    echo "<div class='price'>".number_format($p['Gia'], 0, ',', '.')." đ</div>";
                }

                echo "<p style='color:#bbb; font-size:13px;'>".htmlspecialchars($p['TenLoai'])."</p>";
                echo "</div>";
            }
            echo '</div>';
        } else {
            echo "<p>Chưa có sản phẩm nào thuộc loại hoa này.</p>";
        }
        ?>
    </div>
</div>

