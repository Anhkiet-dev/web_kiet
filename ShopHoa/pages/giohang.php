<?php
// ------------------------
// XỬ LÝ XÓA SẢN PHẨM TRƯỚC KHI GỬI BẤT KỲ OUTPUT NÀO
// ------------------------
if(isset($_GET['xoa_loai']) && isset($_GET['xoa_ma'])){
    $loai = $_GET['xoa_loai'];
    $ma = (int)$_GET['xoa_ma'];
    if(isset($_SESSION['giohang'][$loai][$ma])){
        unset($_SESSION['giohang'][$loai][$ma]);
        if(empty($_SESSION['giohang'][$loai])){
            unset($_SESSION['giohang'][$loai]);
        }
    }
    header("Location: giohang.php");
    exit;
}

// ------------------------
// HÀM LẤY THÔNG TIN SẢN PHẨM
// ------------------------
function getProductInfo($conn, $loai, $ma){
    if($loai === 'hoa'){
        $sql = "SELECT TenHoa AS Ten, Gia, HinhAnh FROM hoa WHERE MaHoa = $ma";
    } elseif($loai === 'phukien'){
        $sql = "SELECT TenPhuKien AS Ten, Gia, HinhAnh FROM phukien WHERE MaPhuKien = $ma";
    } else {
        return null;
    }
    $res = mysqli_query($conn, $sql);
    if($res && mysqli_num_rows($res) > 0){
        return mysqli_fetch_assoc($res);
    }
    return null;
}

// ------------------------
// LẤY GIỎ HÀNG
// ------------------------
$giohang = $_SESSION['giohang'] ?? [];

// Trang trước để nút “Tiếp tục mua sắm”
$previousPage = $_SESSION['trangtruoc'] ?? 'index.php';


?>

<style>
.container-giohang {
    padding: 40px 60px;
    background-color: #111;
    color: #fff;
    min-height: 70vh;
}
.container-giohang h2 {
    color: #ffcc00;
    margin-bottom: 20px;
}
.giohang-table {
    width: 100%;
    border-collapse: collapse;
}
.giohang-table th, .giohang-table td {
    padding: 12px;
    border-bottom: 1px solid #333;
    text-align: center;
    color: #fff;
}
.giohang-table th {
    background-color: #222;
}
.giohang-table img {
    width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: 5px;
}
.btn-action {
    padding: 6px 12px;
    background-color: #ff9900;
    color: #fff;
    text-decoration: none;
    border-radius: 5px;
    transition: 0.3s;
    margin-right: 10px;
}
.btn-action:hover {
    background-color: #ffcc00;
    color: #000;
}
.total {
    text-align: right;
    margin-top: 20px;
    font-size: 20px;
    font-weight: bold;
    color: #ff9900;
}
</style>

<div class="container-giohang">
    <h2>Giỏ hàng của bạn</h2>

    <?php if(empty($giohang)): ?>
        <p>❌ Giỏ hàng trống. Vui lòng thêm sản phẩm.</p>
    <?php else: ?>
        <table class="giohang-table">
            <thead>
                <tr>
                    <th>Hình ảnh</th>
                    <th>Sản phẩm</th>
                    <th>Loại</th>
                    <th>Giá</th>
                    <th>Số lượng</th>
                    <th>Thành tiền</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $tong = 0;
                foreach($giohang as $loai => $items):
                    foreach($items as $ma => $sl):
                        $sp = getProductInfo($conn, $loai, $ma);
                        if(!$sp) continue;
                        $thanhtien = $sp['Gia'] * $sl;
                        $tong += $thanhtien;
                ?>
                <tr>
                    <td><img src="images/<?php echo htmlspecialchars($sp['HinhAnh'] ?? 'no-image.png'); ?>" alt=""></td>
                    <td><?php echo htmlspecialchars($sp['Ten']); ?></td>
                    <td><?php echo htmlspecialchars($loai === 'hoa' ? 'Hoa' : 'Phụ kiện'); ?></td>
                    <td><?php echo number_format($sp['Gia'],0,',','.'); ?> đ</td>
                    <td><?php echo $sl; ?></td>
                    <td><?php echo number_format($thanhtien,0,',','.'); ?> đ</td>
                    <td>
                        <a class="btn-action" href="index.php?page=giohang&xoa_loai=<?php echo $loai; ?>&xoa_ma=<?php echo $ma; ?>">Xóa</a>
                    </td>
                </tr>
                <?php 
                    endforeach;
                endforeach;
                ?>
            </tbody>
        </table>

        <div class="total">Tổng tiền: <?php echo number_format($tong,0,',','.'); ?> đ</div>
        <br>
        <a class="btn-action" href="index.php?page=HoaTuoi">← Tiếp tục mua sắm</a>
        <a class="btn-action" href="index.php?page=thanhtoan">Thanh toán →</a>
    <?php endif; ?>
</div>

