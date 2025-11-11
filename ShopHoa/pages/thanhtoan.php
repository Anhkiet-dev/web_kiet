<?php

// ------------------------
// KIỂM TRA NGƯỜI DÙNG ĐÃ ĐĂNG NHẬP
// ------------------------
if(!isset($_SESSION['MaKH'])){
    header("Location: ../pages/dangnhap.php");
    exit;
}

$MaKH = $_SESSION['MaKH'];

// ------------------------
// Lấy thông tin khách hàng
// ------------------------
$resKH = mysqli_query($conn, "SELECT * FROM khachhang WHERE MaKH = $MaKH");
$kh = mysqli_fetch_assoc($resKH);

// ------------------------
// Lấy giỏ hàng
// ------------------------
$giohang_hoa = $_SESSION['giohang']['hoa'] ?? [];
$giohang_pk  = $_SESSION['giohang']['phukien'] ?? [];

if(empty($giohang_hoa) && empty($giohang_pk)){
    echo "<p>Giỏ hàng trống. Vui lòng thêm sản phẩm trước khi thanh toán.</p>";
    exit;
}

// ------------------------
// Lấy thông tin sản phẩm từ DB
// ------------------------
function getProduct($conn, $ma, $loai){
    if($loai === 'hoa'){
        $res = mysqli_query($conn, "SELECT MaHoa AS MaSP, TenHoa AS Ten, Gia FROM hoa WHERE MaHoa = $ma");
    } else {
        $res = mysqli_query($conn, "SELECT MaPhuKien AS MaSP, TenPhuKien AS Ten, Gia FROM phukien WHERE MaPhuKien = $ma");
    }
    return mysqli_fetch_assoc($res);
}

// ------------------------
// Tính tổng tiền
// ------------------------
$tongTien = 0;
$spList = []; // Lưu danh sách sản phẩm để hiển thị
foreach($giohang_hoa as $ma => $sl){
    $sp = getProduct($conn, $ma, 'hoa');
    if($sp){
        $sp['SoLuong'] = $sl;
        $sp['Loai'] = 'hoa';
        $spList[] = $sp;
        $tongTien += $sp['Gia'] * $sl;
    }
}
foreach($giohang_pk as $ma => $sl){
    $sp = getProduct($conn, $ma, 'phukien');
    if($sp){
        $sp['SoLuong'] = $sl;
        $sp['Loai'] = 'phukien';
        $spList[] = $sp;
        $tongTien += $sp['Gia'] * $sl;
    }
}

// ------------------------
// Xử lý khi nhấn nút đặt hàng
// ------------------------
if(isset($_POST['dat_hang'])){
    $hinhThucTT = $_POST['hinhthuc_tt'] ?? 'COD';
    $ghiChu     = $_POST['ghichu'] ?? '';
    $HoTen      = $_POST['hoten'] ?? $kh['HoTen'];
    $Email      = $_POST['email'] ?? $kh['Email'];
    $SDT        = $_POST['sdt'] ?? $kh['SDT'];
    $DiaChi     = $_POST['diachi'] ?? $kh['DiaChi'];

    // Cập nhật thông tin khách hàng
    $stmtKH = $conn->prepare("UPDATE khachhang SET HoTen=?, Email=?, SDT=?, DiaChi=? WHERE MaKH=?");
    $stmtKH->bind_param("ssssi", $HoTen, $Email, $SDT, $DiaChi, $MaKH);
    $stmtKH->execute();
    $stmtKH->close();

    // 1. Thêm đơn hàng
    $stmtDH = $conn->prepare("INSERT INTO donhang (MaKH, TongTien, HinhThucThanhToan, GhiChu) VALUES (?, ?, ?, ?)");
    $stmtDH->bind_param("idss", $MaKH, $tongTien, $hinhThucTT, $ghiChu);
    $stmtDH->execute();
    $MaDon = $stmtDH->insert_id;
    $stmtDH->close();

    // 2. Tạo giỏ hàng cho đơn hàng
    $stmtGio = $conn->prepare("INSERT INTO giohang (MaKH) VALUES (?)");
    $stmtGio->bind_param("i", $MaKH);
    $stmtGio->execute();
    $MaGio = $stmtGio->insert_id;
    $stmtGio->close();

    // 3. Thêm chi tiết giỏ hàng
    foreach($spList as $sp){
        $stmtCT = $conn->prepare("INSERT INTO giohangchitiet (MaGio, MaSP, LoaiSanPham, SoLuong) VALUES (?, ?, ?, ?)");
        $stmtCT->bind_param("issi", $MaGio, $sp['MaSP'], $sp['Loai'], $sp['SoLuong']);
        $stmtCT->execute();
        $stmtCT->close();
    }

    // 4. Xóa session giỏ hàng
    unset($_SESSION['giohang']);

    echo "<p>✅ Đặt hàng thành công! Tổng tiền: ".number_format($tongTien,0,",",".")." đ</p>";
    echo '<p><a href="../pages/hoatuoi.php">← Quay lại trang Hoa Tươi</a></p>';
    exit;
}
?>

