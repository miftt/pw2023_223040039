<?php
require 'config.php';
require 'functions.php';
session_start();
//Periksa apakah pengguna memiliki akses admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}
// Mendapatkan data produk dari database
$products = getProducts();
$categories = getCategories();

ob_start(); // Memulai output buffering

// Menghasilkan konten PDF menggunakan mpdf
require_once __DIR__ . '/vendor/autoload.php';

use Mpdf\Mpdf;

$mpdf = new Mpdf();
date_default_timezone_set('Asia/Jakarta');
// Mengatur header dan footer
$timestamp = date('YmdHis'); // Mendapatkan timestamp sebagai nama file
$companyName = 'GreenBites'; // Nama perusahaan

$headerContent = '
    <table width="100%">
        <tr>
            <td align="center">
                <h1>' . $companyName . '</h1>
            </td>
        </tr>
        <tr>
            <td align="right">
                ' . date('d-m-y H:i:s') . '
            </td>
        </tr>
    </table>';

$footerContent = '
    <table width="100%">
        <tr>
            <td width="50%" align="left">' . $companyName . '</td>
            <td width="50%" align="right">{PAGENO} of {nb}</td>
        </tr>
    </table>';

$mpdf->SetHTMLHeader($headerContent); // Menampilkan header
$mpdf->SetHTMLFooter($footerContent); // Menampilkan footer

$mpdf->WriteHTML('<h1>Daftar Produk</h1>');

$mpdf->WriteHTML('
    <table cellspacing="0" border="1" style="border-width: 2px; margin: auto;">
        <thead>
            <tr>
                <th>#</th>
                <th>Gambar</th>
                <th>Nama Menu</th>
                <th>Deskripsi</th>
                <th>Harga</th>
                <th>Kategori</th>
                <th>Quantity</th>
            </tr>
        </thead>
        <tbody>
');

$i = 1;
foreach ($products as $product) {
    $mpdf->WriteHTML('
        <tr>
            <td>' . $i++ . '</td>
            <td><img src="img/products/' . $product['menu_image'] . '" width="70px"></td>
            <td>' . $product['menu_name'] . '</td>
            <td>' . $product['menu_description'] . '</td>
            <td>' . $product['menu_price'] . '</td>
            <td>' . $product['category_name'] . '</td>
            <td>' . $product['quantity'] . '</td>
        </tr>
    ');
}

$mpdf->WriteHTML('
        </tbody>
    </table>
');

$filename = 'daftar_produk_' . $timestamp . '.pdf'; // Nama file PDF

$mpdf->Output($filename, 'D'); // Menampilkan hasil PDF dan memberikan opsi untuk mengunduhnya
ob_end_flush(); // Mengakhiri output buffering
