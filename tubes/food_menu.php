<?php
session_start();
include 'config.php';

// Mendapatkan data produk dan kategorinya dari database
$query = "SELECT Menu.*, GROUP_CONCAT(Category.category_name SEPARATOR ', ') AS categories
          FROM Menu
          LEFT JOIN Menu_Category ON Menu.menu_id = Menu_Category.menu_id
          LEFT JOIN Category ON Menu_Category.category_id = Category.category_id
          WHERE Menu_Category.category_id = 1
          GROUP BY Menu.menu_id";
$result = mysqli_query($conn, $query);
$products = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- ======== FONTS ======================== -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:regular,500,700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Palanquin+Dark:regular,500,600,700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Sniglet:regular,800&display=swap" rel="stylesheet" />

    <!-- ======== LINK CSS	 ======================== -->
    <link rel="stylesheet" href="css/nullstyle.css" />
    <link rel="stylesheet" href="css/menu.css" />
    <link rel="stylesheet" href="css/mediass.css" />
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- ======== FAVICON	 ======================== -->
    <link rel="icon" type="image/png" sizes="32x32" href="img/favicon/Mif.png" />

    <!-- ======== Title	 ======================== -->
    <title>GreenBites food menu</title>
</head>

<body>
    <div class="wrapper">
        <!-- ======== Header	 ======================== -->
        <header class="header">
            <div class="container">
                <div class="header__inner">
                    <a href="index.php" class="header__logo">GreenBites</a>

                    <!-- ======== Header burger	 ======================== -->
                    <div class="header__burger">
                        <span></span>
                    </div>

                    <!-- ======== Menu	 ======================== -->
                    <nav class="menu">
                        <ul class="menu__list">
                            <li class="menu__item">
                                <a href="#home" class="menu__link">Home</a>
                            </li>
                            <li class="menu__item">
                                <a href="#menus" class="menu__link">Menu</a>
                            </li>
                            <li class="menu__item">
                                <a href="#payment" class="menu__link">Payment</a>
                            </li>
                            <li class="menu__item">
                                <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') { ?>
                                    <div class="dropdown">
                                        <a href="#" class="menu__link"><?= $_SESSION['username'] ?></a>
                                        <img class="dropdown__arrow" src="img/icon/dropDownArrow.png" width="8px">
                                        <ul class="submenu">
                                            <li class="submenu__item">
                                                <a href="profile.php" class="submenu__link">Profile</a>
                                            </li>
                                            <li class="submenu__item">
                                                <a href="halaman_admin.php" class="submenu__link">Admin Dashboard</a>
                                            </li>
                                            <li class="submenu__item">
                                                <a href="list_produk.php" class="submenu__link">Produk Dashboard</a>
                                            </li>
                                            <li class="submenu__item">
                                                <a href="logout.php" class="submenu__link">Logout</a>
                                            </li>
                                        </ul>
                                    </div>
                                <?php } elseif (isset($_SESSION['username'])) { ?>
                                    <div class="dropdown">
                                        <a href="#" class="menu__link"><?= $_SESSION['username'] ?></a>
                                        <img class="dropdown__arrow" src="img/icon/dropDownArrow.png" width="8px">
                                        <ul class="submenu">
                                            <li class="submenu__item">
                                                <a href="profile.php" class="submenu__link">Profile</a>
                                            </li>
                                            <li class="submenu__item">
                                                <a href="logout.php" class="submenu__link">Logout</a>
                                            </li>
                                        </ul>
                                    </div>
                                <?php } else { ?>
                                    <a href="login.php" class="menu__link">Login</a>
                                <?php } ?>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </header>

        <!-- ======== Main	 ======================== -->
        <main class="main">
            <!-- ======== Home	 ======================== -->
            <section class="home" id="home">
                <div class="container">
                    <div class="home__inner">
                        <div class="home__items">
                            <h1 class="home__title">Food Menu</h1>
                            <div class="home__subtitle">GreenBites menyajikan burger plant-based lezat dan sehat dengan bahan-bahan alami dan organik. Kami menawarkan pelayanan modern yang profesional. Selamat datang di GreenBites, tempat untuk menikmati burger plant-based yang lezat dan sehat!</div>
                        </div>
                        <div class="home__image">
                            <img src="img/burgerd.png" alt="home image" class="home__img img" />
                        </div>
                    </div>
                </div>
            </section>

            <!-- ======== menus	 ======================== -->
            <section class="menus" id="menus">
                <div class="container">
                    <div class="menus__inner">
                        <h1 class="title">Food Menu<span>.</span></h1>
                        <div class="menus__row" data-aos="fade-up" data-aos-easing="linear" data-aos-duration="2000">
                            <?php foreach ($products as $product) : ?>
                                <div class="menus__column menus__column--one">
                                    <div class="menus__item">
                                        <div class="menus__image">
                                            <img src="img/products/<?= $product['menu_image']; ?>" alt="menus__img" />
                                        </div>
                                        <h2 class="menus__title"><?= $product['menu_name']; ?></h2>
                                        <p class="menus__text"><?= $product['menu_description']; ?></p>
                                        <br />
                                        <p>Rp.<?= $product['menu_price'] ?></p>
                                        <a href="#menus" class="contact__button">Buy</a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </section>


            <!-- ======== payment	 ======================== -->
            <section class="payment" id="payment">
                <div class="container">
                    <h2 class="title" data-aos="fade-down" data-aos-easing="linear" data-aos-duration="1200">Payment Methods</h2>
                    <div class="payment__inner" data-aos="fade-up" data-aos-easing="bottom-bottom" data-aos-duration="1800">
                        <div class="payment__item payment__item-one">
                            <a href="https://playvalorant.com/id-id/" class="payment__link" target="_blank">
                                <img src="img/bca.webp" alt="payment__img" class="payment__img" />
                            </a>
                            <div class="payment__text">BCA</div>
                        </div>

                        <div class="payment__item payment__item-two">
                            <a href="#video" class="payment__link">
                                <img src="img/gopayy.png" alt="payment__img" class="payment__img" />
                            </a>
                            <div class="payment__text">Gopay</div>
                        </div>

                        <div class="payment__item payment__item-three">
                            <a href="https://www.tiktok.com/@joseph.avenue" class="payment__link" target="_blank">
                                <img src="img/dana.png" alt="payment__img" class="payment__img" />
                            </a>
                            <div class="payment__text">Dana</div>
                        </div>

                        <div class="payment__item payment__item-four">
                            <a href="https://open.spotify.com/user/21xjykbasyftcfnjv3ekzovja" class="payment__link" target="_blank">
                                <img src="img/ShopeePayy.png" alt="payment__img" class="payment__img" />
                            </a>
                            <div class="payment__text">Shoope Pay</div>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <!-- ======== Footer ========================= -->
        <footer class="footer">
            <div class="container">
                <div class="footer__inner">
                    <div class="footer__cooper">Copyright © <a href="https://github.com/miftt" class="footer__link-bio" target="_blank">miftt</a>, 2023. All rights reserved.</div>
                </div>
            </div>
        </footer>
    </div>

    <!-- ========= Script ========================= -->
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
    <script src="js/script.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>

</html>