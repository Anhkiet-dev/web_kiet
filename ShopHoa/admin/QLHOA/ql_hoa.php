<?php
session_start();
include_once('../../config/db.php');
include_once('../header_admin.php');

$errors = [];
$success = '';

// --- Thêm hoa ---
if(isset($_POST['add_hoa'])){
    $ten = trim($_POST['tenhoa']);
    $gia = (float)trim($_POST['gia']);
    $giacu = (float)trim($_POST['giacu']);
    $soluong = (int)trim($_POST['soluong']);
    $mausac = trim($_POST['mausac']);
    $mota = trim($_POST['mota']);
    $tag = $_POST['tag'];
    $maloai = $_POST['maloai'] ? (int)$_POST['maloai'] : null;
    $machude = $_POST['machude'] ? (int)$_POST['machude'] : null;
    $hinh = $_POST['hinh'];
    $trangthai = 'Còn hàng';

    if(empty($ten) || empty($gia)){
        $errors[] = "Tên hoa và giá bắt buộc phải điền!";
    } else {
        $stmt = $conn->prepare("INSERT INTO Hoa (TenHoa, Gia, GiaCu, SoLuong, MauSac, MoTa, Tag, MaLoai, MaChuDe, HinhAnh, TrangThai) VALUES (?,?,?,?,?,?,?,?,?,?,?)");
        $stmt->bind_param("sddisssiiss", $ten, $gia, $giacu, $soluong, $mausac, $mota, $tag, $maloai, $machude, $hinh, $trangthai);
        if($stmt->execute()){
            $success = "Thêm hoa thành công!";
        } else {
            $errors[] = "Lỗi hệ thống: ".$stmt->error;
        }
        $stmt->close();
    }
}

// --- Ẩn hoa ---
if(isset($_GET['hide']) && is_numeric($_GET['hide'])){
    $ma = (int)$_GET['hide'];
    $stmt = $conn->prepare("UPDATE Hoa SET TrangThai='Ngừng bán' WHERE MaHoa=?");
    $stmt->bind_param("i",$ma);
    $stmt->execute();
    $stmt->close();
    header("Location: ql_hoa.php");
    exit;
}

// --- Hiển thị lại hoa ---
if(isset($_GET['show']) && is_numeric($_GET['show'])){
    $ma = (int)$_GET['show'];
    $stmt = $conn->prepare("UPDATE Hoa SET TrangThai='Còn hàng' WHERE MaHoa=?");
    $stmt->bind_param("i",$ma);
    $stmt->execute();
    $stmt->close();
    header("Location: ql_hoa.php");
    exit;
}

// --- Lấy danh sách LoaiHoa và ChuDe ---
$res_loai = mysqli_query($conn, "SELECT MaLoai, TenLoai FROM LoaiHoa");
$res_chude = mysqli_query($conn, "SELECT MaChuDe, TenChuDe FROM ChuDe");

