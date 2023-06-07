<?php
require 'config.php';
require 'functions.php';
session_start();
//Periksa apakah pengguna memiliki akses admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
	header("Location: login.php");
	exit();
}

// Fungsi untuk mendapatkan data pengguna dari database

// Mendapatkan data pengguna dari database
$users = getUsers();
$products = getProducts();
$orderDetails = getOrderDetails();
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- Boxicons -->
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	<!-- My CSS -->
	<title>Dashboard Admin</title>
	<link rel="stylesheet" href="css/dashboard.css">
</head>

<body>

	<!-- SIDEBAR -->
	<section id="sidebar">
		<a href="#" class="brand">
			<i class='bx bxs-server'></i>
			<span class="text">GreenBites</span>
		</a>
		<ul class="side-menu top">
			<li class="active">
				<a href="#">
					<i class='bx bxs-dashboard'></i>
					<span class="text">Dashboard</span>
				</a>
			</li>
			<li>
				<a href="halaman_admin.php">
					<i class='bx bxs-user'></i>
					<span class="text">Daftar Users</span>
				</a>
			</li>
			<li>
				<a href="list_produk.php">
					<i class='bx bxs-cart'></i>
					<span class="text">Daftar Products</span>
				</a>
			</li>
			<li>
				<a href="#">
					<i class='bx bxs-message-dots'></i>
					<span class="text">Message</span>
				</a>
			</li>
		</ul>
		<ul class="side-menu">
			<li>
				<a href="#">
					<i class='bx bxs-cog'></i>
					<span class="text">Settings</span>
				</a>
			</li>
			<li>
				<a href="logout.php" class="logout">
					<i class='bx bxs-log-out-circle'></i>
					<span class="text">Logout</span>
				</a>
			</li>
		</ul>
	</section>
	<!-- SIDEBAR -->



	<!-- CONTENT -->
	<section id="content">
		<!-- NAVBAR -->
		<nav>
			<i class='bx bx-menu'></i>
			<a href="#" class="nav-link">Categories</a>
			<form action="#">
				<div class="form-input">
					<input type="search" placeholder="Search...">
					<button type="submit" class="search-btn"><i class='bx bx-search'></i></button>
				</div>
			</form>
			<input type="checkbox" id="switch-mode" hidden>
			<label for="switch-mode" class="switch-mode"></label>
			<a href="#" class="notification">
				<i class='bx bxs-bell'></i>
				<span class="num">8</span>
			</a>
			<a href="#" class="profile">
				<img src="img/users/<?php echo $_SESSION['img_profile']; ?>">
			</a>
		</nav>
		<!-- NAVBAR -->

		<!-- MAIN -->
		<main>
			<div class="head-title">
				<div class="left">
					<h1>Dashboard</h1>
					<ul class="breadcrumb">
						<li>
							<a class="active" href="#">Dashboard</a>
						</li>
					</ul>
				</div>
				<a href="#" class="btn-download">
					<i class='bx bxs-cloud-download'></i>
					<span class="text">Download PDF</span>
				</a>
			</div>
			<?php $i = 0; // Initialize $i to 0 before the loop 
			?>
			<?php foreach ($users as $user) : ?>
				<?php $i++; // Increment $i for each user in the loop 
				?>
			<?php endforeach; ?>
			<?php $j = 0; // Initialize $i to 0 before the loop 
			?>
			<?php foreach ($products as $product) : ?>
				<?php $j++; // Increment $i for each user in the loop 
				?>
			<?php endforeach; ?>
			<?php $k = 0; // Initialize $i to 0 before the loop 
			?>
			<?php foreach ($orderDetails as $orderDetail) : ?>
				<?php $k++; // Increment $i for each user in the loop 
				?>
			<?php endforeach; ?>
			<ul class="box-info">
				<li>
					<i class='bx bxs-cart'></i>
					<span class="text">
						<h3><?= $j; ?></h3>
						<p>Products</p>
					</span>
				</li>
				<li>
					<i class='bx bxs-group'></i>
					<span class="text">
						<h3><?= $i; ?></h3> <!-- Display the total number of users -->
						<p>Users</p>
					</span>
				</li>
				<li>
					<i class='bx bxs-dollar-circle'></i>
					<span class="text">
						<h3><?= $k; ?></h3>
						<p>Total Penjualan</p>
					</span>
				</li>
			</ul>

		</main>

		<!-- MAIN -->
	</section>
	<!-- CONTENT -->


	<script src="js/dashboard.js"></script>
</body>

</html>