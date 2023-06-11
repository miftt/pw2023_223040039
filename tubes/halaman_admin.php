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

// Variabel untuk mengatur jumlah baris tabel yang ditampilkan
$perPage = isset($_GET['perPage']) ? $_GET['perPage'] : 10;

if (isset($_GET['search'])) {
    $keyword = $_GET['keyword'];
    $query = "SELECT * FROM
                users
              WHERE
                  full_name LIKE '%$keyword%' OR
                  username LIKE '%$keyword%' OR
                  email LIKE '%$keyword%' OR
                  address LIKE '%$keyword%' OR
                  role LIKE '%$keyword%' OR
                  phone_number LIKE '%$keyword%'";
    $users = query($query);
}

// Menghitung total pengguna
$totalUsers = count($users);

// Mengatur jumlah halaman berdasarkan total pengguna dan jumlah baris per halaman
$totalPages = ceil($totalUsers / $perPage);

// Mengambil halaman saat ini dari parameter GET
$currentPage = isset($_GET['page']) ? $_GET['page'] : 1;

// Mengatur batas data yang ditampilkan pada halaman saat ini
$start = ($currentPage - 1) * $perPage;
$end = $start + $perPage;
$users = array_slice($users, $start, $perPage);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
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
                    <a href="cetak_user.php" class="btn-download">
                        <i class='bx bxs-cloud-download'></i>
                        <span class="text">Download PDF</span>
                    </a>
                </div>
            </main>
            <h1>Daftar Users</h1>
            <div class="mt-5 d-grid gap-2 d-md-block">
                <!-- <a href="index.php" class="btn btn-primary btn-sm">Kembali Ke Halaman Utama</a> -->
            </div>
            <div class="row">
                <div class="col-md-6">
                    <form action="" method="GET">
                        <div class="input-group my-3">
                            <input type="text" id="keyword" name="keyword" class="form-control" placeholder="Search user(s).." autofocus autocomplete="off">
                            <button class="btn btn-primary" name="search" type="submit" id="search-button">Search</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-6">
                    <h5>Total Pengguna: <span><?= $totalUsers; ?></span></h5>
                </div>
                <div class="col-md-6 d-flex justify-content-md-end">
                    <a href="tambah.php" class="btn btn-primary">+ Tambah Pengguna</a>
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
            <div id="search-container">
                <?php if ($users) : ?>
                    <table class="table mt-1" style="background-color: #fff">
                        <thead class="thead-light" style="background-color: #fff">
                            <tr style="background-color: #fff">
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
                                            <a href="ubah.php?user_id=<?= $user['user_id']; ?>" class="btn btn-warning"><i class='bx bxs-edit'></i></a>
                                            <a href="#" onclick="deleteUser(<?= $user['user_id']; ?>)" class="btn btn-danger ml-1"><i class='bx bxs-trash'></i></a>
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
                                User not found!
                            </div>
                        </div>
                    </div>
                <?php endif ?>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>
        <script src="js/dashboard.js"></script>
        <script>
            const keyword = document.getElementById("keyword");
            const searchContainer = document.getElementById("search-container");

            // event ketika mengetikan keyword pencarian
            keyword.onkeyup = function() {
                fetch("ajax/user_search.php?keyword=" + keyword.value)
                    .then((response) => response.text())
                    .then((text) => (searchContainer.innerHTML = text));
            };
        </script>
        <script>
            function deleteUser(userId) {
                Swal.fire({
                    title: 'Apakah Anda yakin ingin menghapus pengguna ini?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Hapus',
                    cancelButtonText: 'Batal',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Redirect to the delete page with the user_id parameter
                        window.location.href = `hapus.php?user_id=${userId}`;
                    }
                });
            }
        </script>
        <script>
            <?php if (isset($_GET['success']) && $_GET['success'] == 1) { ?>
                Swal.fire({
                    icon: 'success',
                    title: 'Data user berhasil diperbarui!',
                    showConfirmButton: false,
                    timer: 1500,
                    timerProgressBar: true
                });
            <?php } elseif (isset($_GET['success']) && $_GET['success'] == "add") { ?>
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil menambahkan user baru',
                    showConfirmButton: false,
                    timer: 1500,
                    timerProgressBar: true
                });
            <?php } elseif (isset($_GET['success']) && $_GET['success'] == 0) { ?>
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal user data pengguna!',
                    showConfirmButton: false,
                    timer: 1500,
                    timerProgressBar: true
                });
            <?php } elseif (isset($_GET['success']) && $_GET['success'] == 'delete') { ?>
                Swal.fire({
                    icon: 'success',
                    title: 'user berhasil dihapus!',
                    showConfirmButton: false,
                    timer: 1500,
                    timerProgressBar: true
                });
            <?php } elseif (isset($_GET['error']) && $_GET['error'] == 'delete') { ?>
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal menghapus pengguna!',
                    showConfirmButton: false,
                    timer: 1500,
                    timerProgressBar: true
                });
            <?php } ?>
        </script>


        <!-- <script>
            $(document).ready(function() {
                $('#searchInput').on('keyup', function() {
                    var value = $(this).val().toLowerCase();
                    $('tbody tr').filter(function() {
                        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                    });
                });
            });
        </script> -->

</body>

</html>