<?php
include 'config.php';
require 'functions.php';
session_start();

//Periksa apakah pengguna memiliki akses admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Mendapatkan data produk dan kategori dari database
$products = getProducts();
$categories = getCategories();
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
            <h1 class="mt-5">Admin Panel - Daftar Produk</h1>
            <div class="mt-5 d-grid gap-2 d-md-block">
                <a href="index.php" class="btn btn-primary btn-sm">Kembali Ke Halaman Utama</a>
            </div>
            <input type="text" id="searchInput" class="form-control mt-3" placeholder="Cari produk...">
            <div class="row mt-3">
                <div class="col-md-6">
                    <?php $totalProducts = count($products); ?>
                    <h5>Total Produk: <span><?= $totalProducts; ?></span></h5>
                </div>
                <div class="col-md-6 d-flex justify-content-md-end">
                    <a href="tambah_produk.php" class="btn btn-primary">+ Tambah Produk</a>
                </div>
            </div>
            <table class="table mt-1">
                <thead class="thead-light">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Gambar</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Deskripsi</th>
                        <th scope="col">Harga</th>
                        <th scope="col">Kategori</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1;
                    foreach ($products as $product) : ?>
                        <tr>
                            <th scope="row"><?= $i++; ?></th>
                            <td>
                                <?php if (!empty($product['menu_image'])) : ?>
                                    <img src=" img/products/<?= $product['menu_image']; ?>" width="100px">
                                <?php else : ?>
                                    <img src="img/users/default.png" width="70px">
                                <?php endif; ?>
                            </td>
                            <td><?php echo $product['menu_name']; ?></td>
                            <td><?php echo $product['menu_description']; ?></td>
                            <td><?php echo $product['menu_price']; ?></td>
                            <td><?php echo $product['category_name']; ?></td>
                            <td>
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <a href="edit_produk.php?menu_id=<?= $product['menu_id']; ?>" class="btn btn-warning">Ubah</a>
                                    <a href="hapus_produk.php?menu_id=<?= $product['menu_id']; ?>" onclick="return confirm('Yakin ingin menghapus produk ini?')" class="btn btn-danger">Hapus</a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
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