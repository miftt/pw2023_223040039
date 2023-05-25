<?php
include 'config.php';
session_start();
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Memproses data login saat tombol Sign In diklik
if (isset($_POST['signin'])) {
    // Mendapatkan data dari formulir login
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Membuat query untuk memeriksa kecocokan username dan password pada tabel "users"
    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        // Login berhasil, simpan data sesi
        $_SESSION['username'] = $username;
        $_SESSION['session_id'] = session_id();
        $_SESSION['session_start'] = time();
        $_SESSION['session_expire'] = $_SESSION['session_start'] + (60 * 30); // Sesinya akan kadaluarsa dalam 30 menit (60 detik * 30 menit)

        // Arahkan ke halaman profile.php
        header("Location: profile.php");
        exit();
    } else {
        // Login gagal, tampilkan pesan error
        $error_message = "Username or password is incorrect.";
    }
}

mysqli_close($conn);
