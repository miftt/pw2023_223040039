-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 11 Jun 2023 pada 15.40
-- Versi server: 8.0.30
-- Versi PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pwtubes_223040039`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `category`
--

CREATE TABLE `category` (
  `category_id` int NOT NULL,
  `category_name` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `category`
--

INSERT INTO `category` (`category_id`, `category_name`, `created_at`, `updated_at`) VALUES
(1, 'Makanan', '2023-06-06 14:46:46', '2023-06-06 14:47:06'),
(2, 'Minuman', '2023-06-06 14:46:46', '2023-06-06 14:47:09');

-- --------------------------------------------------------

--
-- Struktur dari tabel `menu`
--

CREATE TABLE `menu` (
  `menu_id` int NOT NULL,
  `menu_name` varchar(100) NOT NULL,
  `menu_description` text NOT NULL,
  `menu_price` decimal(10,2) NOT NULL,
  `menu_image` varchar(255) NOT NULL,
  `quantity` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `menu`
--

INSERT INTO `menu` (`menu_id`, `menu_name`, `menu_description`, `menu_price`, `menu_image`, `quantity`, `created_at`, `updated_at`) VALUES
(1, 'Whopper Plant Based', 'Burger dengan patty berbahan kedelai, gandum, minyak sayur, dan rempah-rempah yang dipanggang dengan api. Disajikan dengan roti biji wijen, tomat, selada, mayones, saus tomat, acar, dan bawang bombay.', 20000.00, 'menu_648571d26479e.jpg', 10, '2023-06-06 14:58:08', '2023-06-11 15:09:02'),
(5, 'Beyond Burger', 'burger dengan patty berbahan protein kacang polong, minyak kelapa, dan ekstrak bit yang meniru rasa dan tekstur daging sapi. Disajikan dengan roti gandum utuh, selada romaine, tomat ceri, alpukat, saus mustard, dan keju vegan.', 25000.00, 'menu_6485726a41369.jpg', 10, '2023-06-11 03:11:34', '2023-06-11 15:10:41'),
(7, 'Black bean veggie burger', 'burger dengan patty berbahan kacang hitam, bawang bombay, bawang putih, oatmeal, tepung roti, dan bumbu-bumbu. Disajikan dengan roti gandum, selada, tomat, dan saus sesuai selera', 30000.00, 'burgers.jpg', 20, '2023-06-11 10:47:37', '2023-06-11 15:12:26'),
(9, 'Smoked tofu vegan burger', 'Burger dengan patty berbahan tahu asap yang dihancurkan kasar, kentang tumbuk, kacang mete cincang, dan bumbu-bumbu. Disajikan dengan roti gandum utuh, selada romaine, tomat ceri, alpukat, saus mustard, dan keju vegan', 35000.00, 'burg3.jpg', 11, '2023-06-11 10:48:00', '2023-06-11 15:18:30'),
(13, 'Oreo Milkshake', ' Minuman dengan bahan dasar es krim vanila, susu, dan biskuit oreo yang diblender sampai halus. Disajikan dengan cokelat', 35000.00, 'oreomilk.jpg', 5, '2023-06-11 15:15:48', '2023-06-11 15:15:48'),
(14, 'Oreo Malt', 'Minuman dengan bahan dasar es krim vanila, susu, bubuk malt, saus cokelat, dan biskuit oreo yang dicampur dalam gelas besar. Disajikan dengan biskuit oreo utuh sebagai topping2', 30000.00, 'oreomalt.jpg', 5, '2023-06-11 15:18:01', '2023-06-11 15:18:01'),
(15, 'Milk Shake', ' Minuman dengan bahan dasar es krim vanila.strawberry,coklat, susu, dan di ekstrak dengan cara diblender sampai halus. Disajikan dengan whipped cream dan ceri sebagai topping', 40000.00, 'milkshake.jpg', 3, '2023-06-11 15:21:28', '2023-06-11 15:21:28'),
(16, 'Banana Milk Shake', 'Minuman dengan bahan dasar es krim vanila, susu, pisang matang, dan ekstrak vanila yang diblender sampai halus. Disajikan dengan whipped cream dan irisan pisang sebagai topping', 35000.00, 'bananashake.jpg', 2, '2023-06-11 15:23:35', '2023-06-11 15:23:35');

-- --------------------------------------------------------

--
-- Struktur dari tabel `menu_category`
--

CREATE TABLE `menu_category` (
  `menu_id` int NOT NULL,
  `category_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `menu_category`
--

