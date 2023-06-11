<?php
include 'config.php';
session_start();
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
  <link rel="stylesheet" href="css/styles.css" />
  <link rel="stylesheet" href="css/mediass.css" />
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

  <!-- ======== FAVICON	 ======================== -->
  <link rel="icon" type="image/png" sizes="32x32" href="img/favicon/Mif.png" />

  <!-- ======== Title	 ======================== -->
  <title>GreenBites</title>
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
                <a href="#contact" class="menu__link">Contact</a>
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
              <h1 class="home__title">Plant Based</h1>
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
            <h1 class="title">Healthy<span>,</span> Happy<span>,</span> <br />Humane<span>.</span></h1>
            <div class="menus__row" data-aos="fade-up" data-aos-easing="linear" data-aos-duration="2000">
              <div class="menus__column menus__column--one">
                <div class="menus__item">
                  <div class="menus__image">
                    <img src="img/menu3.png" alt="menus__img" />
                  </div>
                  <h2 class="menus__title">PLANT BASED BURGER</h2>
                  <p class="menus__text">
                    Burger Plant Base adalah burger yang terbuat dari bahan-bahan nabati yang sehat, lezat, dan ramah lingkungan. Burger Plant Base tidak mengandung daging atau produk hewani lainnya, sehingga cocok untuk vegetarian, vegan, atau siapa saja yang ingin mengurangi konsumsi daging.
                  </p>
                  <br />
                  <a href="food_menu.php" class="contact__button" target="_blank">See More</a>
                </div>
              </div>
              <div class="menus__column menus__column--two">
                <div class="menus__item">
                  <div class="menus__image">
                    <img src="img/tbotol.png" alt="menus__img" />
                  </div>
                  <h2 class="menus__title">Drink</h2>
                  <p class="menus__text">Nikmati sensasi menyegarkan yang tak terlupakan dengan produk minuman kami yang unik dan menyegarkan. Minuman kami merupakan sumber vitamin alami yang sangat dibutuhkan oleh tubuh Anda.</p>
                  <br />
                  <a href="drink_menu.php" class="contact__button" target="_blank">See More</a>
                </div>
              </div>
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
              <a href="#payment" class="payment__link">
                <img src="img/bca.webp" alt="payment__img" class="payment__img" />
              </a>
              <div class="payment__text">BCA</div>
            </div>

            <div class="payment__item payment__item-two">
              <a href="#payment" class="payment__link">
                <img src="img/gopayy.png" alt="payment__img" class="payment__img" />
              </a>
              <div class="payment__text">Gopay</div>
            </div>

            <div class="payment__item payment__item-three">
              <a href="#payment" class="payment__link">
                <img src="img/dana.png" alt="payment__img" class="payment__img" />
              </a>
              <div class="payment__text">Dana</div>
            </div>

            <div class="payment__item payment__item-four">
              <a href="#payment" class="payment__link">
                <img src="img/ShopeePayy.png" alt="payment__img" class="payment__img" />
              </a>
              <div class="payment__text">Shoope Pay</div>
            </div>
          </div>
        </div>
      </section>

      <!-- ======== Contact	 ======================== -->
      <section class="contact" id="contact">
        <div class="container" data-aos="fade-left" data-aos-easing="linear" data-aos-duration="1500">
          <div class="contact__inner">
            <h2 class="title">Contacts</h2>
            <p class="contact__text">
              Want to know more about me? <br />
              just contact me at below!
            </p>
            <!-- Contact Form -->
            <!-- Contact Form -->
            <div class="contact-form">
              <form id="contact-form">
                <h2>Contact Me Here</h2>
                <input type="text" class="field" placeholder="First Name" required />
                <input type="text" class="field" placeholder="Last Name" required />
                <br />
                <input type="email" class="field" placeholder="Your email" required />
                <input type="text" class="field" placeholder="Your Phone" required />
                <h4>Type Your Message Here....</h4>
                <textarea required></textarea>
                <br />
                <button type="submit" class="contact__button">Send message</button>
              </form>
            </div>
            <ul class="contact__list">
              <li class="contact__item contact__item-one">
                <a href="http://www.instagram.com/miftfauzi" class="fcontact__link" target="_blank">
                  <img src="img/icon/instagram.svg" alt="img" class="contact__img" />
                </a>
              </li>
              <li class="contact__item contact__item-two">
                <a href="https://www.tiktok.com/@joseph.avenue" class="contact__link" target="_blank">
                  <img src="img/icon/tiktok.svg" alt="img" class="contact__img" />
                </a>
              </li>
              <li class="contact__item contact__item-three">
                <a href="https://www.youtube.com/@mifuzi2602" class="contact__link" target="_blank">
                  <img src="img/icon/youtube.svg" alt="img" class="contact__img" />
                </a>
              </li>
              <li class="contact__item contact__item-four">
                <a href="https://github.com/miftt" class="contact__link" target="_blank">
                  <img src="img/icon/github.svg" alt="img" class="contact__img" />
                </a>
              </li>
            </ul>
            <div class="contact__subtext">
              Like me on <br />
              Instagram, Facebook, Youtube, GitHub
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
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>
  <script>
    AOS.init();
  </script>
  <script>
    const form = document.getElementById('contact-form');

    form.addEventListener('submit', function(e) {
      e.preventDefault();

      // Mengambil nilai input
      const firstName = document.querySelector('.field[placeholder="First Name"]').value;
      const lastName = document.querySelector('.field[placeholder="Last Name"]').value;
      const email = document.querySelector('.field[placeholder="Your email"]').value;
      const phone = document.querySelector('.field[placeholder="Your Phone"]').value;
      const message = document.querySelector('textarea').value;

      // Mengirim pesan melalui Webhook Discord
      const webhookURL = 'https://discord.com/api/webhooks/1117480552459669614/UqWuQAA25WRGG2IKyPkJ7jZdR96Lw23qBlQd2XZK5ovKkaoc4X5QyHCvTMAwGrtUcuQJ'; // Ganti dengan URL webhook Discord Anda
      const payload = {
        username: 'Contact Form',
        content: `New message from Website GreenBites \nFullname: ${firstName} ${lastName}\nEmail: ${email}\nPhone: ${phone}\nMessage: ${message}`
      };

      fetch(webhookURL, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify(payload)
        })
        .then(response => {
          if (response.ok) {
            Swal.fire({
              icon: 'success',
              title: 'Success',
              text: 'Message sent successfully'
            }).then(() => {
              form.reset();
            });
          } else {
            throw new Error('Error sending message');
          }
        })
        .catch(error => {
          console.error(error);
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Error sending message'
          });
        });
    });
  </script>
</body>

</html>