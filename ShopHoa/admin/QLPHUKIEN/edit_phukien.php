<?php
include_once('../../config/db.php');
include_once('../header_admin.php');

$errors = [];
$success = '';

// --- Lấy mã phụ kiện cần sửa ---
if (!isset($_GET['ma']) || !is_numeric($_GET['ma'])) {
    echo "<p style='color:red;'>❌ Thiếu mã phụ kiện!</p>";
    exit;
}

$id = (int)$_GET['ma'];

// --- Lấy dữ liệu phụ kiện ---
$sql_pk = "SELECT * FROM phukien WHERE MaPhuKien = $id";
$res_pk = mysqli_query($conn, $sql_pk);
if (!$res_pk || mysqli_num_rows($res_pk) == 0) {
    echo "<p style='color:red;'>❌ Không tìm thấy phụ kiện cần sửa!</p>";
    exit;
}
$pk = mysqli_fetch_assoc($res_pk);

// --- Lấy danh sách loại phụ kiện ---
$res_loai = mysqli_query($conn, "SELECT * FROM loaiphukien ORDER BY TenLoaiPK ASC");

// --- Cập nhật phụ kiện ---
if (isset($_POST['update_pk'])) {
    $ten = trim($_POST['tenpk']);
    $gia = (float)trim($_POST['gia']);
    $mota = trim($_POST['mota']);
    $soluong = (int)trim($_POST['soluong']);
    $trangthai = trim($_POST['trangthai']);
    $hinh = trim($_POST['hinh']);
    $maloai = (int)$_POST['maloaipk'];

    if ($ten == '' || $gia <= 0) {
        $errors[] = "⚠️ Vui lòng nhập tên phụ kiện và giá hợp lệ!";
    } elseif ($maloai <= 0) {
        $errors[] = "⚠️ Hãy chọn loại phụ kiện!";
    } else {
        $stmt = $conn->prepare("UPDATE phukien 
                                SET TenPhuKien=?, Gia=?, MoTa=?, SoLuong=?, TrangThai=?, HinhAnh=?, MaLoaiPK=? 
                                WHERE MaPhuKien=?");
        $stmt->bind_param("sdsissii", $ten, $gia, $mota, $soluong, $trangthai, $hinh, $maloai, $id);
        if ($stmt->execute()) {
            $success = "✅ Cập nhật phụ kiện thành công!";
            $res_pk = mysqli_query($conn, "SELECT * FROM phukien WHERE MaPhuKien = $id");
            $pk = mysqli_fetch_assoc($res_pk);
        } else {
            $errors[] = "❌ Lỗi hệ thống: " . $stmt->error;
        }
        $stmt->close();
    }
}
?>

<div class="admin-container">
    <h2>✏️ Sửa phụ kiện</h2>

    <!-- Thông báo -->
    <?php if ($errors): ?>
        <ul class="alert-error">
            <?php foreach ($errors as $e) echo "<li>$e</li>"; ?>
        </ul>
    <?php endif; ?>

    <?php if ($success): ?>
        <p class="alert-success"><?php echo $success; ?></p>
    <?php endif; ?>

    <!-- Form sửa phụ kiện -->
    <form method="POST" class="form-edit-pk">
        <label>Tên phụ kiện:</label>
        <input type="text" name="tenpk" value="<?php echo htmlspecialchars($pk['TenPhuKien']); ?>" required>

        <label>Giá (VNĐ):</label>
        <input type="number" step="0.01" name="gia" value="<?php echo $pk['Gia']; ?>" required>

        <label>Mô tả chi tiết:</label>
        <textarea name="mota" rows="4"><?php echo htmlspecialchars($pk['MoTa']); ?></textarea>

        <label>Số lượng:</label>
        <input type="number" name="soluong" value="<?php echo $pk['SoLuong']; ?>" min="0">

        <label>Loại phụ kiện:</label>
        <select name="maloaipk" required>
            <option value="">-- Chọn loại phụ kiện --</option>
            <?php
            if ($res_loai && mysqli_num_rows($res_loai) > 0) {
                while ($row = mysqli_fetch_assoc($res_loai)) {
                    $selected = ($row['MaLoaiPK'] == $pk['MaLoaiPK']) ? 'selected' : '';
                    echo "<option value='{$row['MaLoaiPK']}' $selected>{$row['TenLoaiPK']}</option>";
                }
            } else {
                echo "<option value=''>Chưa có loại phụ kiện</option>";
            }
            ?>
        </select>

        <label>Trạng thái:</label>
        <select name="trangthai">
            <option value="Còn hàng" <?php if ($pk['TrangThai'] == 'Còn hàng') echo 'selected'; ?>>Còn hàng</option>
            <option value="Hết hàng" <?php if ($pk['TrangThai'] == 'Hết hàng') echo 'selected'; ?>>Hết hàng</option>
        </select>

        <label>Hình ảnh:</label>
        <input list="imagesList" name="hinh" value="<?php echo htmlspecialchars($pk['HinhAnh']); ?>">
        <datalist id="imagesList">
            <?php
            $imgs = glob('../../images/*.{jpg,jpeg,png,gif}', GLOB_BRACE);
            foreach ($imgs as $img) {
                $imgfile = basename($img);
                echo "<option value='$imgfile'>";
            }
            ?>
        </datalist>

        <div class="preview">
            <img src="../../images/<?php echo $pk['HinhAnh'] ?: 'no-image.png'; ?>" width="120" alt="Preview ảnh">
        </div>

        <button type="submit" name="update_pk">💾 Lưu thay đổi</button>
        <a href="ql_phukien.php" class="btn-back">⬅ Quay lại danh sách</a>
    </form>
</div>

<style>
.admin-container {
    padding: 25px;
    background: #f5f5f5;
    font-family: Arial, sans-serif;
}
.admin-container h2 {
    color: #ff6600;
    margin-bottom: 20px;
}
.form-edit-pk {
    background: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 5px rgba(0,0,0,0.1);
    max-width: 600px;
}
.form-edit-pk label {
    display: block;
    margin-top: 10px;
    font-weight: bold;
    color: #333;
}
.form-edit-pk input, 
.form-edit-pk select,
.form-edit-pk textarea {
    width: 100%;
    padding: 8px;
    margin-top: 5px;
    border: 1px solid #ccc;
    border-radius: 4px;
}
.form-edit-pk textarea {
    resize: vertical;
}
.form-edit-pk button {
    margin-top: 15px;
    padding: 10px 15px;
    background: #28a745;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}
.form-edit-pk button:hover {
    background: #218838;
}
.btn-back {
    display: inline-block;
    margin-left: 10px;
    color: #007bff;
    text-decoration: none;
}
.btn-back:hover {
    text-decoration: underline;
}
.preview {
    margin-top: 10px;
}
.preview img {
    border-radius: 5px;
    border: 1px solid #ddd;
    object-fit: cover;
}
.alert-error {
    color: red;
    background: #ffe6e6;
    border-left: 5px solid red;
    padding: 8px 15px;
    list-style: square;
}
.alert-success {
    color: green;
    background: #e7ffe7;
    border-left: 5px solid green;
    padding: 8px 15px;
}
</style>
