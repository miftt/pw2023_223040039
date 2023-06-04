<?php
include 'config.php';
session_start();
// Mengatur path gambar default
$defaultImage = 'path/to/img/default.png';

// Memeriksa apakah $image memiliki nilai atau tidak
if (empty($image)) {
    // Jika $image kosong, gunakan gambar default
    $image = $defaultImage;
}
// Periksa apakah pengguna telah login
if (!isset($_SESSION['username'])) {
    // Jika tidak ada sesi login, arahkan ke halaman login
    header("Location: login.php");
    exit();
}

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$username = $_SESSION['username'];

// Cek apakah form pengunggahan gambar telah disubmit
if (isset($_POST['upload'])) {
    // Cek apakah gambar telah diunggah
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        // Mengambil informasi file yang diunggah
        $image_name = $_FILES['image']['name'];
        $image_tmp = $_FILES['image']['tmp_name'];
        $image_size = $_FILES['image']['size'];

        // Mengenerate nama unik untuk file gambar yang diunggah
        $extension_image_valid = ['jpg', 'jpeg', 'png'];
        $image_info = pathinfo($image_name);
        $image_extension = strtolower($image_info['extension']);
        $image_new_name = $username . '.' . $image_extension;

        // Periksa apakah ekstensi file yang diunggah valid
        if (!in_array($image_extension, $extension_image_valid)) {
            echo "<script>
                    alert('Tolong masukkan format gambar yang benar (jpg, jpeg, atau png).');
                    window.location.href = 'profile.php';
                 </script>";
            exit();
        }

        // Periksa ukuran file
        if ($image_size > 4000000) {
            echo "<script>
                    alert('Ukuran Gambar Terlalu Besar, Max 4MB.');
                    window.location.href = 'profile.php';
                 </script>";
            exit();
        }

        // Memindahkan gambar yang diunggah ke folder tujuan
        move_uploaded_file($image_tmp, 'img/' . $image_new_name);

        // Mengupdate kolom 'img_profile' dengan nama gambar yang baru di database
        $update_query = "UPDATE users SET img_profile = '$image_new_name' WHERE username = '$username'";
        mysqli_query($conn, $update_query);

        // Redirect ke halaman profile setelah mengupdate gambar
        header("Location: profile.php");
        exit();
    }
}



$sql = "SELECT * FROM users WHERE username = '$username'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // Data pengguna ditemukan, tampilkan informasinya
    $row = mysqli_fetch_assoc($result);

    $username = htmlspecialchars($row['username']);
    $full_name = htmlspecialchars($row['full_name']);
    $email = htmlspecialchars($row['email']);
    $phone_number = htmlspecialchars($row['phone_number']);
    $address = htmlspecialchars($row['address']);
    $balance = htmlspecialchars($row['balance']);
    $kelamin = $row['jenis_kelamin'];
    $tgl_lahir = $row['tgl_lahir'];
    $image = $row['img_profile'];
} else {
    // Data pengguna tidak ditemukan
    echo "Data pengguna tidak ditemukan.";
    exit();
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- ======== FONTS ======================== -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:regular,500,700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Palanquin+Dark:regular,500,600,700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Sniglet:regular,800&display=swap" rel="stylesheet" />

    <title><?php echo $full_name; ?> Profile</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/profile.css">
</head>

<body>
    <div class="container">
        <div class="profile-container">
            <a href="index.php" class="back-link">Kembali ke Halaman Utama</a>
            <h1>Halo <?php echo $full_name; ?></h1>
            <?php if (!empty($image)) { ?>
                <img src="<?php echo 'img/' . $image; ?>" class="img-profile">
            <?php } else { ?>
                <img src="img/default.png" alt="Default Image" class="img-profile">
            <?php } ?>
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="upload-container">
                    <input type="file" name="image" id="upload-file" onchange="displayFileName()" class="form-control-file">
                    <label for="upload-file" class="btn btn-primary">Ganti Photo Profile</label>
                    <span id="file-name"></span>
                </div>
                <button type="submit" name="upload" class="btn btn-primary upload-btn">Upload Image</button>
            </form>
            <div class="profile-info">
                <p><strong>Username:</strong> <?php echo $username; ?></p>
                <p><strong>Password:</strong> <a href="#">Change Password</a></p>
                <p><strong>Full Name:</strong> <?php echo $full_name; ?><a href="#"> edit</a></p>
                <p><strong>Jenis Kelamin:</strong> <?php echo $kelamin; ?><a href="#"> edit</a></p>
                <p><strong>Tanggal Lahir:</strong> <?php echo $tgl_lahir; ?><a href="#"> edit</a></p>
                <p><strong>Email:</strong> <?php echo $email; ?></p>
                <p><strong>Phone Number:</strong> <?php echo $phone_number; ?><a href="#"> edit</a></p>
                <p><strong>Alamat:</strong> <?php echo $address; ?><a href="#"> edit</a></p>
                <p><strong>Saldo:</strong> <?php echo $balance; ?><a href="#"> isi saldo</a></p>
            </div>
            <a class="btn btn-danger logout-link" href="logout.php">Logout</a>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        function displayFileName() {
            var input = document.getElementById('upload-file');
            var fileNameDisplay = document.getElementById('file-name');
            var uploadBtn = document.querySelector('.upload-btn');

            if (input.files.length > 0) {
                var fileName = input.files[0].name;
                fileNameDisplay.textContent = fileName;
                fileNameDisplay.style.display = 'block';
                uploadBtn.classList.add('show');
            } else {
                fileNameDisplay.textContent = '';
                fileNameDisplay.style.display = 'none';
                uploadBtn.classList.remove('show');
            }
        }
    </script>
</body>

</html>