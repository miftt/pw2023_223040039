<?php
include 'config.php';
session_start();

//Periksa apakah pengguna memiliki akses admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
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
        $username = $_POST['username'];
        $full_name = $_POST['full_name'];
        $email = $_POST['email'];
        $phone_number = $_POST['phone_number'];
        $address = $_POST['address'];
        $saldo = $_POST['saldo'];
        $role = $_POST['role'];

        // Update data pengguna ke database
        $query = "UPDATE users SET username = '$username', full_name = '$full_name', email = '$email', phone_number = '$phone_number', address = '$address', balance = '$saldo', role = '$role' WHERE user_id = '$user_id'";
        $result = mysqli_query($conn, $query);

        if ($result) {
            // Redirect ke halaman admin setelah berhasil memperbarui data
            header("Location: halaman_admin.php");
            exit();
        } else {
            // Tampilkan pesan error jika gagal memperbarui data
            echo "Error: " . mysqli_error($conn);
        }
    }
} else {
    // Redirect ke halaman admin jika tidak ada parameter user_id
    header("Location: halaman_admin.php");
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <h1 class="mt-4">Admin Panel - Ubah Pengguna</h1>
        <form method="POST">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" value="<?php echo $user['username']; ?>">
            </div>
            <div class="form-group">
                <label for="full_name">Nama Lengkap</label>
                <input type="text" class="form-control" id="full_name" name="full_name" value="<?php echo $user['full_name']; ?>">
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
            <div class="form-group mb-3">
                <label for="saldo">Saldo</label>
                <textarea class="form-control" id="saldo" name="saldo"><?php echo $user['balance']; ?></textarea>
            </div>
            <!-- <div class="form-group">
                <label for="role">Role</label>
                <br />
                <select name="role" require>
                    <option value="user">user</option>
                    <option value="admin">admin</option>
                </select>
            </div> -->
            <div class="input-group mb-5">
                <label class=" input-group-text" for="role">Role</label>
                <select class="form-select" id="role" name="role" required>
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                </select>
            </div>

            <button type="submit" name="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="halaman_admin.php" class="btn btn-secondary">Batal</a>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js" integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS" crossorigin="anonymous"></script>
</body>

</html>