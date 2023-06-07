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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require 'views/utils/header.php' ?>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>

<body>

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
            <li class="active">
                <a href="halaman_admin.php">
                    <i class='bx bxs-user'></i>
                    <span class="text">Daftar Users</span>
                </a>
            </li>
            <li>
                <a href="list_produk.php">
                    <i class='bx bxs-cart'></i>
                    <span class="text">Daftar Products</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class='bx bxs-message-dots'></i>
                    <span class="text">Message</span>
                </a>
            </li>
        </ul>
        <ul class="side-menu">
            <li>
                <a href="#">
                    <i class='bx bxs-cog'></i>
                    <span class="text">Settings</span>
                </a>
            </li>
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
            <a href="#" class="nav-link">Categories</a>
            <form action="#">
                <div class="form-input">
                    <input type="search" placeholder="Search...">
                    <button type="submit" class="search-btn"><i class='bx bx-search'></i></button>
                </div>
            </form>
            <input type="checkbox" id="switch-mode" hidden>
            <label for="switch-mode" class="switch-mode"></label>
            <a href="#" class="notification">
                <i class='bx bxs-bell'></i>
                <span class="num">8</span>
            </a>
            <a href="#" class="profile">
                <img src="img/users/<?php echo $_SESSION['img_profile']; ?>">
            </a>
        </nav>
        <!-- NAVBAR -->
        <div class="container">
            <h1 class="mt-5">Admin Panel - Daftar Pengguna</h1>
            <div class="mt-5 d-grid gap-2 d-md-block">
                <a href="index.php" class="btn btn-primary btn-sm">Kembali Ke Halaman Utama</a>
            </div>
            <input type="text" id="searchInput" class="form-control mt-3" placeholder="Cari pengguna...">
            <div class="row mt-3">
                <div class="col-md-6">
                    <?php $totalUsers = count($users); ?>
                    <h5>Total Pengguna: <span><?= $totalUsers; ?></span></h5>
                </div>
                <div class="col-md-6 d-flex justify-content-md-end">
                    <a href="tambah.php" class="btn btn-primary">+ Tambah Pengguna</a>
                </div>
            </div>
            <?php if ($users) : ?>
                <table class="table mt-1">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Image Profile</th>
                            <th scope="col">Username</th>
                            <th scope="col">Nama Lengkap</th>
                            <th scope="col">Email</th>
                            <th scope="col">No. Telepon</th>
                            <th scope="col">Alamat</th>
                            <th scope="col">Saldo</th>
                            <th scope="col">Role</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1;
                        foreach ($users as $user) : ?>
                            <tr>
                                <th scope="row"><?= $i++; ?></th>
                                <td>
                                    <?php if (!empty($user['img_profile'])) : ?>
                                        <img src="img/users/<?php echo $user['img_profile']; ?>" width="100px">
                                    <?php else : ?>
                                        <img src="img/users/default.png" width="70px">
                                    <?php endif; ?>
                                </td>
                                <td><?php echo $user['username']; ?></td>
                                <td><?php echo $user['full_name']; ?></td>
                                <td><?php echo $user['email']; ?></td>
                                <td><?php echo $user['phone_number']; ?></td>
                                <td><?php echo $user['address']; ?></td>
                                <td><?php echo $user['balance']; ?></td>
                                <td><?php echo $user['role']; ?></td>
                                <td>
                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        <a href="ubah.php?user_id=<?= $user['user_id']; ?>" class="btn btn-warning">Ubah</a>
                                        <a href="hapus.php?user_id=<?= $user['user_id']; ?>" onclick="return confirm('yakin?')" class="btn btn-danger ">Hapus</a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else : ?>
                <div class="row">
                    <div class="col-md-6">
                        <div class="alert alert-danger" role="alert">
                            Student not found!
                        </div>
                    </div>
                </div>
            <?php endif ?>
        </div>

        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
        <script src="js/dashboard.js"></script>
        <script>
            $(document).ready(function() {
                $('#searchInput').on('keyup', function() {
                    var value = $(this).val().toLowerCase();
                    $('tbody tr').filter(function() {
                        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                    });
                });
            });
        </script>

</body>

</html>