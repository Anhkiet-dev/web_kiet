<?php
session_start();
include_once('../../config/db.php');


// Lấy MaDon từ GET
if(!isset($_GET['MaDon']) || !is_numeric($_GET['MaDon'])){
    echo "Đơn hàng không hợp lệ.";
    exit;
}
$MaDon = $_GET['MaDon'];

// Lấy thông tin đơn hàng và khách hàng
$sql = "SELECT d.*, k.HoTen, k.Email, k.SDT, k.DiaChi
        FROM donhang d
        JOIN khachhang k ON d.MaKH = k.MaKH
        WHERE d.MaDon = $MaDon";
$res = mysqli_query($conn, $sql);
if(mysqli_num_rows($res) == 0){
    echo "Đơn hàng không tồn tại.";
    exit;
}
$don = mysqli_fetch_assoc($res);

// Lấy chi tiết sản phẩm
$sql_sp = "SELECT gct.SoLuong, gct.LoaiSanPham, 
                  IF(gct.LoaiSanPham='hoa', h.TenHoa, p.TenPhuKien) as TenSP,
                  IF(gct.LoaiSanPham='hoa', h.Gia, p.Gia) as GiaSP
           FROM giohangchitiet gct
           LEFT JOIN hoa h ON gct.MaSP=h.MaHoa AND gct.LoaiSanPham='hoa'
           LEFT JOIN phukien p ON gct.MaSP=p.MaPhuKien AND gct.LoaiSanPham='phukien'
           WHERE gct.MaGio = ".$MaDon;
$res_sp = mysqli_query($conn, $sql_sp);
?>

<?php include_once('../header_admin.php'); ?>

<h2>Chi tiết đơn hàng #<?php echo $don['MaDon']; ?></h2>
<p><strong>Khách hàng:</strong> <?php echo $don['HoTen']; ?></p>
<p><strong>Email:</strong> <?php echo $don['Email']; ?></p>
<p><strong>SDT:</strong> <?php echo $don['SDT']; ?></p>
<p><strong>Địa chỉ:</strong> <?php echo $don['DiaChi']; ?></p>
<p><strong>Tổng tiền:</strong> <?php echo number_format($don['TongTien'],0,",","."); ?> đ</p>
<p><strong>Ngày đặt:</strong> <?php echo $don['NgayDat']; ?></p>
<p><strong>Trạng thái:</strong> <?php echo $don['TrangThai']; ?></p>
<p><strong>Hình thức TT:</strong> <?php echo $don['HinhThucThanhToan']; ?></p>

<h3>Chi tiết sản phẩm</h3>
<table border="1" cellpadding="5" cellspacing="0">
    <tr>
        <th>Sản phẩm</th>
        <th>Loại</th>
        <th>Giá</th>
        <th>Số lượng</th>
        <th>Thành tiền</th>
    </tr>
    <?php while($sp = mysqli_fetch_assoc($res_sp)):
        $thanhTien = $sp['GiaSP'] * $sp['SoLuong'];
    ?>
    <tr>
        <td><?php echo $sp['TenSP']; ?></td>
        <td><?php echo ucfirst($sp['LoaiSanPham']); ?></td>
        <td><?php echo number_format($sp['GiaSP'],0,",","."); ?> đ</td>
        <td><?php echo $sp['SoLuong']; ?></td>
        <td><?php echo number_format($thanhTien,0,",","."); ?> đ</td>
    </tr>
    <?php endwhile; ?>
</table>

<p><a href="ql_donhang.php">← Quay lại danh sách đơn hàng</a></p>

