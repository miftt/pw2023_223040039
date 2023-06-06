<?php
include 'config.php';
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

// Fungsi untuk mendapatkan data kategori dari database
function getCategories()
{
    global $conn;
    $query = "SELECT * FROM Category";
    $result = mysqli_query($conn, $query);
    $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $categories;
}

// Mendapatkan data kategori dari database
$categories = getCategories();

// Proses update produk
if (isset($_POST['update'])) {
    $menuName = $_POST['menu_name'];
    $menuDescription = $_POST['menu_description'];
    $menuPrice = $_POST['menu_price'];
    $categoryIds = $_POST['category_ids'];

    // Perbarui informasi produk
    $query = "UPDATE Menu SET
              menu_name = '$menuName',
              menu_description = '$menuDescription',
              menu_price = '$menuPrice'
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
        $imageName = $_FILES['menu_image']['name'];
        $imageTmpName = $_FILES['menu_image']['tmp_name'];
        $imageSize = $_FILES['menu_image']['size'];
        $imageError = $_FILES['menu_image']['error'];

        if ($imageError === 0) {
            $uploadPath = 'img/products/';
            $imageExtension = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));
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
    <title>Edit Produk</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h1 class="mt-5">Edit Produk</h1>
        <div class="mt-5 d-grid gap-2 d-md-block">
            <a href="menu.php" class="btn btn-primary btn-sm">Kembali Ke Daftar Produk</a>
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
                <label for="categoryIds">Kategori Produk</label><br>
                <?php foreach ($categories as $category) : ?>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="category<?= $category['category_id']; ?>" name="category_ids[]" value="<?= $category['category_id']; ?>" <?= in_array($category['category_id'], explode(",", $product['category_ids'])) ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="category<?= $category['category_id']; ?>"><?= $category['category_name']; ?></label>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="form-group">
                <label for="menuImage">Gambar Produk</label>
                <input type="file" class="form-control-file" id="menuImage" name="menu_image" value="<?= $product['menu_image']; ?>" required>
            </div>
            <button type="submit" name="update" class="btn btn-primary">Update</button>
            <a href="list_produk.php" class="btn btn-secondary">Batal</a>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

</body>

</html>