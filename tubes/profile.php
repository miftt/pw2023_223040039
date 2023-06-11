<?php
include 'config.php';
session_start();
// Mengatur path gambar default
$defaultImage = 'img/users/default.png';

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
                    window.location.href = 'profile.php?error=img';
                 </script>";
            exit();
        }

        // Periksa ukuran file
        if ($image_size > 4000000) {
            echo "<script>
                    window.location.href = 'profile.php?error=size';
                 </script>";
            exit();
        }

        // Memindahkan gambar yang diunggah ke folder tujuan
        move_uploaded_file($image_tmp, 'img/users/' . $image_new_name);

        // Mengupdate kolom 'img_profile' dengan nama gambar yang baru di database
        $update_query = "UPDATE users SET img_profile = '$image_new_name' WHERE username = '$username'";
        mysqli_query($conn, $update_query);

        // Redirect ke halaman profile setelah mengupdate gambar
        header("Location: profile.php?success=1");
        exit();
    }
}



$sql = "SELECT * FROM users WHERE username = '$username'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // Data pengguna ditemukan, tampilkan informasinya
    $row = mysqli_fetch_assoc($result);

    $user_id = $row['user_id'];
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
    <link rel="icon" type="image/png" sizes="32x32" href="img/favicon/Mif.png" />
</head>

<body>
    <div class="container">
        <div class="profile-container">
            <a href="index.php" class="back-link">Kembali ke Halaman Utama</a>
            <h1>Halo <?php echo $full_name; ?></h1>
            <div class="profile-img">
                <?php if (!empty($image)) { ?>
                    <img src="<?php echo 'img/users/' . $image; ?>" class="img-profile" id="profileImage">
                <?php } else { ?>
                    <img src="img/users/default.png" class="img-profile" id="profileImage">
                <?php } ?>
            </div>
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="upload-container">
                    <input type="file" name="image" id="uploadFile" onchange="displayFileName()" class="form-control-file">
                    <label for="uploadFile" class="btn btn-primary">Ganti Photo Profile</label>
                    <span id="fileName"></span>
                    <button type="submit" name="upload" class="btn btn-primary upload-btn">Upload Image</button>
                </div>
            </form>
            <div class="profile-info">
                <a href="edit_profile.php?user_id=<?php echo $user_id; ?>" class="btn btn-primary btn-sm mb-2">Edit Profile</a>
                <p><strong>Username:</strong> <?php echo $username; ?></p>
                <p><strong>Full Name:</strong> <?php echo $full_name; ?></p>
                <p><strong>Jenis Kelamin:</strong> <?php echo $kelamin; ?></p>
                <p><strong>Tanggal Lahir:</strong> <?php echo $tgl_lahir; ?></p>
                <p><strong>Email:</strong> <?php echo $email; ?></p>
                <p><strong>Phone Number:</strong> <?php echo $phone_number; ?></p>
                <p><strong>Alamat:</strong> <?php echo $address; ?></p>
                <p><strong>Saldo:</strong> <?php echo $balance; ?><br><a href="#"> isi saldo</a></p>
            </div>
            <a class="btn btn-danger logout-link" href="logout.php">Logout</a>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>
    <script>
        function displayFileName() {
            var input = document.getElementById('uploadFile');
            var fileNameDisplay = document.getElementById('fileName');
            var profileImage = document.getElementById('profileImage');
            var uploadBtn = document.querySelector('.upload-btn');

            if (input.files.length > 0) {
                var fileName = input.files[0].name;
                fileNameDisplay.textContent = fileName;
                fileNameDisplay.style.display = 'block';
                profileImage.src = URL.createObjectURL(input.files[0]);
                uploadBtn.style.display = 'block';
            } else {
                fileNameDisplay.textContent = '';
                fileNameDisplay.style.display = 'none';
                uploadBtn.style.display = 'none';
            }
        }
    </script>
    <script>
        <?php if (isset($_GET['success']) && $_GET['success'] == 1) { ?>
            Swal.fire({
                icon: 'success',
                title: 'Gambar berhasil diperbarui!',
                showConfirmButton: false,
                timer: 1500,
                timerProgressBar: true
            });
        <?php } elseif (isset($_GET['success']) && $_GET['success'] == "edit") { ?>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil mengubah data profile',
                showConfirmButton: false,
                timer: 1500,
                timerProgressBar: true
            });
        <?php } elseif (isset($_GET['success']) && $_GET['success'] == 0) { ?>
            Swal.fire({
                icon: 'error',
                title: 'Gagal user data pengguna!',
                showConfirmButton: false,
                timer: 1500,
                timerProgressBar: true
            });
        <?php } elseif (isset($_GET['error']) && $_GET['error'] == 'size') { ?>
            Swal.fire({
                icon: 'error',
                title: 'Ukuran Gambar Terlalu Besar, Max 4MB!',
                showConfirmButton: false,
                timer: 4000,
                timerProgressBar: true
            });
        <?php } elseif (isset($_GET['error']) && $_GET['error'] == 'img') { ?>
            Swal.fire({
                icon: 'error',
                title: 'Gunakan format PNG, JPG, JPEG',
                showConfirmButton: false,
                timer: 4000,
                timerProgressBar: true
            });
        <?php } ?>
    </script>
</body>

</html>