// --- Lấy danh sách hoa đang bán ---
$res_hoa_con = mysqli_query($conn, "
    SELECT h.*, l.TenLoai, c.TenChuDe
    FROM Hoa h
    LEFT JOIN LoaiHoa l ON h.MaLoai = l.MaLoai
    LEFT JOIN ChuDe c ON h.MaChuDe = c.MaChuDe
    WHERE h.TrangThai='Còn hàng'
    ORDER BY h.MaHoa DESC
");

// --- Lấy danh sách hoa đã ẩn ---
$res_hoa_ngung = mysqli_query($conn, "
    SELECT h.*, l.TenLoai, c.TenChuDe
    FROM Hoa h
    LEFT JOIN LoaiHoa l ON h.MaLoai = l.MaLoai
    LEFT JOIN ChuDe c ON h.MaChuDe = c.MaChuDe
    WHERE h.TrangThai='Ngừng bán'
    ORDER BY h.MaHoa DESC
");
?>

<div class="admin-container">
    <h2>Quản lý Hoa</h2>
    <?php if($errors){ echo '<ul style="color:red;">'; foreach($errors as $e) echo "<li>$e</li>"; echo '</ul>'; } ?>
    <?php if($success) echo "<p style='color:green;'>$success</p>"; ?>

    <!-- Form thêm hoa -->
    <h3>Thêm hoa mới</h3>
    <form method="POST" style="margin-bottom:30px;">
        <input type="text" name="tenhoa" placeholder="Tên hoa" required>
        <input type="number" step="0.01" name="gia" placeholder="Giá" required>
        <input type="number" step="0.01" name="giacu" placeholder="Giá cũ">
        <input type="number" name="soluong" placeholder="Số lượng" value="0">
        <input type="text" name="mausac" placeholder="Màu sắc">
        <input type="text" name="mota" placeholder="Mô tả">
        <select name="tag">
            <option value="NONE">NONE</option>
            <option value="NEW">NEW</option>
            <option value="SALE">SALE</option>
            <option value="FREESHIP">FREESHIP</option>
            <option value="HOT">HOT</option>
        </select>
        <select name="maloai">
            <option value="">Chọn Loại</option>
            <?php
            $res_loai2 = mysqli_query($conn, "SELECT MaLoai, TenLoai FROM LoaiHoa");
            while($l=mysqli_fetch_assoc($res_loai2)) echo "<option value='{$l['MaLoai']}'>{$l['TenLoai']}</option>";
            ?>
        </select>
        <select name="machude">
            <option value="">Chọn Chủ đề</option>
            <?php
            $res_chude2 = mysqli_query($conn, "SELECT MaChuDe, TenChuDe FROM ChuDe");
            while($c=mysqli_fetch_assoc($res_chude2)) echo "<option value='{$c['MaChuDe']}'>{$c['TenChuDe']}</option>";
            ?>
        </select>
        <select name="hinh">
            <option value="">Chọn ảnh</option>
            <?php
            $imgs = glob('../../images/*.{jpg,jpeg,png,gif}', GLOB_BRACE);
            foreach($imgs as $img){
                $imgfile = basename($img);
                echo "<option value='$imgfile'>$imgfile</option>";
            }
            ?>
        </select>
        <button type="submit" name="add_hoa">Thêm hoa</button>
    </form>

    <!-- Bảng hoa đang bán -->
    <h3>Danh sách hoa đang bán</h3>
    <table border="1" cellpadding="8" cellspacing="0">
        <tr>
            <th>MaHoa</th><th>Hình</th><th>Tên hoa</th><th>Giá</th><th>Giá cũ</th>
            <th>Số lượng</th><th>Màu sắc</th><th>Tag</th><th>Loại</th><th>Chủ đề</th><th>Hành động</th>
        </tr>
        <?php
        if($res_hoa_con && mysqli_num_rows($res_hoa_con)>0){
            while($h=mysqli_fetch_assoc($res_hoa_con)){
                $imgsrc = $h['HinhAnh'] ? "../../images/".$h['HinhAnh'] : "no-image.png";
                echo "<tr>";
                echo "<td>{$h['MaHoa']}</td>";
                echo "<td><img src='$imgsrc' width='80'></td>";
                echo "<td>{$h['TenHoa']}</td>";
                echo "<td>{$h['Gia']}</td>";
                echo "<td>{$h['GiaCu']}</td>";
                echo "<td>{$h['SoLuong']}</td>";
                echo "<td>{$h['MauSac']}</td>";
                echo "<td>{$h['Tag']}</td>";
                echo "<td>{$h['TenLoai']}</td>";
                echo "<td>{$h['TenChuDe']}</td>";
                echo "<td>
                    <a href='edit_hoa.php?ma={$h['MaHoa']}'>Sửa</a> | 
                    <a href='ql_hoa.php?hide={$h['MaHoa']}' onclick='return confirm(\"Ẩn hoa này?\")'>Ẩn</a>
                </td>";
                echo "</tr>";
            }
        } else echo "<tr><td colspan='11'>Chưa có hoa đang bán</td></tr>";
        ?>
    </table>

    <!-- Bảng hoa đã ẩn -->
    <h3>Danh sách hoa đã ẩn</h3>
    <table border="1" cellpadding="8" cellspacing="0">
        <tr>
            <th>MaHoa</th><th>Hình</th><th>Tên hoa</th><th>Giá</th><th>Giá cũ</th>
            <th>Số lượng</th><th>Màu sắc</th><th>Tag</th><th>Loại</th><th>Chủ đề</th><th>Hành động</th>
        </tr>
        <?php
        if($res_hoa_ngung && mysqli_num_rows($res_hoa_ngung)>0){
            while($h=mysqli_fetch_assoc($res_hoa_ngung)){
                $imgsrc = $h['HinhAnh'] ? "../../images/".$h['HinhAnh'] : "no-image.png";
                echo "<tr>";
                echo "<td>{$h['MaHoa']}</td>";
                echo "<td><img src='$imgsrc' width='80'></td>";
                echo "<td>{$h['TenHoa']}</td>";
                echo "<td>{$h['Gia']}</td>";
                echo "<td>{$h['GiaCu']}</td>";
                echo "<td>{$h['SoLuong']}</td>";
                echo "<td>{$h['MauSac']}</td>";
                echo "<td>{$h['Tag']}</td>";
                echo "<td>{$h['TenLoai']}</td>";
                echo "<td>{$h['TenChuDe']}</td>";
                echo "<td>
                    <a href='edit_hoa.php?ma={$h['MaHoa']}'>Sửa</a> | 
                    <a href='ql_hoa.php?show={$h['MaHoa']}' onclick='return confirm(\"Hiển thị lại hoa này?\")'>Hiển thị</a>
                </td>";
                echo "</tr>";
            }
        } else echo "<tr><td colspan='11'>Chưa có hoa đã ẩn</td></tr>";
        ?>
    </table>
</div>
<style>
.admin-container {
    padding: 20px;
    font-family: Arial, sans-serif;
    background: #f4f4f4; /* nền sáng hơn */
    color: #111;
}

.admin-container h2 {
    color: #ff6600;
    margin-bottom: 20px;
    font-size: 28px;
}

.admin-container h3 {
    color: #ff9900;
    margin-top: 30px;
    margin-bottom: 15px;
    font-size: 22px;
    border-bottom: 2px solid #ff6600;
    padding-bottom: 5px;
}

.admin-container input, 
.admin-container select, 
.admin-container button {
    padding: 8px 10px;
    margin: 5px 5px 10px 0;
    border-radius: 5px;
    border: 1px solid #aaa;
    background: #fff;
    color: #111;
}

.admin-container input:focus,
.admin-container select:focus {
    outline: none;
    border-color: #ff9900;
}

.admin-container button {
    background: #28a745;
    color: #fff;
    border: none;
    cursor: pointer;
    transition: 0.3s;
}

.admin-container button:hover {
    background: #218838;
}

.admin-container table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 15px;
    background: #fff;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}

.admin-container th, .admin-container td {
    padding: 10px;
    text-align: center;
    border-bottom: 1px solid #ddd;
}

.admin-container th {
    background: #ffcc66;
    color: #111;
    font-weight: bold;
}

.admin-container td {
    color: #111;
}

.admin-container a {
    color: #ff6600;
    text-decoration: none;
    transition: 0.2s;
}

.admin-container a:hover {
    color: #ff3300;
}

.admin-container img {
    border-radius: 5px;
    max-width: 80px;
    height: auto;
}

/* Table zebra effect */
.admin-container table tr:nth-child(even) {
    background-color: #f9f9f9;
}

.admin-container table tr:hover {
    background-color: #ffe6b3;
}

/* Thông báo lỗi và thành công */
.admin-container ul { list-style: disc; padding-left: 20px; }
.admin-container ul li { color: #ff4d4d; margin-bottom: 5px; }
.admin-container p { font-weight: bold; color: #28a745; }
</style>
