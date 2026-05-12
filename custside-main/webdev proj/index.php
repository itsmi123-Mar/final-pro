<?php
// =============================================
// King's Cup Coffee — Home Page
// =============================================
$page_title = "King's Cup Coffee";
?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title><?= htmlspecialchars($page_title) ?></title>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">

  <!-- CSS -->
  <link rel="stylesheet" href="style.css">

</head>

<body>

  <!-- =============================================
       NAVBAR
  ============================================== -->
  <nav class="navbar">

    <div class="nav-inner">

      <a href="index.php" class="nav-logo">

        <div class="logo-icon">
          <svg width="36" height="36" viewBox="0 0 36 36" fill="none">
            <circle cx="18" cy="18" r="18" fill="#3b1f0e"/>
            <path d="M10 22 Q12 14 18 12 Q24 14 26 22 Q22 26 18 27 Q14 26 10 22Z" fill="#c8860a"/>
            <circle cx="18" cy="19" r="4" fill="#3b1f0e"/>
          </svg>
        </div>

        <span class="logo-text">King's Cup</span>

      </a>

      <ul class="nav-links">

        <li><a href="menu.php">Menu</a></li>
        <li><a href="view_orders.php">View Orders</a></li>
        <li><a href="#">Order Status</a></li>
        <li><a href="#" class="active">Home</a></li>

      </ul>

      <a href="#" class="btn-login">Login / Sign Up</a>

      <button class="hamburger" id="hamburger" aria-label="Toggle menu">
        ☰
      </button>

    </div>

  </nav>

  <!-- =============================================
       HERO / PROMO
  ============================================== -->
  <section class="promo-banner">

    <p>
      It's a great day for coffee here at King's Cup!<br>
      <span>
        With new ways to experience your espresso favorites and more — make every sip special.
      </span>
    </p>

    <a href="menu.php" class="btn-order-now">
      ORDER NOW
    </a>

  </section>

  <!-- =============================================
       STORY SECTION
  ============================================== -->
  <section class="story-section">

    <div class="story-text">

      <p class="story-label">
        King's Cup® Story
      </p>

      <h2>
        Behind The Drink of<br>The Royals
      </h2>

      <p class="story-desc">
        Read how every brew made its way to the hearts of many and where it all began.
      </p>

      <a href="#" class="btn-read">
        Read
      </a>

    </div>

    <div class="story-image">

      <div class="oval-frame">

        <img
          src="https://images.unsplash.com/photo-1509042239860-f550ce710b93?w=500&q=80"
          alt="Coffee Story"
        >

      </div>

    </div>

  </section>

  <!-- =============================================
       BREWED SECTION
  ============================================== -->
  <section class="brewed-section">

    <h2 class="brewed-title">
      Brewed to Perfection
    </h2>

    <p class="brewed-desc">
      Our coffee menu offers a delightful selection of rich espresso blends, freshly crafted drinks, and warm pastries.
      Every cup is made with passion and precision.
    </p>

    <div class="cards-grid">

      <!-- ESPRESSO -->
      <div class="menu-card card-light">

        <div class="card-img-wrap">
          <img src="https://images.unsplash.com/photo-1485808191679-5f86510bd9d4?w=400&q=80" alt="Espresso">
        </div>

        <h3>Espresso Blends</h3>

        <p>
          Bold, rich, and smooth coffee crafted from premium beans.
        </p>

        <a href="menu.php?cat=espresso" class="btn-check">
          Check it out!
        </a>

      </div>

      <!-- PASTRIES -->
      <div class="menu-card card-light">

        <div class="card-img-wrap">
          <img src="https://images.unsplash.com/photo-1509440159596-0249088772ff?w=400&q=80" alt="Pastries">
        </div>

        <h3>Fresh Pastries</h3>

        <p>
          Freshly baked treats that pair perfectly with coffee.
        </p>

        <a href="menu.php?cat=pastries" class="btn-check">
          Check it out!
        </a>

      </div>

      <!-- COLD DRINKS -->
      <div class="menu-card card-dark">

        <div class="card-img-wrap">
          <img src="https://images.unsplash.com/photo-1556679343-c7306c1976bc?w=400&q=80" alt="Cold Drinks">
        </div>

        <h3>Cold Drinks</h3>

        <p>
          Refreshing beverages made for hot days and cool moods.
        </p>

        <a href="menu.php?cat=nocoffee" class="btn-check btn-check-light">
          Check it out!
        </a>

      </div>

    </div>

  </section>

  <!-- =============================================
       JOIN SECTION
  ============================================== -->
  <section class="join-banner">

    <div class="join-image">

      <img
        src="https://images.unsplash.com/photo-1461023058943-07fcbe16d735?w=500&q=80"
        alt="Coffee"
      >

    </div>

    <div class="join-content">

      <p class="join-text">
        Join us now, and get your drinks started!
      </p>

      <div class="join-steps">

        <div class="step">
          <div class="step-icon">☕</div>
          <span>Choose your brew</span>
        </div>

        <div class="step">
          <div class="step-icon">🛒</div>
          <span>Order and pay</span>
        </div>

        <div class="step">
          <div class="step-icon">😊</div>
          <span>Enjoy!</span>
        </div>

      </div>

    </div>

  </section>

  <!-- =============================================
       FAQ
  ============================================== -->
  <section class="faq-section">

    <h2>Questions?</h2>

    <p>
      We have answers.
      <a href="#">Check out the FAQs</a>
    </p>

  </section>

  <!-- =============================================
       FOOTER
  ============================================== -->
  <footer class="footer">

    <div class="footer-inner">

      <div class="footer-contact">

        <p class="footer-label">Contact us via:</p>

        <p>vibri@gmail.com</p>
        <p>King's Cup Coffee</p>

      </div>

      <div class="footer-copy">

        <p>
          &copy; <?= date('Y') ?> King's Cup Coffee Enterprises. All rights reserved.
        </p>

      </div>

    </div>

  </footer>

  <!-- JS -->
  <script src="main.js"></script>

</body>
</html>