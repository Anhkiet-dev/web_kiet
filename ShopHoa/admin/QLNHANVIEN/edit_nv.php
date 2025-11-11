<?php
include_once('../../config/db.php');
include_once('../header_admin.php'); // header riêng admin

// Kiểm tra id nhân viên
if(!isset($_GET['ma']) || !is_numeric($_GET['ma'])){
    header("Location: ql_nhanvien.php");
    exit;
}

$ma = (int)$_GET['ma'];
$errors = [];
$success = '';

// Lấy thông tin nhân viên hiện tại
$stmt = $conn->prepare("SELECT HoTen, Email, SDT, ChucVu FROM NhanVien WHERE MaNV=?");
$stmt->bind_param("i",$ma);
$stmt->execute();
$res = $stmt->get_result();
if($res->num_rows === 0){
    $stmt->close();
    header("Location: ql_nhanvien.php");
    exit;
}
$nv = $res->fetch_assoc();
$stmt->close();

// Xử lý cập nhật
if(isset($_POST['update_nv'])){
    $hoten = trim($_POST['hoten']);
    $email = trim($_POST['email']);
    $sdt = trim($_POST['sdt']);
    $chucvu = trim($_POST['chucvu']);
    $matkhau = $_POST['matkhau'];

    if(empty($hoten) || empty($email)){
        $errors[] = "Họ tên và Email không được để trống!";
    } elseif(!filter_var($email,FILTER_VALIDATE_EMAIL)){
        $errors[] = "Email không hợp lệ!";
    } else {
        // Kiểm tra email đã tồn tại với nhân viên khác
        $stmt_check = $conn->prepare("SELECT MaNV FROM NhanVien WHERE Email=? AND MaNV<>?");
        $stmt_check->bind_param("si",$email,$ma);
        $stmt_check->execute();
        $stmt_check->store_result();
        if($stmt_check->num_rows > 0){
            $errors[] = "Email đã tồn tại!";
        } else {
            // Update thông tin
            if(!empty($matkhau)){
                $hash = password_hash($matkhau, PASSWORD_DEFAULT);
                $stmt_update = $conn->prepare("UPDATE NhanVien SET HoTen=?, Email=?, SDT=?, ChucVu=?, MatKhau=? WHERE MaNV=?");
                $stmt_update->bind_param("sssssi",$hoten,$email,$sdt,$chucvu,$hash,$ma);
            } else {
                $stmt_update = $conn->prepare("UPDATE NhanVien SET HoTen=?, Email=?, SDT=?, ChucVu=? WHERE MaNV=?");
                $stmt_update->bind_param("ssssi",$hoten,$email,$sdt,$chucvu,$ma);
            }

            if($stmt_update->execute()){
                $success = "Cập nhật nhân viên thành công!";
                header("Location: ql_nhanvien.php");
                exit;
            } else {
                $errors[] = "Lỗi hệ thống: ".$stmt_update->error;
            }
            $stmt_update->close();
        }
        $stmt_check->close();
    }
}
?>

<div class="admin-container">
    <h2>Sửa thông tin Nhân viên</h2>

    <!-- Thông báo -->
    <?php if($errors) { echo '<ul style="color:red;">'; foreach($errors as $e) echo "<li>$e</li>"; echo '</ul>'; } ?>
    <?php if($success) echo "<p style='color:green;'>$success</p>"; ?>

    <form method="POST" style="margin-bottom:30px;">
        <input type="text" name="hoten" placeholder="Họ tên" value="<?php echo htmlspecialchars($nv['HoTen']); ?>" required>
        <input type="email" name="email" placeholder="Email" value="<?php echo htmlspecialchars($nv['Email']); ?>" required>
        <input type="text" name="sdt" placeholder="SĐT" value="<?php echo htmlspecialchars($nv['SDT']); ?>">
        <input type="text" name="chucvu" placeholder="Chức vụ" value="<?php echo htmlspecialchars($nv['ChucVu']); ?>">
        <input type="password" name="matkhau" placeholder="Mật khẩu mới (để trống nếu không đổi)">
        <button type="submit" name="update_nv">Cập nhật</button>
        <a href="ql_nhanvien.php" style="margin-left:10px;">Hủy</a>
    </form>
</div>

<style>
.admin-container { padding:20px; }
.admin-container h2 { color:#ff6600; margin-bottom:20px; }
.admin-container input, .admin-container button, .admin-container a { padding:8px; margin:5px 0; }
.admin-container button { background:#28a745; color:#fff; border:none; cursor:pointer; }
.admin-container a { text-decoration:none; color:#555; }
.admin-container a:hover { text-decoration:underline; }
</style>
