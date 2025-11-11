<?php
include_once('../../config/db.php');
include_once('../header_admin.php');

$errors = [];
$success = '';

// --- Kiểm tra bảng loại phụ kiện ---
$res_loai = mysqli_query($conn, "SELECT * FROM loaiphukien ORDER BY TenLoaiPK ASC");
$has_loai = ($res_loai && mysqli_num_rows($res_loai) > 0);

// --- Xử lý thêm phụ kiện ---
if (isset($_POST['add_pk'])) {
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
        // Kiểm tra loại tồn tại
        $check = $conn->prepare("SELECT COUNT(*) FROM loaiphukien WHERE MaLoaiPK = ?");
        $check->bind_param("i", $maloai);
        $check->execute();
        $check->bind_result($count);
        $check->fetch();
        $check->close();

        if ($count == 0) {
            $errors[] = "❌ Loại phụ kiện không tồn tại!";
        } else {
            $stmt = $conn->prepare("INSERT INTO phukien (TenPhuKien, Gia, MoTa, SoLuong, TrangThai, HinhAnh, MaLoaiPK) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sdssisi", $ten, $gia, $mota, $soluong, $trangthai, $hinh, $maloai);
            if ($stmt->execute()) {
                $success = "✅ Thêm phụ kiện thành công!";
            } else {
                $errors[] = "❌ Lỗi khi thêm: " . $stmt->error;
            }
            $stmt->close();
        }
    }
}

// --- Xóa phụ kiện ---
if (isset($_GET['del']) && is_numeric($_GET['del'])) {
    $id = (int)$_GET['del'];
    $stmt = $conn->prepare("DELETE FROM phukien WHERE MaPhuKien=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    header("Location: ql_phukien.php");
    exit;
}

// --- Lấy danh sách phụ kiện ---
$sql_pk = "SELECT p.*, l.TenLoaiPK 
            FROM phukien p 
            LEFT JOIN loaiphukien l ON p.MaLoaiPK = l.MaLoaiPK 
            ORDER BY p.MaPhuKien DESC";
$res_pk = mysqli_query($conn, $sql_pk);
?>

<div class="admin-container">
    <h2>QUẢN LÝ PHỤ KIỆN</h2>

    <!-- Thông báo -->
    <?php if ($errors): ?>
        <ul class="alert-error">
            <?php foreach ($errors as $e) echo "<li>$e</li>"; ?>
        </ul>
    <?php endif; ?>

    <?php if ($success): ?>
        <p class="alert-success"><?php echo $success; ?></p>
    <?php endif; ?>

    <!-- Form thêm phụ kiện -->
    <h3>Thêm phụ kiện mới</h3>
    <?php if (!$has_loai): ?>
        <p style="color:red;">⚠️ Chưa có loại phụ kiện nào! Hãy thêm ít nhất 1 loại trong bảng <b>loaiphukien</b> trước khi thêm phụ kiện.</p>
    <?php else: ?>
    <form method="POST" class="form-add-pk">
        <input type="text" name="tenpk" placeholder="Tên phụ kiện" required>
        <input type="number" step="0.01" name="gia" placeholder="Giá" required>
        <textarea name="mota" placeholder="Mô tả chi tiết" rows="3"></textarea>
        <input type="number" name="soluong" placeholder="Số lượng" value="0" min="0">

        <select name="maloaipk" required>
            <option value="">-- Chọn loại phụ kiện --</option>
            <?php
            mysqli_data_seek($res_loai, 0);
            while ($row = mysqli_fetch_assoc($res_loai)) {
                echo "<option value='{$row['MaLoaiPK']}'>{$row['TenLoaiPK']}</option>";
            }
            ?>
        </select>

        <select name="trangthai">
            <option value="Còn hàng">Còn hàng</option>
            <option value="Hết hàng">Hết hàng</option>
        </select>

        <label>Chọn hoặc nhập tên ảnh:</label>
        <input list="imagesList" name="hinh" placeholder="Gõ tên ảnh hoặc chọn từ danh sách">
        <datalist id="imagesList">
            <?php
            $imgs = glob('../../images/*.{jpg,jpeg,png,gif}', GLOB_BRACE);
            foreach ($imgs as $img) {
                $imgfile = basename($img);
                echo "<option value='$imgfile'>";
            }
            ?>
        </datalist>

        <button type="submit" name="add_pk">➕ Thêm phụ kiện</button>
    </form>
    <?php endif; ?>

    <!-- Danh sách phụ kiện -->
    <h3>Danh sách phụ kiện</h3>
    <table>
        <tr>
            <th>Mã PK</th>
            <th>Hình ảnh</th>
            <th>Tên phụ kiện</th>
            <th>Loại phụ kiện</th>
            <th>Giá</th>
            <th>Mô tả</th>
            <th>Số lượng</th>
            <th>Trạng thái</th>
            <th>Hành động</th>
        </tr>
        <?php
        if ($res_pk && mysqli_num_rows($res_pk) > 0) {
            while ($pk = mysqli_fetch_assoc($res_pk)) {
                $imgsrc = !empty($pk['HinhAnh']) ? "../../images/" . $pk['HinhAnh'] : "../../images/no-image.png";
                $tenLoai = $pk['TenLoaiPK'] ?: '<i>Chưa phân loại</i>';
                echo "<tr>";
                echo "<td>{$pk['MaPhuKien']}</td>";
                echo "<td><img src='$imgsrc' width='80' height='80'></td>";
                echo "<td>{$pk['TenPhuKien']}</td>";
                echo "<td>$tenLoai</td>";
                echo "<td>" . number_format($pk['Gia'], 0, ',', '.') . " đ</td>";
                echo "<td style='max-width:250px; white-space:normal; text-align:left;'>{$pk['MoTa']}</td>";
                echo "<td>{$pk['SoLuong']}</td>";
                echo "<td>{$pk['TrangThai']}</td>";
                echo "<td>
                        <a href='edit_phukien.php?ma={$pk['MaPhuKien']}' class='btn-edit'>✏️ Sửa</a> | 
                        <a href='ql_phukien.php?del={$pk['MaPhuKien']}' class='btn-del' onclick='return confirm(\"Bạn có chắc muốn xóa phụ kiện này không?\")'>🗑️ Xóa</a>
                      </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='9'>Chưa có phụ kiện nào.</td></tr>";
        }
        ?>
    </table>
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
.admin-container h3 {
    color: #ff9900;
    margin-top: 25px;
}
.form-add-pk input,
.form-add-pk select,
.form-add-pk textarea,
.form-add-pk button {
    padding: 8px;
    margin: 5px 5px 10px 0;
    border: 1px solid #ccc;
    border-radius: 4px;
    width: calc(100% - 10px);
}
.form-add-pk textarea {
    resize: vertical;
}
.form-add-pk button {
    width: auto;
    background: #28a745;
    color: #fff;
    border: none;
    cursor: pointer;
    transition: 0.2s;
}
.form-add-pk button:hover {
    background: #218838;
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
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 15px;
    background: #fff;
}
table th, table td {
    border: 1px solid #ddd;
    padding: 10px;
    text-align: center;
}
table th {
    background: #333;
    color: #fff;
}
.btn-edit {
    color: #007bff;
}
.btn-del {
    color: #dc3545;
}
.btn-edit:hover, .btn-del:hover {
    text-decoration: underline;
}
img {
    border-radius: 6px;
    object-fit: cover;
}
</style>