INSERT INTO `menu_category` (`menu_id`, `category_id`) VALUES
(1, 1),
(5, 1),
(7, 1),
(9, 1),
(13, 2),
(14, 2),
(15, 2),
(16, 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `orders`
--

CREATE TABLE `orders` (
  `order_id` int NOT NULL,
  `user_id` int NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `order_detail`
--

CREATE TABLE `order_detail` (
  `order_id` int NOT NULL,
  `menu_id` int NOT NULL,
  `quantity` int NOT NULL,
  `subtotal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `user_id` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `address` varchar(255) NOT NULL,
  `balance` decimal(10,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `tgl_lahir` date DEFAULT NULL,
  `jenis_kelamin` varchar(10) DEFAULT NULL,
  `img_profile` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `role` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `full_name`, `email`, `phone_number`, `address`, `balance`, `created_at`, `updated_at`, `tgl_lahir`, `jenis_kelamin`, `img_profile`, `role`) VALUES
(1, 'user', '$2y$10$jSjhfr5vKaVqW/GZim38Zu0x1vatn6DcCtiUm9CA1sGsl38oWyuwu', 'user biasa', 'miftahfauzi012@gmail.com', '0812', 'ujungberung, kota bandung', 10000000.00, '2023-05-17 12:43:47', '2023-06-11 11:14:54', '2000-01-27', NULL, 'user.png', 'user'),
(14, 'admin', '$2y$10$C9JXu.jD0KXaiN8caS3Gd.rpBLY17tFXR9i0oCvVDZQjbfLGvzrtm', 'admin ganteng', 'admin@gmail.com', '0821123123123', 'jalan bandung\r\n', 69696969.00, '2023-05-24 13:00:46', '2023-06-11 09:18:33', '2004-01-27', 'laki-laki', 'admin.jpg', 'admin'),
(23, 'cek', '$2y$10$Y6l7uWaTa3ayiiFUk1h6euMvB03ai3r8rtI2weQT8cH91aY0cBqJm', 'cek', 'cek@gmail.com', '12039123', 'bandung', 0.00, '2023-06-04 13:56:27', '2023-06-11 06:12:13', NULL, NULL, NULL, 'user'),
(24, 'cek1', '$2y$10$pyCGd3GBwyXDKlufaEp.tenWdKeikuqQq9LFkkwQBDXv2LUCDsolS', 'cek1', 'cek1@gmail.com', '012313', 'jakarta', 0.00, '2023-06-04 13:59:24', '2023-06-11 06:12:15', NULL, NULL, NULL, 'admin'),
(25, 'cek2', '$2y$10$yFx5FJuVnpbc4j5yFI11JOd7YIjLr1ERmUFW81UfJT5vwgBXsY1cW', 'cek cek', 'cek2@gmail.com', '01231283', 'bengkulu', 0.00, '2023-06-04 14:01:48', '2023-06-11 06:12:26', NULL, NULL, NULL, 'user'),
(26, 'cek3', '$2y$10$IQCfciTo9touSFnMY/BT7.OEDFPKPEfujqgT5h/9bh69JFPsaLOJ2', 'ceka', 'ceka@gmail.com', '0128312832', 'bali', 0.00, '2023-06-04 14:04:26', '2023-06-11 06:13:03', NULL, NULL, NULL, 'user'),
(27, 'jaku', '$2y$10$59d06Yx8wciyYO8cRjolvO1adS8cmB4ARmGKunA8xnNYks.ZdJ0le', 'jakari', 'jakari@gmail.com', '08123712', 'kalimantan', 0.00, '2023-06-04 14:09:16', '2023-06-11 06:13:16', NULL, NULL, NULL, 'user'),
(28, 'coks', '$2y$10$Rj.h83w4QD3buBEOQ8P0vumrNzcPQbGT0lNrHYjgj.7DoW4xZrW0O', 'coks', 'coks@gmail.com', '20213012', 'ubers', 0.00, '2023-06-07 19:46:30', '2023-06-11 15:28:46', '2002-02-22', 'laki-laki', NULL, 'user'),
(31, 'mifus', '$2y$10$QBDcy7WMh25c.uLsjlgIoey6h2gJxb8PnuQ5oScvSW9EagKrGsoym', 'mifuzi', 'mifus@gmail.com', '123123', 'ubers', 0.00, '2023-06-11 04:57:53', '2023-06-11 06:13:55', NULL, NULL, NULL, 'user'),
(33, 'cekuser', '$2y$10$wMCBIkJB6GF4xverCfbXV.AmyfkhjCXIqMrFD5CBgHCOOdprQmQ2O', 'adokawodk', 'aowdkawdko@gmail.com', '12309123', 'awdawj', 0.00, '2023-06-11 10:06:40', '2023-06-11 15:38:19', NULL, NULL, NULL, 'user'),
(34, 'jancos', '$2y$10$I2K2SvedQoAUqYjGEF9XH.Cw.qdm65yuuzL9kB9hjSkDnHfTMHt72', 'aodkoakwd', 'aowkde@gmail.com', '210310239', '12039123', 1.00, '2023-06-11 10:08:32', '2023-06-11 10:08:32', NULL, NULL, NULL, 'user');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indeks untuk tabel `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`menu_id`);

--
-- Indeks untuk tabel `menu_category`
--
ALTER TABLE `menu_category`
  ADD PRIMARY KEY (`menu_id`,`category_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indeks untuk tabel `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `order_detail`
--
ALTER TABLE `order_detail`
  ADD PRIMARY KEY (`order_id`,`menu_id`),
  ADD KEY `menu_id` (`menu_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `menu`
--
ALTER TABLE `menu`
  MODIFY `menu_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `menu_category`
--
ALTER TABLE `menu_category`
  ADD CONSTRAINT `menu_category_ibfk_1` FOREIGN KEY (`menu_id`) REFERENCES `menu` (`menu_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `menu_category_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `order_detail`
--
ALTER TABLE `order_detail`
  ADD CONSTRAINT `order_detail_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_detail_ibfk_2` FOREIGN KEY (`menu_id`) REFERENCES `menu` (`menu_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
