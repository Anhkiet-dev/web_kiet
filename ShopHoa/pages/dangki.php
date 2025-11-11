<?php
require_once __DIR__ . '/../config/db.php';

$errors = [];
$success = '';

if(isset($_POST['submit'])) {
    $hoten = trim($_POST['hoten']);
    $email = trim($_POST['email']);
    $sdt = trim($_POST['sdt']);
    $diachi = trim($_POST['diachi']);
    $matkhau = $_POST['matkhau'];
    $matkhau2 = $_POST['matkhau2'];

    // Kiểm tra các trường bắt buộc
    if(empty($hoten) || empty($email) || empty($matkhau) || empty($matkhau2)) {
        $errors[] = "Vui lòng điền đầy đủ thông tin bắt buộc!";
    }

    // Kiểm tra email hợp lệ
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email không hợp lệ!";
    }

    // Kiểm tra mật khẩu trùng khớp
    if($matkhau !== $matkhau2) {
        $errors[] = "Mật khẩu không khớp!";
    }

    // Kiểm tra email đã tồn tại
    $stmt = $conn->prepare("SELECT MaKH FROM KhachHang WHERE Email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    if($stmt->num_rows > 0) {
        $errors[] = "Email này đã được đăng ký!";
    }
    $stmt->close();

    // Nếu không lỗi, thêm vào CSDL
    if(empty($errors)) {
        $matkhau_hash = password_hash($matkhau, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO KhachHang (HoTen, Email, SDT, DiaChi, MatKhau) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $hoten, $email, $sdt, $diachi, $matkhau_hash);
        if($stmt->execute()) {
            $success = "Đăng ký thành công! <a href='index.php?page=dangnhap'>Đăng nhập ngay</a>";
        } else {
            $errors[] = "Lỗi hệ thống: " . $stmt->error;
        }
        $stmt->close();
    }
}
?>

<h2>Đăng ký tài khoản</h2>

<?php
if(!empty($errors)) {
    echo "<ul style='color:red;'>";
    foreach($errors as $e) echo "<li>$e</li>";
    echo "</ul>";
}

if($success) {
    echo "<p style='color:green;'>$success</p>";
}
?>

<form method="POST">
    <input type="text" name="hoten" placeholder="Họ và tên" value="<?= isset($hoten) ? htmlspecialchars($hoten) : '' ?>" required><br>
    <input type="email" name="email" placeholder="Email" value="<?= isset($email) ? htmlspecialchars($email) : '' ?>" required><br>
    <input type="text" name="sdt" placeholder="Số điện thoại" value="<?= isset($sdt) ? htmlspecialchars($sdt) : '' ?>"><br>
    <textarea name="diachi" placeholder="Địa chỉ"><?= isset($diachi) ? htmlspecialchars($diachi) : '' ?></textarea><br>
    <input type="password" name="matkhau" placeholder="Mật khẩu" required><br>
    <input type="password" name="matkhau2" placeholder="Nhập lại mật khẩu" required><br>
    <button type="submit" name="submit">Đăng ký</button>
</form>
