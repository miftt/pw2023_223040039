<?php
require '../config.php';
require '../functions.php';
session_start();

// Periksa apakah pengguna memiliki akses admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}
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
?>
<?php
if ($users) : ?>
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
                            <a href="hapus.php?user_id=<?= $user['user_id']; ?>" onclick="return confirm('yakin?')" class="btn btn-danger ml-1"><i class='bx bxs-trash'></i></a>
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