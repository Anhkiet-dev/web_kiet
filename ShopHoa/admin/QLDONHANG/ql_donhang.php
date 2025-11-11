<?php
include_once('../../config/db.php');


// Lấy danh sách đơn hàng
$sql = "SELECT d.*, k.HoTen, k.Email, k.SDT
        FROM donhang d
        JOIN khachhang k ON d.MaKH = k.MaKH
        ORDER BY d.NgayDat DESC";
$res = mysqli_query($conn, $sql);

include_once('../header_admin.php');
?>

<h2>Quản lý đơn hàng</h2>

<table border="1" cellpadding="5" cellspacing="0">
    <tr>
        <th>Đơn hàng</th>
        <th>Khách hàng</th>
        <th>Email</th>
        <th>SDT</th>
        <th>Tổng tiền</th>
        <th>Ngày đặt</th>
        <th>Trạng thái</th>
        <th>Hình thức TT</th>
        <th>Hành động</th>
    </tr>
    <?php while($don = mysqli_fetch_assoc($res)): ?>
    <tr>
        <td>#<?php echo $don['MaDon']; ?></td>
        <td><?php echo $don['HoTen']; ?></td>
        <td><?php echo $don['Email']; ?></td>
        <td><?php echo $don['SDT']; ?></td>
        <td><?php echo number_format($don['TongTien'],0,",","."); ?> đ</td>
        <td><?php echo $don['NgayDat']; ?></td>
        <td><?php echo $don['TrangThai']; ?></td>
        <td><?php echo $don['HinhThucThanhToan']; ?></td>
        <td>
            <a href="chitiet_don.php?MaDon=<?php echo $don['MaDon']; ?>">Xem chi tiết</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

