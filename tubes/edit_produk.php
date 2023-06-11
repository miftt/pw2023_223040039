<?php
include 'config.php';
require 'functions.php';
session_start();

// Periksa apakah pengguna memiliki akses admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Periksa apakah ada parameter menu_id yang dikirimkan melalui URL
if (!isset($_GET['menu_id'])) {
    header("Location: menu.php");
    exit();
}

$menuId = $_GET['menu_id'];

// Periksa apakah produk dengan menu_id yang diberikan ada di database
$query = "SELECT m.*, GROUP_CONCAT(c.category_id) as category_ids
          FROM Menu m
          LEFT JOIN Menu_Category mc ON m.menu_id = mc.menu_id
          LEFT JOIN Category c ON mc.category_id = c.category_id
          WHERE m.menu_id = $menuId
          GROUP BY m.menu_id";
$result = mysqli_query($conn, $query);
$product = mysqli_fetch_assoc($result);

// Periksa apakah produk dengan menu_id yang diberikan ada di database
if (!$product) {
    header("Location: menu.php");
    exit();
}

// Mendapatkan data kategori dari database
$categories = getCategories();

// Proses update produk
if (isset($_POST['update'])) {
    $menuName = $_POST['menu_name'];
    $menuDescription = $_POST['menu_description'];
    $menuPrice = $_POST['menu_price'];
    $menuQuantity = $_POST['menu_quantity'];
    $categoryIds = $_POST['category_ids'];

    // Perbarui informasi produk
    $query = "UPDATE Menu SET
              menu_name = '$menuName',
              menu_description = '$menuDescription',
              menu_price = '$menuPrice',
              quantity = $menuQuantity
              WHERE menu_id = $menuId";
    mysqli_query($conn, $query);

    // Hapus semua kategori produk
    $deleteQuery = "DELETE FROM Menu_Category WHERE menu_id = $menuId";
    mysqli_query($conn, $deleteQuery);

    // Tambahkan kategori baru ke produk
    foreach ($categoryIds as $categoryId) {
        $insertQuery = "INSERT INTO Menu_Category (menu_id, category_id) VALUES ($menuId, $categoryId)";
        mysqli_query($conn, $insertQuery);
    }

    // Proses upload gambar jika ada gambar yang dipilih
    if ($_FILES['menu_image']['name']) {
        $allowedFormats = array('jpeg', 'jpg', 'png');
        $maxFileSize = 4 * 1024 * 1024; // 4MB

        $imageName = $_FILES['menu_image']['name'];
        $imageTmpName = $_FILES['menu_image']['tmp_name'];
        $imageSize = $_FILES['menu_image']['size'];
        $imageError = $_FILES['menu_image']['error'];

        // Periksa apakah format file yang diunggah sesuai
        $imageExtension = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));
        if (!in_array($imageExtension, $allowedFormats)) {
            echo "<script>
                    window.location.href = 'list_produk.php?error=format';
                 </script>";
            exit();
        }

        // Periksa ukuran file yang diunggah
        if ($imageSize > $maxFileSize) {
            echo "<script>
                    window.location.href = 'list_produk.php?error=size';
                 </script>";
            exit();
        }

        if ($imageError === 0) {
            $uploadPath = 'img/products/';
            $newImageName = uniqid('menu_') . '.' . $imageExtension;
            $uploadFilePath = $uploadPath . $newImageName;

            if (move_uploaded_file($imageTmpName, $uploadFilePath)) {
                // Hapus gambar lama jika ada
                if (!empty($product['menu_image'])) {
                    unlink($uploadPath . $product['menu_image']);
                }

                // Perbarui nama gambar produk di database
                $query = "UPDATE Menu SET menu_image = '$newImageName' WHERE menu_id = $menuId";
                mysqli_query($conn, $query);
            }
        }
    }


    // Redirect ke halaman menu.php setelah update berhasil
    header("Location: list_produk.php?success=1");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk</title>
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
            <h1 class="mt-5">Edit Produk</h1>
            <div class="mt-5 d-grid gap-2 d-md-block">
            </div>
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="menuName">Nama Produk</label>
                    <input type="text" class="form-control" id="menuName" name="menu_name" value="<?= $product['menu_name']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="menuDescription">Deskripsi Produk</label>
                    <textarea class="form-control" id="menuDescription" name="menu_description" rows="3" required><?= $product['menu_description']; ?></textarea>
                </div>
                <div class="form-group">
                    <label for="menuPrice">Harga Produk</label>
                    <input type="text" class="form-control" id="menuPrice" name="menu_price" value="<?= $product['menu_price']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="menuPrice">Quantity</label>
                    <input type="text" class="form-control" id="menuQuantity" name="menu_quantity" value="<?= $product['quantity']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="categoryIds">Kategori Produk</label><br>
                    <?php foreach ($categories as $category) : ?>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="category<?= $category['category_id']; ?>" name="category_ids[]" value="<?= $category['category_id']; ?>" <?= in_array($category['category_id'], explode(",", $product['category_ids'])) ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="category<?= $category['category_id']; ?>"><?= $category['category_name']; ?></label>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="form-group">
                    <label for="menuImage">Gambar Produk</label>
                    <br>
                    <img src="<?= 'img/products/' . $product['menu_image']; ?>" alt="Gambar Produk" class="img-fluid" id="previewImage" width="150px">
                    <input type="file" class="form-control-file mt-2" id="menuImage" name="menu_image" onchange="previewFile()">
                </div>
                <button type="submit" name="update" class="btn btn-primary">Update</button>
                <a href="list_produk.php" class="btn btn-secondary">Batal</a>
            </form>
        </div>

        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
        <script src="js/dashboard.js"></script>
        <script>
            function previewFile() {
                const preview = document.getElementById('previewImage');
                const fileInput = document.getElementById('menuImage');
                const file = fileInput.files[0];
                const reader = new FileReader();

                reader.onloadend = function() {
                    preview.src = reader.result;
                }

                if (file) {
                    reader.readAsDataURL(file);
                } else {
                    preview.src = "<?= $product['menu_image']; ?>";
                }
            }
        </script>
</body>

</html>