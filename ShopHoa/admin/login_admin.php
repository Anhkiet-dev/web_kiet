<?php
session_start();
include_once('../config/db.php'); // kết nối database

$error = '';

if(isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM Admin WHERE Email='$email'";
    $res = mysqli_query($conn, $sql);

    if($res && mysqli_num_rows($res) > 0) {
        $admin = mysqli_fetch_assoc($res);

        // Kiểm tra mật khẩu (plaintext hoặc password_hash)
        if(password_verify($password, $admin['MatKhau'])) {
            $_SESSION['AdminHoTen'] = $admin['HoTen'];
            $_SESSION['AdminEmail'] = $admin['Email'];
            
            header("Location: index.php");
            exit;
        } else {
            $error = "Sai mật khẩu!";
        }
    } else {
        $error = "Admin không tồn tại!";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập Admin</title>
    <style>
        body { font-family: Arial; background: #f4f4f4; }
        .login-container { width: 350px; margin: 100px auto; background:#fff; padding:20px; border-radius:8px; box-shadow:0 0 10px rgba(0,0,0,0.2); }
        h2 { text-align:center; margin-bottom:20px; }
        input[type="email"], input[type="password"] { width:100%; padding:10px; margin-bottom:15px; border:1px solid #ccc; border-radius:5px; }
        button { width:100%; padding:10px; background:#ff3366; color:#fff; border:none; border-radius:5px; cursor:pointer; font-weight:bold; }
        button:hover { background:#ff6699; }
        .error { color:red; margin-bottom:10px; text-align:center; }
    </style>
</head>
<body>
<div class="login-container">
    <h2>Đăng nhập Admin</h2>
    <?php if($error) echo "<p class='error'>$error</p>"; ?>
    <form method="post" action="">
        <input type="email" name="email" placeholder="Email admin" required>
        <input type="password" name="password" placeholder="Mật khẩu" required>
        <button type="submit" name="login">Đăng nhập</button>
    </form>
</div>
</body>
</html>
