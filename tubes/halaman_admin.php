<?php
include 'config.php';
session_start();

//Periksa apakah pengguna memiliki akses admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Fungsi untuk mendapatkan data pengguna dari database
function getUsers()
{
    global $conn;
    $query = "SELECT * FROM users";
    $result = mysqli_query($conn, $query);
    $users = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $users;
}

// Mendapatkan data pengguna dari database
$users = getUsers();
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
        <h1 class="mt-5">Admin Panel - Daftar Pengguna</h1>
        <div class="mt-5 d-grid gap-2 d-md-block">
            <a href="index.php" class="btn btn-primary btn-sm">Kembali Ke Halaman Utama</a>
        </div>
        <input type="text" id="searchInput" class="form-control mt-3" placeholder="Cari pengguna...">
        <div class="row mt-3">
            <div class="col-md-6">
                <?php $totalUsers = count($users); ?>
                <h5>Total Pengguna: <span><?= $totalUsers; ?></span></h5>
            </div>
            <div class="col-md-6 d-flex justify-content-md-end">
                <a href="tambah.php" class="btn btn-primary">+ Tambah Pengguna</a>
            </div>
        </div>
        <table class="table mt-1">
            <thead class="thead-light">
                <tr>
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
                                <img src="img/<?php echo $user['img_profile']; ?>" width="100px">
                            <?php else : ?>
                                <img src="img/default.png" width="70px">
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
                                <a href="ubah.php?user_id=<?= $user['user_id']; ?>" class="btn btn-warning">Ubah</a>
                                <a href="hapus.php?user_id=<?= $user['user_id']; ?>" onclick="return confirm('yakin?')" class="btn btn-danger ">Hapus</a>
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