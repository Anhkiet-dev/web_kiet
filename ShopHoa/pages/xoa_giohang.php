<?php
session_start();

if (isset($_GET['key'])) {
    $key = $_GET['key'];
    if (isset($_SESSION['giohang'][$key])) {
        unset($_SESSION['giohang'][$key]);
    }
}

header("Location: giohang.php");
exit;
?>
