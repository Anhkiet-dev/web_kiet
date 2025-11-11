<?php
include_once('../../config/db.php');
include_once('../header_admin.php'); // header riêng admin

// --- Xử lý thêm nhân viên ---
$errors = [];
$success = '';
if(isset($_POST['add_nv'])){
    $hoten = trim($_POST['hoten']);
    $email = trim($_POST['email']);
    $sdt = trim($_POST['sdt']);
    $matkhau = $_POST['matkhau'];
    $chucvu = trim($_POST['chucvu']);

    if(empty($hoten) || empty($email) || empty($matkhau)){
        $errors[] = "Vui lòng điền đầy đủ thông tin bắt buộc!";
    } elseif(!filter_var($email,FILTER_VALIDATE_EMAIL)){
        $errors[] = "Email không hợp lệ!";
    } else {
        // Kiểm tra email đã tồn tại chưa
        $stmt = $conn->prepare("SELECT MaNV FROM NhanVien WHERE Email=?");
        $stmt->bind_param("s",$email);
        $stmt->execute();
        $stmt->store_result();
        if($stmt->num_rows > 0){
            $errors[] = "Email đã tồn tại!";
        } else {
            $hash = password_hash($matkhau, PASSWORD_DEFAULT);
            $stmt2 = $conn->prepare("INSERT INTO NhanVien (HoTen, Email, SDT, MatKhau, ChucVu) VALUES (?,?,?,?,?)");
            $stmt2->bind_param("sssss",$hoten,$email,$sdt,$hash,$chucvu);
            if($stmt2->execute()){
                $success = "Thêm nhân viên thành công!";
                header("Location: ql_nhanvien.php");
                exit;
            } else {
                $errors[] = "Lỗi hệ thống: ".$stmt2->error;
            }
            $stmt2->close();
        }
        $stmt->close();
    }
}

// --- Xử lý xóa nhân viên ---
if(isset($_GET['del']) && is_numeric($_GET['del'])){
    $ma = (int)$_GET['del'];
    $stmt = $conn->prepare("DELETE FROM NhanVien WHERE MaNV=?");
    $stmt->bind_param("i",$ma);
    $stmt->execute();
    $stmt->close();
    header("Location: ql_nhanvien.php");
    exit;
}

// --- Lấy danh sách nhân viên ---
$sql_nv = "SELECT MaNV, HoTen, Email, SDT, ChucVu, NgayTao FROM NhanVien ORDER BY MaNV DESC";
$res_nv = mysqli_query($conn, $sql_nv);
?>

<div class="admin-container">
    <h2>Quản lý Nhân viên</h2>

    <!-- Thông báo -->
    <?php if($errors) { echo '<ul style="color:red;">'; foreach($errors as $e) echo "<li>$e</li>"; echo '</ul>'; } ?>
    <?php if($success) echo "<p style='color:green;'>$success</p>"; ?>

    <!-- Form thêm nhân viên -->
    <h3>Thêm nhân viên mới</h3>
    <form method="POST" style="margin-bottom:30px;">
        <input type="text" name="hoten" placeholder="Họ tên" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="text" name="sdt" placeholder="SĐT">
        <input type="text" name="chucvu" placeholder="Chức vụ">
        <input type="password" name="matkhau" placeholder="Mật khẩu" required>
        <button type="submit" name="add_nv">Thêm nhân viên</button>
    </form>

    <!-- Danh sách nhân viên -->
    <h3>Danh sách nhân viên</h3>
    <table border="1" cellpadding="8" cellspacing="0">
        <tr>
            <th>MaNV</th>
            <th>Họ tên</th>
            <th>Email</th>
            <th>SĐT</th>
            <th>Chức vụ</th>
            <th>Ngày tạo</th>
            <th>Hành động</th>
        </tr>
        <?php
        if($res_nv && mysqli_num_rows($res_nv) > 0){
            while($nv = mysqli_fetch_assoc($res_nv)){
                echo "<tr>";
                echo "<td>{$nv['MaNV']}</td>";
                echo "<td>".htmlspecialchars($nv['HoTen'])."</td>";
                echo "<td>".htmlspecialchars($nv['Email'])."</td>";
                echo "<td>".htmlspecialchars($nv['SDT'])."</td>";
                echo "<td>".htmlspecialchars($nv['ChucVu'])."</td>";
                echo "<td>{$nv['NgayTao']}</td>";
                echo "<td>
                        <a href='edit_nv.php?ma={$nv['MaNV']}'>Sửa</a> | 
                        <a href='ql_nhanvien.php?del={$nv['MaNV']}' onclick='return confirm(\"Bạn có chắc muốn xóa?\")'>Xóa</a>
                      </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='7'>Chưa có nhân viên nào.</td></tr>";
        }
        ?>
    </table>
</div>

<style>
.admin-container { padding:20px; }
.admin-container h2 { color:#ff6600; margin-bottom:20px; }
.admin-container h3 { color:#ff9900; margin-top:20px; }
.admin-container input, .admin-container button { padding:8px; margin:5px 0; }
.admin-container button { background:#28a745; color:#fff; border:none; cursor:pointer; }
.admin-container table { width:100%; margin-top:15px; border-collapse:collapse; }
.admin-container th { background:#222; color:#fff; }
.admin-container td { text-align:center; }
.admin-container a { color:#007bff; text-decoration:none; }
.admin-container a:hover { text-decoration:underline; }
</style>
