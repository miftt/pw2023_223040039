<?php
require '../config.php';
require '../functions.php';
session_start();

?>

<?php if ($product && $categories) : ?>
    <div class="row mt-3">
        <div class="col-md-6">
            <?php $totalProducts = count($products); ?>
            <h5>Total Produk: <span><?= $totalProducts; ?></span></h5>
        </div>
        <div class="col-md-6 d-flex justify-content-md-end">
            <a href="tambah_produk.php" class="btn btn-primary">+ Tambah Produk</a>
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
                            <a href="hapus_produk.php?menu_id=<?= $product['menu_id']; ?>" onclick="return confirm('yakin?')" class="btn btn-danger ml-1"><i class='bx bxs-trash'></i></a>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif ?>