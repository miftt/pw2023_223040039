<?php
include 'config.php';

// Mendapatkan data produk dan kategorinya dari database
$query = "SELECT Menu.*, GROUP_CONCAT(Category.category_name SEPARATOR ', ') AS categories
          FROM Menu
          LEFT JOIN Menu_Category ON Menu.menu_id = Menu_Category.menu_id
          LEFT JOIN Category ON Menu_Category.category_id = Category.category_id
          GROUP BY Menu.menu_id";
$result = mysqli_query($conn, $query);
$products = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h1 class="mt-5">Menu</h1>
        <div class="mt-5 d-grid gap-2 d-md-block">
            <a href="tambah_produk.php" class="btn btn-primary btn-sm">Tambah Produk</a>
            <a href="list_produk.php" class="btn btn-primary btn-sm">Dashboard list Produk</a>
        </div>
        <div class="row mt-5">
            <?php foreach ($products as $product) : ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="img/products/<?= $product['menu_image']; ?>" class="card-img-top" alt="Product Image">
                        <div class="card-body">
                            <h5 class="card-title"><?= $product['menu_name']; ?></h5>
                            <p class="card-text"><?= $product['menu_description']; ?></p>
                            <p class="card-text">Harga: <?= $product['menu_price']; ?></p>
                            <p class="card-text">Kategori: <?= $product['categories']; ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>

</html>