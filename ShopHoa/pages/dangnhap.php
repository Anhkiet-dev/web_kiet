<?php
require_once __DIR__ . '/../config/db.php';
session_start();

// --- Xử lý đăng nhập ---
$errors_login = [];
if(isset($_POST['submit_login'])){
    $email = trim($_POST['email_login']);
    $matkhau = $_POST['matkhau_login'];

    if(empty($email) || empty($matkhau)){
        $errors_login[] = "Vui lòng điền đầy đủ thông tin!";
    } else {
        $stmt = $conn->prepare("SELECT MaKH, HoTen, MatKhau FROM KhachHang WHERE Email=?");
        $stmt->bind_param("s",$email);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($id, $hoten, $hash);
        if($stmt->num_rows == 1){
            $stmt->fetch();
            if(password_verify($matkhau, $hash)){
                $_SESSION['MaKH'] = $id;
                $_SESSION['HoTen'] = $hoten;
                header("Location: ../index.php?page=home");
                exit;
            } else {
                $errors_login[] = "Mật khẩu không đúng!";
            }
        } else {
            $errors_login[] = "Email không tồn tại!";
        }
        $stmt->close();
    }
}

// --- Xử lý đăng ký ---
$errors_reg = [];
$success_reg = '';
if(isset($_POST['submit_reg'])){
    $hoten = trim($_POST['hoten']);
    $email = trim($_POST['email']);
    $sdt = trim($_POST['sdt']);
    $diachi = trim($_POST['diachi']);
    $matkhau = $_POST['matkhau'];
    $matkhau2 = $_POST['matkhau2'];

    if(empty($hoten) || empty($email) || empty($matkhau) || empty($matkhau2)){
        $errors_reg[] = "Vui lòng điền đầy đủ thông tin!";
    } elseif(!filter_var($email,FILTER_VALIDATE_EMAIL)){
        $errors_reg[] = "Email không hợp lệ!";
    } elseif($matkhau !== $matkhau2){
        $errors_reg[] = "Mật khẩu không khớp!";
    } else {
        $stmt = $conn->prepare("SELECT MaKH FROM KhachHang WHERE Email=?");
        $stmt->bind_param("s",$email);
        $stmt->execute();
        $stmt->store_result();
        if($stmt->num_rows > 0){
            $errors_reg[] = "Email đã tồn tại!";
        } else {
            $matkhau_hash = password_hash($matkhau,PASSWORD_DEFAULT);
            $stmt2 = $conn->prepare("INSERT INTO KhachHang (HoTen, Email, SDT, DiaChi, MatKhau) VALUES (?,?,?,?,?)");
            $stmt2->bind_param("sssss",$hoten,$email,$sdt,$diachi,$matkhau_hash);
            if($stmt2->execute()){
                $success_reg = "Đăng ký thành công! Bạn có thể đăng nhập ngay.";
            } else {
                $errors_reg[] = "Lỗi hệ thống: ".$stmt2->error;
            }
            $stmt2->close();
        }
        $stmt->close();
    }
}
?>

<?php include('../includes/header.php'); ?>

<style>
.account-container { display:flex; gap:50px; flex-wrap:wrap; margin:20px; }
.account-box { background:#222; color:#fff; padding:20px; flex:1; min-width:300px; }
.account-box input, .account-box textarea { width:100%; margin:5px 0; padding:8px; }
.account-box button { background:#5cb85c; border:none; padding:10px 15px; color:#fff; cursor:pointer; }
.account-box h2 { margin-bottom:15px; }
.account-box ul { color:red; padding-left:20px; }
.success-msg { color:green; }
</style>

<div class="account-container">
    <!-- Đăng ký -->
    <div class="account-box">
        <h2>Chưa có tài khoản?</h2>
        <?php if(!empty($errors_reg)) { echo '<ul>'; foreach($errors_reg as $e) echo "<li>$e</li>"; echo '</ul>'; } ?>
        <?php if($success_reg) echo "<p class='success-msg'>$success_reg</p>"; ?>
        <form method="POST">
            <input type="text" name="hoten" placeholder="Họ và tên" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="text" name="sdt" placeholder="Điện thoại">
            <textarea name="diachi" placeholder="Địa chỉ"></textarea>
            <input type="password" name="matkhau" placeholder="Mật khẩu" required>
            <input type="password" name="matkhau2" placeholder="Nhập lại mật khẩu" required>
            <button type="submit" name="submit_reg">Tạo tài khoản mới</button>
        </form>
    </div>

    <!-- Đăng nhập -->
    <div class="account-box">
        <h2>Đã có tài khoản</h2>
        <?php if(!empty($errors_login)) { echo '<ul>'; foreach($errors_login as $e) echo "<li>$e</li>"; echo '</ul>'; } ?>
        <form method="POST">
            <input type="email" name="email_login" placeholder="Email" required>
            <input type="password" name="matkhau_login" placeholder="Mật khẩu" required>
            <button type="submit" name="submit_login">Đăng nhập</button>
        </form>
    </div>
</div>

<?php include('../includes/footer.php'); ?>
