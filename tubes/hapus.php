<?php
include 'config.php';
session_start();

// Periksa apakah pengguna memiliki akses admin
// if (!isset($_SESSION['admin'])) {
//     header("Location: login.php");
//     exit();
// }

// Periksa apakah ada parameter user_id yang diterima melalui URL
if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    // Hapus data pengguna berdasarkan ID dari database
    $query = "DELETE FROM users WHERE user_id = '$user_id'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        // Redirect ke halaman admin setelah berhasil menghapus data
        header("Location: halaman_admin.php");
        exit();
    } else {
        // Tampilkan pesan error jika gagal menghapus data
        echo "Error: " . mysqli_error($conn);
    }
} else {
    // Redirect ke halaman admin jika tidak ada parameter user_id
    header("Location: halaman_admin.php");
    exit();
}
