<?php
include 'config.php';
session_start();

// Periksa apakah pengguna memiliki akses admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Proses penambahan data pengguna baru
if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $address = $_POST['address'];
    $saldo = $_POST['saldo'];
    $role = $_POST['role'];

    // Memeriksa apakah username atau email sudah ada di database
    $checkQuery = "SELECT * FROM users WHERE username='$username' OR email='$email'";
    $checkResult = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        // Jika username atau email sudah ada di database, tampilkan pesan error
        echo "Error: Username atau email sudah digunakan.";
        header('Location: tambah.php?success=0');
        exit();
    }

    // Query untuk menambahkan data pengguna baru ke database
    if (!empty($_POST['saldo'])) {
        $saldo = $_POST['saldo'];
    } else {
        $saldo = 0;
    }

    $query = "INSERT INTO users (username, password, full_name, email, phone_number, address, balance, role) VALUES ('$username', '$password', '$full_name', '$email', '$phone_number', '$address', $saldo, '$role')";
    $result = mysqli_query($conn, $query);

    if ($result) {
        // Redirect ke halaman admin setelah berhasil menambahkan data
        header("Location: halaman_admin.php?success=1");
        exit();
    } else {
        // Tampilkan pesan error jika gagal menambahkan data
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Tambah Pengguna</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <h1 class="mt-5">Admin Panel - Tambah Pengguna</h1>
        <?php if (isset($_GET['success']) && $_GET['success'] == 0) { ?>
            <div class="alert alert-danger" role="alert">
                Username atau email sudah digunakan. Silahkan pilih username atau email lain.
            </div>
        <?php } ?>
        <form method="POST">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" required autofocus autocomplete="off">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="mb-3">
                <label for="full_name" class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control" id="full_name" name="full_name" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="phone_number" class="form-label">No. Telepon</label>
                <input type="number" class="form-control" id="phone_number" name="phone_number">
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Alamat</label>
                <textarea class="form-control" id="address" name="address"></textarea>
            </div>
            <div class="mb-3">
                <label for="saldo" class="form-label">Saldo</label>
                <input type="number" maxlength="10" class="form-control" id="saldo" name="saldo">
            </div>
            <div class="mb-3">
                <label for="role" class="form-label">Role</label>
                <select class="form-select" id="role" name="role" required>
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Tambah Pengguna</button>
            <a href="halaman_admin.php" class="btn btn-secondary">Batal</a>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>

</html>