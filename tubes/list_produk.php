<?php
include 'config.php';
session_start();

//Periksa apakah pengguna memiliki akses admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Fungsi untuk mendapatkan data produk dari database
function getProducts()
{
    global $conn;
    $query = "SELECT m.*, c.category_name FROM Menu m
              LEFT JOIN Menu_Category mc ON m.menu_id = mc.menu_id
              LEFT JOIN Category c ON mc.category_id = c.category_id";
    $result = mysqli_query($conn, $query);
    $products = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $products;
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
    <title>Admin Panel</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>

<body>
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
                                <img src=" img/<?= $product['menu_image']; ?>" width="100px">
                            <?php else : ?>
                                <img src="img/default.png" width="70px">
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