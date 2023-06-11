<?php
require 'config.php';
require 'functions.php';
session_start();
//Periksa apakah pengguna memiliki akses admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Mendapatkan data pengguna dari database
$users = getUsers();

date_default_timezone_set('Asia/Jakarta');
ob_start(); // Memulai output buffering

// Menghasilkan konten PDF menggunakan mpdf
require_once __DIR__ . '/vendor/autoload.php';

use Mpdf\Mpdf;

$mpdf = new Mpdf();
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

$mpdf->WriteHTML('<h1>Daftar Users</h1>');

$mpdf->WriteHTML('
    <table cellspacing="0" border="1" style="border-width: 2px; margin: auto;">
        <thead>
            <tr>
                <th>#</th>
                <th>Image Profile</th>
                <th>Username</th>
                <th>Nama Lengkap</th>
                <th>Email</th>
                <th>No. Telepon</th>
                <th>Alamat</th>
                <th>Saldo</th>
                <th>Role</th>
            </tr>
        </thead>
        <tbody>
');

$i = 1;
foreach ($users as $user) {
    $mpdf->WriteHTML('
        <tr>
            <td>' . $i++ . '</td>
            <td><img src="img/users/' . (!empty($user['img_profile']) ? $user['img_profile'] : 'default.png') . '" width="70px"></td>
            <td>' . $user['username'] . '</td>
            <td>' . $user['full_name'] . '</td>
            <td>' . $user['email'] . '</td>
            <td>' . $user['phone_number'] . '</td>
            <td>' . $user['address'] . '</td>
            <td>' . $user['balance'] . '</td>
            <td>' . $user['role'] . '</td>
        </tr>
    ');
}

$mpdf->WriteHTML('
        </tbody>
    </table>
');

$filename = 'daftar_users_' . $timestamp . '.pdf'; // Nama file PDF

$mpdf->Output($filename, 'D'); // Menampilkan hasil PDF dan memberikan opsi untuk mengunduhnya
ob_end_flush(); // Mengakhiri output buffering
