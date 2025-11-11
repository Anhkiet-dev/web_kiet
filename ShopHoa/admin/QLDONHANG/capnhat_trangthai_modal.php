<?php
session_start();
include_once('../../config/db.php');

if(!isset($_SESSION['admin'])){
    header("Location: ../dangnhap_admin.php");
    exit;
}

if(isset($_POST['MaDon'], $_POST['trangthai'])){
    $MaDon = (int)$_POST['MaDon'];
    $trangthai = $_POST['trangthai'];
    $stmt = $conn->prepare("UPDATE donhang SET TrangThai=? WHERE MaDon=?");
    $stmt->bind_param("si", $trangthai, $MaDon);
    $stmt->execute();
    $stmt->close();
}

header("Location: ql_donhang.php");
exit;
