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

    // Fungsi untuk mendapatkan data pengguna berdasarkan ID dari database
    function getUserById($user_id)
    {
        global $conn;
        $query = "SELECT * FROM users WHERE user_id = '$user_id'";
        $result = mysqli_query($conn, $query);
        $user = mysqli_fetch_assoc($result);
        return $user;
    }

    // Mendapatkan data pengguna berdasarkan ID dari database
    $user = getUserById($user_id);

    // Proses pembaruan data pengguna
    if (isset($_POST['submit'])) {
        $username = $_POST['username'];
        $full_name = $_POST['full_name'];
        $email = $_POST['email'];
        $phone_number = $_POST['phone_number'];
        $address = $_POST['address'];
        $saldo = $_POST['saldo'];
        $role = $_POST['role'];

        // Update data pengguna ke database
        $query = "UPDATE users SET username = '$username', full_name = '$full_name', email = '$email', phone_number = '$phone_number', address = '$address', balance = '$saldo', role = '$role' WHERE user_id = '$user_id'";
        $result = mysqli_query($conn, $query);

        if ($result) {
            // Redirect ke halaman admin setelah berhasil memperbarui data
            header("Location: halaman_admin.php?success=1");
            exit();
        } else {
            // Tampilkan pesan error jika gagal memperbarui data
            echo "Error: " . mysqli_error($conn);
            header("Location: halaman_admin.php?success=0");
            exit();
        }
    }
} else {
    // Redirect ke halaman admin jika tidak ada parameter user_id
    header("Location: halaman_admin.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Ubah Pengguna</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link href="https://unpkg.com/sweetalert2@11.0.18/dist/sweetalert2.min.css" rel="stylesheet">
    <?php require 'views/utils/header.php' ?>
    <link rel="icon" type="image/png" sizes="32x32" href="img/favicon/Mif.png" />
</head>

<body style="background-color: #eee">

    <!-- SIDEBAR -->
    <section id="sidebar">
        <a href="#" class="brand">
            <i class='bx bxs-server'></i>
            <span class="text">GreenBites</span>
        </a>
        <ul class="side-menu top">
            <li>
                <a href="dashboards.php">
                    <i class='bx bxs-dashboard'></i>
                    <span class="text">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="halaman_admin.php">
                    <i class='bx bxs-user'></i>
                    <span class="text">Daftar Users</span>
                </a>
            </li>
            <li class="active">
                <a href="list_produk.php">
                    <i class='bx bxs-cart'></i>
                    <span class="text">Daftar Products</span>
                </a>
            </li>
        </ul>
        <ul class="side-menu">
            <li>
                <a href="logout.php" class="logout">
                    <i class='bx bxs-log-out-circle'></i>
                    <span class="text">Logout</span>
                </a>
            </li>
        </ul>
    </section>
    <!-- SIDEBAR -->



    <!-- CONTENT -->
    <section id="content">
        <!-- NAVBAR -->
        <nav>
            <i class='bx bx-menu'></i>
            <a href="index.php" class="home-link">
                <i class='bx bx-home'></i>
            </a>
            <form action="#">
                <div class="form-input">
                </div>
            </form>
            <input type="checkbox" id="switch-mode" hidden>
            <a href="#" class="notification">
            </a>
            <a href="#" class="profile">
                <img src="img/users/<?php echo $_SESSION['img_profile']; ?>">
            </a>
        </nav>
        <!-- NAVBAR -->

        <div class="ml-4 mr-4">
            <h1 class="mt-4">Edit User</h1>
            <form method="POST">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" id="username" name="username" value="<?php echo $user['username']; ?>">
                </div>
                <div class="form-group">
                    <label for="full_name">Nama Lengkap</label>
                    <input type="text" class="form-control" id="full_name" name="full_name" value="<?php echo $user['full_name']; ?>">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo $user['email']; ?>">
                </div>
                <div class="form-group">
                    <label for="phone_number">No. Telepon</label>
                    <input type="text" class="form-control" id="phone_number" name="phone_number" value="<?php echo $user['phone_number']; ?>">
                </div>
                <div class="form-group">
                    <label for="address">Alamat</label>
                    <textarea class="form-control" id="address" name="address"><?php echo $user['address']; ?></textarea>
                </div>
                <div class="form-group mb-3">
                    <label for="saldo">Saldo</label>
                    <textarea class="form-control" id="saldo" name="saldo"><?php echo $user['balance']; ?></textarea>
                </div>
                <div class="input-group mb-5">
                    <label class=" input-group-text" for="role">Role</label>
                    <select class="form-select" id="role" name="role" required>
                        <option value="user" <?php if ($user['role'] === 'user') echo 'selected'; ?>>User</option>
                        <option value="admin" <?php if ($user['role'] === 'admin') echo 'selected'; ?>>Admin</option>
                    </select>
                </div>

                <button type="submit" name="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="halaman_admin.php" class="btn btn-secondary">Batal</a>
            </form>
        </div>

        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
        <script src="js/dashboard.js"></script>
</body>

</html>