<style>
.container-thanhtoan { padding:40px 60px; background:#111; color:#fff; min-height:70vh; }
.container-thanhtoan h2 { color:#ffcc00; margin-bottom:20px; }
.container-thanhtoan table { width:100%; border-collapse:collapse; margin-bottom:20px; }
.container-thanhtoan th, .container-thanhtoan td { padding:12px; border-bottom:1px solid #333; text-align:center; color:#fff; }
.container-thanhtoan th { background:#222; }
.container-thanhtoan form input, .container-thanhtoan form select, .container-thanhtoan form textarea, .container-thanhtoan form button { display:block; width:100%; margin-bottom:15px; padding:10px; border-radius:5px; border:1px solid #ccc; }
.container-thanhtoan form button { background:#ff9900; color:#fff; border:none; cursor:pointer; }
.container-thanhtoan form button:hover { background:#ffcc00; color:#000; }
</style>

<div class="container-thanhtoan">
    <h2>Thanh toán</h2>

    <h3>Thông tin sản phẩm</h3>
    <table>
        <tr>
            <th>Sản phẩm</th>
            <th>Loại</th>
            <th>Giá</th>
            <th>Số lượng</th>
            <th>Thành tiền</th>
        </tr>
        <?php foreach($spList as $sp): ?>
        <tr>
            <td><?php echo htmlspecialchars($sp['Ten']); ?></td>
            <td><?php echo $sp['Loai'] === 'hoa' ? 'Hoa' : 'Phụ kiện'; ?></td>
            <td><?php echo number_format($sp['Gia'],0,",","."); ?> đ</td>
            <td><?php echo $sp['SoLuong']; ?></td>
            <td><?php echo number_format($sp['Gia']*$sp['SoLuong'],0,",","."); ?> đ</td>
        </tr>
        <?php endforeach; ?>
    </table>

    <p><strong>Tổng tiền: <?php echo number_format($tongTien,0,",","."); ?> đ</strong></p>

    <h3>Thông tin khách hàng</h3>
    <form method="post">
        <label>Họ tên</label>
        <input type="text" name="hoten" value="<?php echo htmlspecialchars($kh['HoTen']); ?>" required>

        <label>Email</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($kh['Email']); ?>" required>

        <label>Số điện thoại</label>
        <input type="text" name="sdt" value="<?php echo htmlspecialchars($kh['SDT']); ?>" required>

        <label>Địa chỉ</label>
        <textarea name="diachi" required><?php echo htmlspecialchars($kh['DiaChi']); ?></textarea>

        <label>Hình thức thanh toán</label>
        <select name="hinhthuc_tt" required>
            <option value="COD">Thanh toán khi nhận hàng (COD)</option>
            <option value="Chuyen khoan">Chuyển khoản</option>
        </select>

        <label>Ghi chú (không bắt buộc)</label>
        <textarea name="ghichu" placeholder="Ghi chú cho đơn hàng..."></textarea>

        <button type="submit" name="dat_hang">Đặt hàng</button>
    </form>

    <a href="../pages/giohang.php" style="color:#ff9900;">← Quay lại giỏ hàng</a>
</div>


