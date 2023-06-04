<?php
// Koneksi ke database
include 'config.php';

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Memproses data pendaftaran saat tombol Sign Up diklik
if (isset($_POST['submit'])) {
    // Memeriksa apakah tombol Sign Up yang diklik
    if ($_POST['submit'] == 'signup') {
        // Mendapatkan data dari formulir pendaftaran
        $username = htmlspecialchars($_POST["username"]);
        $name = htmlspecialchars($_POST['fullname']);
        $phoneNumber = htmlspecialchars($_POST['phonenumber']);
        $email = htmlspecialchars($_POST['email']);
        $password = $_POST['password'];
        $tgl_lahir = $_POST['tgl_lahir'];
        $kelamin = $_POST['jenis_kelamin'];

        // Memeriksa apakah username atau email sudah ada di database
        $checkQuery = "SELECT * FROM users WHERE username='$username' OR email='$email'";
        $checkResult = mysqli_query($conn, $checkQuery);

        if (mysqli_num_rows($checkResult) > 0) {
            // Jika username atau email sudah ada di database, tampilkan pesan error
            $error_message = "Username atau email sudah digunakan. Silakan pilih username atau email lain.";
            header("Location: login.php?success=0");
            exit();
        } else {
            // Membuat query untuk menyimpan data pengguna ke dalam tabel "users"
            $sql = "INSERT INTO users (username, password, full_name, email, phone_number, address, jenis_kelamin, tgl_lahir, balance,role)
                    VALUES ('$username', '$password', '$name', '$email', '$phoneNumber', '', '$kelamin', '$tgl_lahir', 0,'user')";

            if (mysqli_query($conn, $sql)) {
                header("Location: login.php?success=1");
                exit();
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                exit();
            }
        }
    }
}

mysqli_close($conn);
