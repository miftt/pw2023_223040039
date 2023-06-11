<?php
include 'config.php';
session_start();

//Periksa apakah pengguna memiliki akses admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Periksa apakah ada parameter user_id yang diterima melalui URL
if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    // Hapus file gambar jika ada
    $query = "SELECT img_profile FROM users WHERE user_id = '$user_id'";
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);

    if (!empty($user['img_profile'])) {
        $uploadPath = 'img/users/';
        unlink($uploadPath . $user['img_profile']);
    }

    // Hapus data pengguna berdasarkan ID dari database
    $deleteQuery = "DELETE FROM users WHERE user_id = '$user_id'";
    $deleteResult = mysqli_query($conn, $deleteQuery);

    if ($deleteResult) {
        // Redirect ke halaman admin setelah berhasil menghapus data
        header("Location: halaman_admin.php?success=delete");
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
