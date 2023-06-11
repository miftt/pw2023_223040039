<?php
include 'config.php';
session_start();
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Memproses data login saat tombol Sign In diklik
if (isset($_POST['signin'])) {
    // Mendapatkan data dari formulir login
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query untuk mengambil data pengguna berdasarkan username
    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);

        if (password_verify($password, $user['password'])) {
            // Login berhasil, simpan data sesi
            $_SESSION['username'] = $user['username'];
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['img_profile'] = $user['img_profile'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['session_id'] = session_id();
            $_SESSION['session_start'] = time();
            $_SESSION['session_expire'] = $_SESSION['session_start'] + (60 * 30); // Sesinya akan kadaluarsa dalam 30 menit (60 detik * 30 menit)

            // Arahkan ke halaman profile.php sesuai dengan peran (admin atau user)
            if ($user['role'] == 'admin') {
                header("Location: index.php");
            } else {
                header("Location: index.php");
            }
            exit();
        } else {
            // Password tidak sesuai
            header("Location: login.php?login_error=1");
            exit();
        }
    } else {
        // Username tidak ditemukan
        header("Location: login.php?login_error=1");
        exit();
    }
}


mysqli_close($conn);
