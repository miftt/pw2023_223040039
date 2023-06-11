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

$perPage = isset($_GET['perPage']) ? $_GET['perPage'] : 10;
// Menghitung total pengguna
$totalProducts = count($products);

// Mengatur jumlah halaman berdasarkan total pengguna dan jumlah baris per halaman
$totalPages = ceil($totalProducts / $perPage);

// Mengambil halaman saat ini dari parameter GET
$currentPage = isset($_GET['page']) ? $_GET['page'] : 1;

// Mengatur batas data yang ditampilkan pada halaman saat ini
$start = ($currentPage - 1) * $perPage;
$end = $start + $perPage;
$products = array_slice($products, $start, $perPage);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
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
            <main>
                <div class="head-title">
                    <a href="cetak_produk.php" class="btn-download">
                        <i class='bx bxs-cloud-download'></i>
                        <span class="text">Download PDF</span>
                    </a>
                </div>
            </main>
            <h1>Daftar Products</h1>
            <div class="mt-5 d-grid gap-2 d-md-block">
                <!-- <a href="index.php" class="btn btn-primary btn-sm">Kembali Ke Halaman Utama</a> -->
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="input-group my-3">
                        <input type="text" id="searchInput" name="keyword" class="form-control" placeholder="Search product(s).." autofocus autocomplete="off">
                        <button class="btn btn-primary">Search</button>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-6">
                    <?php $totalProducts = count($products); ?>
                    <h5>Total Produk: <span><?= $totalProducts; ?></span></h5>
                </div>
                <div class="col-md-6 d-flex justify-content-md-end">
                    <a href="tambah_produk.php" class="btn btn-primary">+ Tambah Produk</a>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-6">
                    <label for="perPageSelect">Tampilkan: </label>
                    <select id="perPageSelect" name="perPage" class="form-select" onchange="this.options[this.selectedIndex].value && (window.location = '?perPage=' + this.options[this.selectedIndex].value)">
                        <option value="10" <?php echo $perPage == 10 ? 'selected' : ''; ?>>10</option>
                        <option value="20" <?php echo $perPage == 20 ? 'selected' : ''; ?>>20</option>
                        <option value="50" <?php echo $perPage == 50 ? 'selected' : ''; ?>>50</option>
                    </select>
                </div>
                <div class="col-md-6 d-flex justify-content-md-end">
                    <ul class="pagination justify-content-end">
                        <?php if ($currentPage > 1) : ?>
                            <li class="page-item">
                                <a class="page-link" href="?page=<?php echo $currentPage - 1; ?>&perPage=<?php echo $perPage; ?>">Previous</a>
                            </li>
                        <?php endif; ?>

                        <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                            <li class="page-item <?php if ($i == $currentPage) echo 'active'; ?>">
                                <a class="page-link" href="?page=<?php echo $i; ?>&perPage=<?php echo $perPage; ?>"><?php echo $i; ?></a>
                            </li>
                        <?php endfor; ?>

                        <?php if ($currentPage < $totalPages) : ?>
                            <li class="page-item">
                                <a class="page-link" href="?page=<?php echo $currentPage + 1; ?>&perPage=<?php echo $perPage; ?>">Next</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
            <table class="table mt-1" style="background-color: #fff">
                <thead class="thead-light">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Gambar</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Deskripsi</th>
                        <th scope="col">Harga</th>
                        <th scope="col">Kategori</th>
                        <th scope="col">Quantity</th>
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
                            <td><?php echo $product['quantity']; ?></td>
                            <td>
                                <div class="d-grid gap-2 d-md-flex">
                                    <a href="edit_produk.php?menu_id=<?= $product['menu_id']; ?>" class="btn btn-warning"><i class='bx bxs-edit'></i></a>
                                    <a href="#" onclick="deleteProduct(<?= $product['menu_id']; ?>)" class="btn btn-danger ml-1"><i class='bx bxs-trash'></i></a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="row">
                <div class="col-md-6">
                    <div id="noResults" class="alert alert-danger" style="display: none" role="alert">
                        Product not found!
                    </div>
                </div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>
        <script src="js/dashboard.js"></script>
        <script>
            $(document).ready(function() {
                $('#searchInput').on('keyup', function() {
                    var value = $(this).val().toLowerCase();
                    $('tbody tr').filter(function() {
                        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                    });

                    // Tampilkan pesan jika tidak ada produk yang ditemukan
                    if ($('tbody tr:visible').length === 0) {
                        $('#noResults').show();
                    } else {
                        $('#noResults').hide();
                    }
                });
            });
        </script>
        <script>
            function deleteProduct(menuId) {
                Swal.fire({
                    title: 'Apakah Anda yakin ingin menghapus product ini?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Hapus',
                    cancelButtonText: 'Batal',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Redirect to the delete page with the user_id parameter
                        window.location.href = `hapus_produk.php?menu_id=${menuId}`;
                    }
                });
            }
        </script>
        <script>
            <?php if (isset($_GET['success']) && $_GET['success'] == 1) { ?>
                Swal.fire({
                    icon: 'success',
                    title: 'Produk berhasil diperbarui!',
                    showConfirmButton: false,
                    timer: 1500,
                    timerProgressBar: true
                });
            <?php } elseif (isset($_GET['success']) && $_GET['success'] == "add") { ?>
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil menambahkan produk baru',
                    showConfirmButton: false,
                    timer: 1500,
                    timerProgressBar: true
                });
            <?php } elseif (isset($_GET['success']) && $_GET['success'] == 0) { ?>
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal data product tidak ditemukan!',
                    showConfirmButton: false,
                    timer: 1500,
                    timerProgressBar: true
                });
            <?php } elseif (isset($_GET['success']) && $_GET['success'] == 'delete') { ?>
                Swal.fire({
                    icon: 'success',
                    title: 'produk berhasil dihapus!',
                    showConfirmButton: false,
                    timer: 1500,
                    timerProgressBar: true
                });
            <?php } elseif (isset($_GET['error']) && $_GET['error'] == 'delete') { ?>
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal menghapus produk!',
                    showConfirmButton: false,
                    timer: 1500,
                    timerProgressBar: true
                });
            <?php } elseif (isset($_GET['error']) && $_GET['error'] == 'size') { ?>
                Swal.fire({
                    icon: 'error',
                    title: 'Ukuran Gambar Terlalu Besar, Max 4MB!',
                    showConfirmButton: false,
                    timer: 4000,
                    timerProgressBar: true
                });
            <?php } elseif (isset($_GET['error']) && $_GET['error'] == 'format') { ?>
                Swal.fire({
                    icon: 'error',
                    title: 'Format file tidak didukung. Hanya file JPEG, JPG, dan PNG yang diperbolehkan!',
                    showConfirmButton: false,
                    timer: 4000,
                    timerProgressBar: true
                });
            <?php } ?>
        </script>
</body>

</html>