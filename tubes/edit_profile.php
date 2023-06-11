<?php
include 'config.php';
session_start();

// Periksa apakah pengguna telah login
if (!isset($_SESSION['username'])) {
    // Jika tidak ada sesi login, arahkan ke halaman login
    header("Location: login.php");
    exit();
}


// Periksa apakah ada parameter user_id yang diterima melalui URL
if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    // Fungsi untuk mendapatkan data pengguna berdasarkan ID dari database
    function getUserById($user_id)
    {
        global $conn;
        $query = "SELECT * FROM users WHERE user_id = '$user_id'";
        $result = mysqli_query($conn, $query);
        $user = mysqli_fetch_assoc($result);
        return $user;
    }

    // Mendapatkan data pengguna berdasarkan ID dari database
    $user = getUserById($user_id);

    // Proses pembaruan data pengguna
    if (isset($_POST['submit'])) {
        $full_name = $_POST['full_name'];
        $email = $_POST['email'];
        $phone_number = $_POST['phone_number'];
        $address = $_POST['address'];
        $tanggal_lahir = $_POST['tanggal_lahir'];

        // Cek apakah password diisi
        if (!empty($_POST['password'])) {
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

            // Update data pengguna ke database termasuk password
            $query = "UPDATE users SET full_name = '$full_name', password = '$password', email = '$email', phone_number = '$phone_number', address = '$address', tgl_lahir = '$tanggal_lahir' WHERE user_id = '$user_id'";
        } else {
            // Update data pengguna ke database tanpa mengubah password
            $query = "UPDATE users SET full_name = '$full_name', email = '$email', phone_number = '$phone_number', address = '$address', tgl_lahir = '$tanggal_lahir'  WHERE user_id = '$user_id'";
        }

        $result = mysqli_query($conn, $query);

        if ($result) {
            // Redirect ke halaman admin setelah berhasil memperbarui data
            header("Location: profile.php?success=edit");
            exit();
        } else {
            // Tampilkan pesan error jika gagal memperbarui data
            echo "Error: " . mysqli_error($conn);
            header("Location: profile.php?success=0");
            exit();
        }
    }
} else {
    // Redirect ke halaman admin jika tidak ada parameter user_id
    header("Location: profile.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Ubah Pengguna</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="icon" type="image/png" sizes="32x32" href="img/favicon/Mif.png" />
</head>

<body style="background-color: #eee">

    <div class="container">
        <h1 class="mt-4">Edit User</h1>
        <form method="POST">
            <input type="hidden" name="id" value="<?= $user['user_id']; ?>">
            <div class="form-group">
                <label for="full_name">Nama Lengkap</label>
                <input type="text" class="form-control" id="full_name" name="full_name" value="<?php echo $user['full_name']; ?>" autofocus>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo $user['email']; ?>">
            </div>
            <div class="form-group">
                <label for="phone_number">No. Telepon</label>
                <input type="text" class="form-control" id="phone_number" name="phone_number" value="<?php echo $user['phone_number']; ?>">
            </div>
            <div class="form-group">
                <label for="address">Alamat</label>
                <textarea class="form-control" id="address" name="address"><?php echo $user['address']; ?></textarea>
            </div>
            <div class="form-group">
                <label for="tanggal_lahir">Tanggal Lahir</label>
                <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" value="<?php echo $user['tgl_lahir']; ?>">
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="profile.php" class="btn btn-secondary">Batal</a>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>

</html>