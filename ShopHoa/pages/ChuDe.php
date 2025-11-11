<style>
.container-chude {
    display: flex;
    background-color: #111;
    color: #fff;
    padding: 40px 60px;
    gap: 30px;
}
.sidebar-chude {
    width: 250px;
}
.sidebar-chude h3 {
    background-color: #ff9900;
    color: #fff;
    text-align: center;
    padding: 12px;
    border-radius: 5px;
    font-size: 18px;
}
.sidebar-chude ul {
    list-style: none;
    padding: 0;
    margin-top: 15px;
}
.sidebar-chude ul li {
    border-bottom: 1px solid #333;
}
.sidebar-chude ul li a {
    color: #ddd;
    display: block;
    padding: 10px 12px;
    text-decoration: none;
    transition: 0.3s;
}
.sidebar-chude ul li a:hover,
.sidebar-chude ul li.active a {
    background-color: #222;
    color: #ff9900;
}
.main-chude {
    flex: 1;
}
.main-chude h2 {
    color: #ffcc00;
    border-bottom: 2px solid #ff9900;
    padding-bottom: 8px;
    margin-bottom: 5px;
}
.main-chude p.desc {
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

<div class="container-chude">
    <!-- SIDEBAR -->
    <div class="sidebar-chude">
        <h3>CHỦ ĐỀ</h3>
        <ul>
            <?php
            $sql_cd = "SELECT MaChuDe, TenChuDe FROM ChuDe ORDER BY MaChuDe ASC";
            $res_cd = mysqli_query($conn, $sql_cd);
            $machude = isset($_GET['chude']) ? (int)$_GET['chude'] : 1;

            if ($res_cd && mysqli_num_rows($res_cd) > 0) {
                while ($cd = mysqli_fetch_assoc($res_cd)) {
                    $active = ($machude == $cd['MaChuDe']) ? ' class="active"' : '';
                    echo '<li'.$active.'><a href="?chude='.$cd['MaChuDe'].'">'.$cd['TenChuDe'].'</a></li>';
                }
            } else {
                echo '<li><em>Chưa có chủ đề nào</em></li>';
            }
            ?>
        </ul>
    </div>

    <!-- MAIN -->
    <div class="main-chude">
        <?php
        // Lấy thông tin chủ đề
        $sql_ten = "SELECT TenChuDe, MoTa FROM ChuDe WHERE MaChuDe = $machude";
        $res_ten = mysqli_query($conn, $sql_ten);
        $row_ten = mysqli_fetch_assoc($res_ten);

        $tenchude = $row_ten ? $row_ten['TenChuDe'] : "Chủ đề không tồn tại";
        $motachude = $row_ten ? $row_ten['MoTa'] : "";

        echo "<h2>$tenchude</h2>";
        echo "<p class='desc'>$motachude</p>";

        // Lấy danh sách hoa theo chủ đề
        $sql_hoa = "SELECT * FROM Hoa WHERE MaChuDe = $machude AND TrangThai = 'Còn hàng'";
        $res_hoa = mysqli_query($conn, $sql_hoa);

        if ($res_hoa && mysqli_num_rows($res_hoa) > 0) {
            echo '<div class="product-grid">';
            while ($p = mysqli_fetch_assoc($res_hoa)) {
                $img = !empty($p['HinhAnh']) ? $p['HinhAnh'] : 'no-image.png';
                $tag = ($p['Tag'] != 'NONE') ? '<span class="tag '.$p['Tag'].'">'.$p['Tag'].'</span>' : '';

                echo '<div class="product-item">';
                echo $tag;
               // Lấy link chi tiết hoa theo index.php?page=chitiethoa
                echo '<a href="index.php?page=chitiethoa&MaHoa='.$p['MaHoa'].'">
                        <img src="images/'.$img.'" alt="'.htmlspecialchars($p['TenHoa']).'">
                    </a>';

                echo '<h4>'.htmlspecialchars($p['TenHoa']).'</h4>';

                // Hiển thị giá
                if (!empty($p['GiaCu']) && $p['GiaCu'] > $p['Gia']) {
                    echo '<p class="price">
                            <del style="color:#777; font-size:14px;">'.number_format($p['GiaCu'],0,',','.').' đ</del> 
                            <span style="color:#ffcc00;">'.number_format($p['Gia'],0,',','.').' đ</span>
                        </p>';
                } else {
                    echo '<p class="price">'.number_format($p['Gia'], 0, ',', '.').' đ</p>';
                }


                echo '</div>';
            }
            echo '</div>';
        } else {
            echo "<p>Chưa có sản phẩm nào thuộc chủ đề này.</p>";
        }
        ?>
    </div>
</div>
