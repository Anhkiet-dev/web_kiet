<?php
include __DIR__ . '/config/db.php';
$page = isset($_GET['page']) ? $_GET['page'] : 'home';
$page_path = __DIR__ . '/pages/' . $page . '.php';
if (!file_exists($page_path)) {
    $page_path = __DIR__ . '/pages/home.php';
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Shop Hoa Tươi Online</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<?php include __DIR__ . '/includes/header.php'; ?>

<main style="min-height:70vh; padding:20px;">
    <?php include $page_path; ?>
</main>

<?php include __DIR__ . '/includes/footer.php'; ?>

</body>
</html>
