<?php
session_start();
include_once('../../config/db.php');
include_once('../header_admin.php');

$errors = [];

// Kiểm tra mã hoa hợp lệ
if(!isset($_GET['ma']) || !is_numeric($_GET['ma'])){
    die("Mã hoa không hợp lệ!");
}

$mahoa = (int)$_GET['ma'];

// Lấy thông tin hoa
$stmt = $conn->prepare("SELECT * FROM Hoa WHERE MaHoa=?");
$stmt->bind_param("i", $mahoa);
$stmt->execute();
$res = $stmt->get_result();
if($res->num_rows == 0){
    die("Hoa không tồn tại!");
}
$hoa = $res->fetch_assoc();
$stmt->close();

// Lấy danh sách LoaiHoa và ChuDe
$res_loai = mysqli_query($conn, "SELECT MaLoai, TenLoai FROM LoaiHoa");
$res_chude = mysqli_query($conn, "SELECT MaChuDe, TenChuDe FROM ChuDe");

// Xử lý cập nhật
if(isset($_POST['update_hoa'])){
    $ten = trim($_POST['tenhoa']);
    $gia = (float)trim($_POST['gia']);
    $giacu = (float)trim($_POST['giacu']);
    $soluong = (int)trim($_POST['soluong']);
    $mausac = trim($_POST['mausac']);
    $mota = trim($_POST['mota']);
    $tag = $_POST['tag'];
    $maloai = !empty($_POST['maloai']) ? (int)$_POST['maloai'] : null;
    $machude = !empty($_POST['machude']) ? (int)$_POST['machude'] : null;
    $hinh = $_POST['hinh'];
    $trangthai = $_POST['trangthai'] ?? 'Còn hàng';

    if(empty($ten) || empty($gia)){
        $errors[] = "Tên hoa và giá bắt buộc phải điền!";
    } else {
        $stmt = $conn->prepare("UPDATE Hoa 
            SET TenHoa=?, Gia=?, GiaCu=?, SoLuong=?, MauSac=?, MoTa=?, Tag=?, MaLoai=?, MaChuDe=?, HinhAnh=?, TrangThai=? 
            WHERE MaHoa=?");

        // Bind param đúng kiểu
        $stmt->bind_param(
            "sddisssiissi",
            $ten, $gia, $giacu, $soluong, $mausac, $mota, $tag, $maloai, $machude, $hinh, $trangthai, $mahoa
        );

        if($stmt->execute()){
            header("Location: ql_hoa.php?msg=success");
            exit;
        } else {
            $errors[] = "Lỗi hệ thống: ".$stmt->error;
        }
        $stmt->close();
    }
}
?>

<div class="admin-container">
    <h2>Sửa hoa</h2>

    <?php if($errors) { echo '<ul style="color:red;">'; foreach($errors as $e) echo "<li>$e</li>"; echo '</ul>'; } ?>

    <form method="POST" style="margin-bottom:30px;">
        <input type="text" name="tenhoa" placeholder="Tên hoa" value="<?php echo htmlspecialchars($hoa['TenHoa']); ?>" required>
        <input type="number" step="0.01" name="gia" placeholder="Giá" value="<?php echo $hoa['Gia']; ?>" required>
        <input type="number" step="0.01" name="giacu" placeholder="Giá cũ" value="<?php echo $hoa['GiaCu']; ?>">
        <input type="number" name="soluong" placeholder="Số lượng" value="<?php echo $hoa['SoLuong']; ?>">
        <input type="text" name="mausac" placeholder="Màu sắc" value="<?php echo htmlspecialchars($hoa['MauSac']); ?>">
        <input type="text" name="mota" placeholder="Mô tả" value="<?php echo htmlspecialchars($hoa['MoTa']); ?>">

        <select name="tag">
            <?php
            $tags = ['NONE','NEW','SALE','FREESHIP','HOT'];
            foreach($tags as $t){
                $sel = ($hoa['Tag']==$t) ? 'selected' : '';
                echo "<option value='$t' $sel>$t</option>";
            }
            ?>
        </select>

        <select name="maloai">
            <option value="">Chọn Loại</option>
            <?php
            mysqli_data_seek($res_loai, 0);
            while($l = mysqli_fetch_assoc($res_loai)){
                $sel = ($hoa['MaLoai']==$l['MaLoai']) ? 'selected' : '';
                echo "<option value='{$l['MaLoai']}' $sel>{$l['TenLoai']}</option>";
            }
            ?>
        </select>

        <select name="machude">
            <option value="">Chọn Chủ đề</option>
            <?php
            mysqli_data_seek($res_chude, 0);
            while($c = mysqli_fetch_assoc($res_chude)){
                $sel = ($hoa['MaChuDe']==$c['MaChuDe']) ? 'selected' : '';
                echo "<option value='{$c['MaChuDe']}' $sel>{$c['TenChuDe']}</option>";
            }
            ?>
        </select>

        <select name="hinh">
            <option value="">Chọn ảnh</option>
            <?php
            $imgs = glob('../../images/*.{jpg,jpeg,png,gif}', GLOB_BRACE);
            foreach($imgs as $imgfile){
                $name = basename($imgfile);
                $sel = ($hoa['HinhAnh']==$name) ? 'selected' : '';
                echo "<option value='$name' $sel>$name</option>";
            }
            ?>
        </select>

        <select name="trangthai">
            <?php
            $trangthais = ['Còn hàng','Hết hàng','Ngừng bán'];
            foreach($trangthais as $tt){
                $sel = ($hoa['TrangThai']==$tt) ? 'selected' : '';
                echo "<option value='$tt' $sel>$tt</option>";
            }
            ?>
        </select>

        <button type="submit" name="update_hoa">Cập nhật hoa</button>
    </form>
</div>

<style>
.admin-container { padding:20px; background:#f8f9fa; border-radius:8px; }
.admin-container input, .admin-container select, .admin-container button { padding:10px; margin:5px 0; width:100%; max-width:400px; }
.admin-container button { background:#28a745; color:#fff; border:none; cursor:pointer; border-radius:5px; }
.admin-container select { width:100%; }
.admin-container h2 { color:#ff6600; }
.admin-container ul { list-style:none; padding-left:0; }
</style>
