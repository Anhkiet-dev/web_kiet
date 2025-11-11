<style>
.container-mausac {
    display: flex;
    background-color: #111;
    color: #fff;
    padding: 40px 60px;
    gap: 30px;
}
.sidebar-mausac {
    width: 250px;
}
.sidebar-mausac h3 {
    background-color: #ff9900;
    color: #fff;
    text-align: center;
    padding: 12px;
    border-radius: 5px;
    font-size: 18px;
}
.sidebar-mausac ul {
    list-style: none;
    padding: 0;
    margin-top: 15px;
}
.sidebar-mausac ul li {
    border-bottom: 1px solid #333;
}
.sidebar-mausac ul li a {
    color: #ddd;
    display: block;
    padding: 10px 12px;
    text-decoration: none;
    transition: 0.3s;
}
.sidebar-mausac ul li a:hover,
.sidebar-mausac ul li.active a {
    background-color: #222;
    color: #ff9900;
}
.main-mausac {
    flex: 1;
}
.main-mausac h2 {
    color: #ffcc00;
    border-bottom: 2px solid #ff9900;
    padding-bottom: 8px;
    margin-bottom: 5px;
}
.main-mausac p.desc {
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
}
.product-item:hover {
    transform: translateY(-5px);
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
.tag.SALE { background: #e63946; }
.tag.NEW { background: #06d6a0; }
.tag.FREESHIP { background: #118ab2; }
.tag.HOT { background: #ffd166; color: #000; }
</style>

<div class="container-mausac">
    <!-- SIDEBAR -->
    <div class="sidebar-mausac">
        <h3>MÀU SẮC</h3>
        <ul>
            <?php
            // Lấy danh sách màu sắc có trong bảng Hoa
            $sql_color = "SELECT DISTINCT MauSac FROM Hoa ORDER BY MauSac ASC";
            $res_color = mysqli_query($conn, $sql_color);
            $mau = isset($_GET['mau']) ? $_GET['mau'] : '';

            if ($res_color && mysqli_num_rows($res_color) > 0) {
                while ($c = mysqli_fetch_assoc($res_color)) {
                    $active = ($mau == $c['MauSac']) ? ' class="active"' : '';
                    echo '<li'.$active.'><a href="index.php?page=mausac&mau='.urlencode($c['MauSac']).'">'.$c['MauSac'].'</a></li>';
                }
            } else {
                echo '<li><em>Chưa có màu sắc nào</em></li>';
            }
            ?>
        </ul>
    </div>

    <!-- MAIN -->
    <div class="main-mausac">
        <?php
        if($mau){
            echo "<h2>Hoa màu: ".htmlspecialchars($mau)."</h2>";
            echo "<p class='desc'>Các sản phẩm hoa có màu sắc $mau.</p>";

            $sql_hoa = "SELECT * FROM Hoa WHERE MauSac = '".mysqli_real_escape_string($conn,$mau)."' AND TrangThai = 'Còn hàng'";
            $res_hoa = mysqli_query($conn, $sql_hoa);

            if ($res_hoa && mysqli_num_rows($res_hoa) > 0) {
                echo '<div class="product-grid">';
                while ($p = mysqli_fetch_assoc($res_hoa)) {
                    $img = !empty($p['HinhAnh']) ? $p['HinhAnh'] : 'no-image.png';
                    $tag = ($p['Tag'] != 'NONE') ? '<span class="tag '.$p['Tag'].'">'.$p['Tag'].'</span>' : '';

                    echo '<div class="product-item">';
                    echo $tag;
                    // Link tới chi tiết hoa theo cấu trúc index.php?page=chitiethoa&MaHoa=...
                    echo '<a href="index.php?page=chitiethoa&MaHoa='.$p['MaHoa'].'">
                            <img src="images/'.$img.'" alt="'.$p['TenHoa'].'">
                        </a>';
                    echo '<h4>'.$p['TenHoa'].'</h4>';

                    if (!empty($p['GiaCu']) && $p['GiaCu'] > $p['Gia']) {
                        echo '<p class="price"><del style="color:#777; font-size:14px;">'.number_format($p['GiaCu'],0,',','.').'đ</del> ';
                        echo '<span style="color:#ffcc00;">'.number_format($p['Gia'],0,',','.').'đ</span></p>';
                    } else {
                        echo '<p class="price">'.number_format($p['Gia'], 0, ',', '.').' đ</p>';
                    }

                    echo '</div>';
                }
                echo '</div>';
            } else {
                echo "<p>Chưa có sản phẩm nào thuộc màu sắc này.</p>";
            }
        } else {
            echo "<h2>Chọn màu sắc để xem hoa</h2>";
            echo "<p class='desc'>Vui lòng chọn một màu sắc ở sidebar để lọc sản phẩm.</p>";
        }
        ?>
    </div>
</div>
