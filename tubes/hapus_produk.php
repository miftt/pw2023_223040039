<?php
include 'config.php';
session_start();

// Periksa apakah pengguna memiliki akses admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Periksa apakah ada parameter menu_id yang dikirimkan melalui URL
if (!isset($_GET['menu_id'])) {
    header("Location: menu.php");
    exit();
}

$menuId = $_GET['menu_id'];

// Periksa apakah produk dengan menu_id yang diberikan ada di database
$query = "SELECT * FROM Menu WHERE menu_id = $menuId";
$result = mysqli_query($conn, $query);
$product = mysqli_fetch_assoc($result);

// Periksa apakah produk dengan menu_id yang diberikan ada di database
if (!$product) {
    header("Location: menu.php");
    exit();
}

// Hapus file gambar jika ada
if (!empty($product['menu_image'])) {
    $uploadPath = 'img/products/';
    unlink($uploadPath . $product['menu_image']);
}

// Hapus kategori produk terkait
$deleteQuery = "DELETE FROM Menu_Category WHERE menu_id = $menuId";
mysqli_query($conn, $deleteQuery);

// Hapus produk dari tabel Menu
$deleteQuery = "DELETE FROM Menu WHERE menu_id = $menuId";
mysqli_query($conn, $deleteQuery);

// Redirect ke halaman menu.php setelah hapus berhasil
header("Location: menu.php");
exit();
