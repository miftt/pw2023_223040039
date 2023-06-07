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
    $categories = $_POST['categories'];

    // Upload gambar produk ke folder img
    $targetDir = "img/products/";
    $targetFile = $targetDir . basename($_FILES['menuImage']['name']);
    move_uploaded_file($_FILES['menuImage']['tmp_name'], $targetFile);

    // Menyimpan data produk ke database
    $query = "INSERT INTO Menu (menu_name, menu_description, menu_price, menu_image) VALUES ('$menuName', '$menuDescription', $menuPrice, '$menuImage')";
    mysqli_query($conn, $query);

    // Mendapatkan ID produk yang baru ditambahkan
    $menuId = mysqli_insert_id($conn);

    // Menyimpan data kategori produk ke database
    foreach ($categories as $categoryId) {
        $query = "INSERT INTO Menu_Category (menu_id, category_id) VALUES ($menuId, $categoryId)";
        mysqli_query($conn, $query);
    }

    // Redirect ke halaman menu.php
    header("Location: menu.php");
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
</head>

<body>
    <div class="container">
        <h1 class="mt-5">Tambah Produk</h1>
        <div class="mt-5 d-grid gap-2 d-md-block">
            <a href="list_produk.php" class="btn btn-primary btn-sm">Kembali ke dashboard</a>
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
                <label for="menuImage">Gambar Produk</label>
                <input type="file" class="form-control-file" id="menuImage" name="menuImage" required>
            </div>
            <div class="form-group">
                <label for="menuCategories">Kategori Produk</label>
                <select multiple class="form-control" id="menuCategories" name="categories[]" required>
                    <?php foreach ($categories as $category) : ?>
                        <option value="<?= $category['category_id']; ?>"><?= $category['category_name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Tambah</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>

</html>