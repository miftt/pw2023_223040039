<?php
include 'config.php';
session_start();

//Periksa apakah pengguna memiliki akses admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Mendapatkan data kategori dari database
$query = "SELECT * FROM Category";
$result = mysqli_query($conn, $query);
$categories = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Proses penambahan produk
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $menuName = $_POST['menuName'];
    $menuDescription = $_POST['menuDescription'];
    $menuPrice = $_POST['menuPrice'];
    $menuImage = $_FILES['menuImage']['name'];
    $menuQuantity = $_POST['menuQuantity'];
    $categories = $_POST['categories'];

    // Memeriksa format file gambar
    $allowedFormats = array('jpg', 'jpeg', 'png');
    $fileExtension = pathinfo($_FILES['menuImage']['name'], PATHINFO_EXTENSION);
    if (!in_array($fileExtension, $allowedFormats)) {
        header("Location: list_produk.php?error=format");
        exit();
    }

    // Memeriksa ukuran file gambar
    $maxFileSize = 4 * 1024 * 1024; // 4MB
    if ($_FILES['menuImage']['size'] > $maxFileSize) {
        header("Location: list_produk.php?error=size");
        exit();
    }

    // Upload gambar produk ke folder img
    $targetDir = "img/products/";
    $targetFile = $targetDir . basename($_FILES['menuImage']['name']);
    move_uploaded_file($_FILES['menuImage']['tmp_name'], $targetFile);

    // Menyimpan data produk ke database
    $query = "INSERT INTO Menu (menu_name, menu_description, menu_price, menu_image, quantity) VALUES ('$menuName', '$menuDescription', $menuPrice, '$menuImage', $menuQuantity)";
    mysqli_query($conn, $query);

    // Mendapatkan ID produk yang baru ditambahkan
    $menuId = mysqli_insert_id($conn);

    // Menyimpan data kategori produk ke database
    foreach ($categories as $categoryId) {
        $query = "INSERT INTO Menu_Category (menu_id, category_id) VALUES ($menuId, $categoryId)";
        mysqli_query($conn, $query);
    }

    // Redirect ke halaman menu.php
    header("Location: list_produk.php?success=add");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk</title>
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
            <h1 class="mt-5">Tambah Produk</h1>
            <div class="mt-5 d-grid gap-2 d-md-block">
            </div>
            <form method="POST" enctype="multipart/form-data" class="mt-5">
                <div class="form-group">
                    <label for="menuName">Nama Produk</label>
                    <input type="text" class="form-control" id="menuName" name="menuName" required>
                </div>
                <div class="form-group">
                    <label for="menuDescription">Deskripsi Produk</label>
                    <textarea class="form-control" id="menuDescription" name="menuDescription" required></textarea>
                </div>
                <div class="form-group">
                    <label for="menuPrice">Harga Produk</label>
                    <input type="number" class="form-control" id="menuPrice" name="menuPrice" step="0.01" required>
                </div>
                <div class="form-group">
                    <label for="menuQuantity">Quantity</label>
                    <input type="number" class="form-control" id="menuQuantity" name="menuQuantity" required>
                </div>
                <div class="form-group">
                    <label for="menuImage">Gambar Produk</label>
                    <input type="file" class="form-control-file" id="menuImage" name="menuImage" required>
                </div>
                <div class="form-group">
                    <label for="menuCategories">Kategori Produk</label>
                    <select class="form-select" id="menuCategories" name="categories[]" required>
                        <?php foreach ($categories as $category) : ?>
                            <option value="<?= $category['category_id']; ?>"><?= $category['category_name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Tambah</button>
                <a href="list_produk.php" class="btn btn-secondary">Batal</a>
            </form>
        </div>

        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
        <script src="js/dashboard.js"></script>
</body>

</html>