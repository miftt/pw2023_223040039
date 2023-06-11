<?php
include 'config.php';
session_start();

// Periksa apakah pengguna telah login
if (isset($_SESSION['username'])) {
    // Jika tidak ada sesi login, arahkan ke halaman login
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="css/loginn.css" />
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="icon" type="image/png" sizes="32x32" href="img/favicon/Mif.png" />
</head>

<body>
    <h2>Login Terlebih Dahulu</h2>
    <?php
    if (isset($error_message)) { ?>
        <p class="error"><?php echo $error_message; ?></p>
    <?php } ?>
    <?php if (isset($_GET['success']) && $_GET['success'] == 0) { ?>
        <p class="error">Username atau email sudah digunakan. Silahkan pilih username atau email lain.</p>
    <?php } elseif (isset($_GET['success']) && $_GET['success'] == 1) { ?>
        <p class="success">Berhasil daftar akun! Silahkan login kembali</p>
    <?php } ?>
    <div class="container" id="container">
        <div class="form-container sign-up-container">
            <form action="register.php" method="POST">
                <h1>Create Account</h1>
                <?php
                if (isset($error_message)) { ?>
                    <p class="error"><?php echo $error_message; ?></p>
                <?php } ?>
                <?php if (isset($_GET['success']) && $_GET['success'] == 0) { ?>
                    <p class="error">Username atau email sudah digunakan. Silahkan pilih username atau email lain.</p>
                <?php } ?>
                <!-- <div class="social-container">
                    <a href="#" class="social"><i class="fa-brands fa-facebook"></i>
                        <a href="#" class="social"><i class="fab fa-google-plus-g"></i></a>
                </div> -->
                <!-- <span>or use your email for registration</span> -->
                <input type="text" name="username" placeholder="username*" required />
                <input type="text" name="fullname" placeholder="Full Name*" required />
                <select name="jenis_kelamin" require>
                    <option value="">Pilih jenis kelamin*</option>
                    <option value="laki-laki">Laki-laki</option>
                    <option value="perempuan">Perempuan</option>
                </select>
                <input type="date" name="tgl_lahir" placeholder="Tanggal Lahir*" required />
                <input type="number" name="phonenumber" placeholder="Phone Number" />
                <input type="email" name="email" placeholder="Email*" required />
                <input type="password" name="password" placeholder="Password*" required />
                <button class="submit" type="submit" name="submit" value="signup">Sign Up</button>
            </form>
        </div>
        <div class="form-container sign-in-container">
            <form action="signin.php" method="POST">
                <h1>Sign in</h1>
                <div class="social-container">
                </div>
                <span>Use your account</span>
                <input type="username" name="username" placeholder="Username" required autofocus />
                <input type="password" name="password" placeholder="Password" required />
                <a href="#">Forgot your password?</a>
                <button type="submit" name="signin">Sign In</button>
                <?php if (isset($_GET['login_error']) && $_GET['login_error'] == 1) { ?>
                    <p class="error">Username or password is incorrect.</p>
                <?php } ?>
                <?php if (isset($_GET['login_success']) && $_GET['login_success'] == 1) { ?>
                    <p class="success">Login berhasil!</p>
                <?php } ?>
            </form>
        </div>
        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h1>Welcome Back!</h1>
                    <p>To keep connected with us please login with your personal info</p>
                    <button class="ghost" id="signIn">Sign In</button>
                </div>
                <div class="overlay-panel overlay-right">
                    <h1>Hello, Friend!</h1>
                    <p>Enter your personal details and start journey with us</p>
                    <button class="ghost" id="signUp">Sign Up</button>
                </div>
            </div>
        </div>
    </div>
    <br />
    <div class="arrow">
        <a href="index.php">
            <img src="img/icon/arrow.svg" alt="Back to Home">Back
        </a>
    </div>
    <script>
        const signUpButton = document.getElementById('signUp');
        const signInButton = document.getElementById('signIn');
        const container = document.getElementById('container');

        signUpButton.addEventListener('click', () => {
            document.querySelector('h2').textContent = "Daftar Terlebih Dahulu";
            container.classList.add("right-panel-active");
        });

        signInButton.addEventListener('click', () => {
            document.querySelector('h2').textContent = "Login Terlebih Dahulu";
            container.classList.remove("right-panel-active");
        });
    </script>
</body>

</html>