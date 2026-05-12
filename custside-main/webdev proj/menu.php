<?php
// =============================================
// King's Cup Coffee — Menu Page
// =============================================

$categories = [

  'espresso' => [
    'label' => 'Espresso Blends',
    'items' => [

      [
        'id'    => 1,
        'name'  => 'Americano',
        'desc'  => 'Pure strong coffee with a bold and smooth finish.',
        'img'   => 'https://images.unsplash.com/photo-1514432324607-a09d9b4aefdd?w=400&q=80',
        'price' => 150,
      ],

      [
        'id'    => 2,
        'name'  => 'Spanish Latte',
        'desc'  => 'Creamy espresso blended with sweet milk.',
        'img'   => 'https://images.unsplash.com/photo-1578314675249-a6910f80cc4e?w=400&q=80',
        'price' => 175,
      ],

      [
        'id'    => 3,
        'name'  => 'Cappuccino',
        'desc'  => 'Classic espresso topped with silky foam.',
        'img'   => 'https://images.unsplash.com/photo-1572442388796-11668a67e53d?w=400&q=80',
        'price' => 165,
      ],

      [
        'id'    => 4,
        'name'  => 'Caramel Macchiato',
        'desc'  => 'Espresso with vanilla milk and caramel drizzle.',
        'img'   => 'https://images.unsplash.com/photo-1461023058943-07fcbe16d735?w=400&q=80',
        'price' => 185,
      ],

    ],
  ],

  'pastries' => [
    'label' => 'Fresh Pastries',
    'items' => [

      [
        'id'    => 5,
        'name'  => 'Butter Croissant',
        'desc'  => 'Flaky and buttery pastry baked fresh daily.',
        'img'   => 'https://images.unsplash.com/photo-1555507036-ab1f4038808a?w=400&q=80',
        'price' => 95,
      ],

      [
        'id'    => 6,
        'name'  => 'Choco Chocolate',
        'desc'  => 'Chocolate-filled pastry topped with almonds.',
        'img'   => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?w=400&q=80',
        'price' => 110,
      ],

      [
        'id'    => 7,
        'name'  => 'Cheese Danish',
        'desc'  => 'Sweet pastry filled with rich cream cheese.',
        'img'   => 'https://images.unsplash.com/photo-1571115177098-24ec42ed204d?w=400&q=80',
        'price' => 100,
      ],

    ],
  ],

  'nocoffee' => [
    'label' => 'Cold Drinks',
    'items' => [

      [
        'id'    => 8,
        'name'  => 'Berry Matcha',
        'desc'  => 'Refreshing matcha with berry flavors.',
        'img'   => 'https://images.unsplash.com/photo-1556679343-c7306c1976bc?w=400&q=80',
        'price' => 165,
      ],

      [
        'id'    => 9,
        'name'  => 'Hibi-berry Tea',
        'desc'  => 'Hibiscus tea infused with sweet berries.',
        'img'   => 'https://images.unsplash.com/photo-1582479977511-f0bf69ebeb87?w=400&q=80',
        'price' => 150,
      ],

      [
        'id'    => 10,
        'name'  => 'Peach Oolong',
        'desc'  => 'Light oolong tea blended with peach syrup.',
        'img'   => 'https://images.unsplash.com/photo-1556679343-c7306c1976bc?w=400&q=80',
        'price' => 155,
      ],

    ],
  ],

];

$active_cat = isset($_GET['cat']) && array_key_exists($_GET['cat'], $categories)
  ? $_GET['cat']
  : 'espresso';

?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="UTF-8">

  <meta
    name="viewport"
    content="width=device-width, initial-scale=1.0"
  >

  <title>
    Menu — King's Cup Coffee
  </title>

  <link rel="preconnect" href="https://fonts.googleapis.com">

  <link
    rel="preconnect"
    href="https://fonts.gstatic.com"
    crossorigin
  >

  <link
    href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Lato:wght@300;400;700&display=swap"
    rel="stylesheet"
  >

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

        <span class="logo-text">
          King's Cup
        </span>

      </a>

      <ul class="nav-links">

        <li>
          <a href="menu.php" class="active">
            Menu
          </a>
        </li>

        <li>
          <a href="view_orders.php">
            View Orders
          </a>
        </li>

        <li>
          <a href="#">
            Order Status
          </a>
        </li>

        <li>
          <a href="#">
            Order History
          </a>
        </li>

      </ul>

      <a href="#" class="btn-login">
        Login / Sign Up
      </a>

      <button
        class="hamburger"
        id="hamburger"
        aria-label="Toggle menu"
      >
        ☰
      </button>

    </div>

  </nav>

  <!-- =============================================
       MENU HERO
  ============================================== -->
  <section class="menu-hero">

    <img
      src="https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?w=1200&q=80"
      alt="Coffee Menu"
      class="menu-hero-bg"
    >

    <div class="menu-hero-overlay"></div>

    <div class="menu-hero-content">

      <p class="menu-label">
        King's Cup Menu
      </p>

      <h1>
        Brewed With Passion
      </h1>

      <p class="menu-desc">
        Explore handcrafted espresso drinks,
        refreshing beverages, and freshly baked pastries.
      </p>

    </div>

  </section>

  <!-- =============================================
       MENU PAGE
  ============================================== -->
  <section class="menu-page">

    <!-- SIDEBAR -->
    <aside class="menu-sidebar">

      <h2>
        Categories
      </h2>

      <a
        href="menu.php?cat=espresso"
        class="menu-category <?= $active_cat === 'espresso' ? 'menu-category-active' : '' ?>"
      >
        Espresso Blends
      </a>

      <a
        href="menu.php?cat=pastries"
        class="menu-category <?= $active_cat === 'pastries' ? 'menu-category-active' : '' ?>"
      >
        Fresh Pastries
      </a>

      <a
        href="menu.php?cat=nocoffee"
        class="menu-category <?= $active_cat === 'nocoffee' ? 'menu-category-active' : '' ?>"
      >
        Cold Drinks
      </a>

    </aside>

    <!-- PRODUCTS -->
    <div class="menu-products">

      <div class="menu-top">

        <h2>
          <?= htmlspecialchars($categories[$active_cat]['label']) ?>
        </h2>

      </div>

      <div class="menu-products-grid">

        <?php foreach ($categories[$active_cat]['items'] as $item): ?>

          <div class="menu-card">

            <div class="card-img-wrap">

              <img
                src="<?= htmlspecialchars($item['img']) ?>"
                alt="<?= htmlspecialchars($item['name']) ?>"
              >

            </div>

            <h3>
              <?= htmlspecialchars($item['name']) ?>
            </h3>

            <p>
              <?= htmlspecialchars($item['desc']) ?>
            </p>

            <div class="menu-card-bottom">

              <span class="menu-price">
                ₱<?= number_format($item['price']) ?>
              </span>

              <a
                href="order.php?id=<?= $item['id'] ?>"
                class="btn-check"
              >
                Order Now
              </a>

            </div>

          </div>

        <?php endforeach; ?>

      </div>

    </div>

  </section>

  <!-- =============================================
       FOOTER
  ============================================== -->
  <footer class="footer">

    <div class="footer-inner">

      <div class="footer-contact">

        <p class="footer-label">
          Contact us via:
        </p>

        <p>
          vibri@gmail.com
        </p>

        <p>
          King's Cup Coffee
        </p>

      </div>

      <div class="footer-copy">

        <p>
          &copy; <?= date('Y') ?>
          King's Cup Coffee Enterprises.
          All rights reserved.
        </p>

      </div>

    </div>

  </footer>

  <script src="main.js"></script>

</body>
</html>