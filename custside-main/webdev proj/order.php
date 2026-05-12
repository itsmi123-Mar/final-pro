<?php
session_start();
require_once 'db.php';

$products = [
    1 => ['name'=>'Americano', 'sub'=>'Pure strong coffee', 'img'=>'https://images.unsplash.com/photo-1514432324607-a09d9b4aefdd?w=400&q=80', 'cat'=>'espresso'],
    2 => ['name'=>'Spanish Latte', 'sub'=>'Espresso + milk', 'img'=>'https://images.unsplash.com/photo-1578314675249-a6910f80cc4e?w=400&q=80', 'cat'=>'espresso'],
    3 => ['name'=>'Cappuccino', 'sub'=>'Espresso + foam', 'img'=>'https://images.unsplash.com/photo-1572442388796-11668a67e53d?w=400&q=80', 'cat'=>'espresso'],
    4 => ['name'=>'Caramel Macchiato', 'sub'=>'Espresso + caramel', 'img'=>'https://images.unsplash.com/photo-1461023058943-07fcbe16d735?w=400&q=80', 'cat'=>'espresso'],
    5 => ['name'=>'Berry Matcha', 'sub'=>'Matcha + berry', 'img'=>'https://images.unsplash.com/photo-1556679343-c7306c1976bc?w=400&q=80', 'cat'=>'nocoffee'],
];

$sizes = [
    'gato'   => ['label'=>'Gato (16 oz.)', 'calories'=>8, 'price'=>150],
    'grande' => ['label'=>'Grande (20 oz.)', 'calories'=>12, 'price'=>175],
    'venti'  => ['label'=>'Venti (24 oz.)', 'calories'=>16, 'price'=>195],
];

$pid = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$pid || !isset($products[$pid])) {
    header("Location: menu.php");
    exit;
}
$product = $products[$pid];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = filter_input(INPUT_POST, 'product_id', FILTER_VALIDATE_INT);
    $size_key   = $_POST['size'] ?? 'gato';
    $quantity   = max(1, min(20, (int)($_POST['quantity'] ?? 1)));

    if (isset($products[$product_id]) && isset($sizes[$size_key])) {
        $selected_size = $sizes[$size_key];
        $price = $selected_size['price'];
        $total = $price * $quantity;

        if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];

        $found = false;
        foreach ($_SESSION['cart'] as &$item) {
            if ($item['product_id'] == $product_id && $item['size_key'] == $size_key) {
                $item['quantity'] += $quantity;
                $item['total'] = $item['price'] * $item['quantity'];
                $found = true;
                break;
            }
        }

        if (!$found) {
            $_SESSION['cart'][] = [
                'product_id'   => $product_id,
                'product_name' => $products[$product_id]['name'],
                'size_key'     => $size_key,
                'size_label'   => $selected_size['label'],
                'quantity'     => $quantity,
                'price'        => $price,
                'total'        => $total
            ];
        }

        header("Location: view_orders.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order - <?= htmlspecialchars($product['name']) ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<nav class="navbar"><div class="nav-inner">
    <a href="index.php" class="nav-logo"><span class="logo-text">King's Cup</span></a>
    <ul class="nav-links">
        <li><a href="menu.php">Menu</a></li>
        <li><a href="view_orders.php">Cart</a></li>
        <li><a href="order_status.php">Order Status</a></li>
        <li><a href="order_history.php">Order History</a></li>
    </ul>
</div></nav>

<div class="order-page">
    <a href="menu.php" class="btn-back">← Back to Menu</a>
    <div class="order-layout">
        <div class="order-preview">
            <div class="order-preview-img"><img src="<?= htmlspecialchars($product['img']) ?>" alt="<?= htmlspecialchars($product['name']) ?>"></div>
            <div class="order-preview-content"><h2><?= htmlspecialchars($product['name']) ?></h2><p><?= htmlspecialchars($product['sub']) ?></p></div>
        </div>
        <div class="order-form-wrap">
            <form method="POST">
                <input type="hidden" name="product_id" value="<?= $pid ?>">
                <div class="order-field">
                    <label class="order-title">SIZE</label>
                    <div class="size-options">
                        <?php foreach ($sizes as $key => $size): ?>
                            <label class="size-card <?= $key === 'gato' ? 'size-active' : '' ?>">
                                <input type="radio" name="size" value="<?= $key ?>" <?= $key === 'gato' ? 'checked' : '' ?> onchange="updateSize(this)">
                                <span class="size-name"><?= htmlspecialchars($size['label']) ?></span>
                                <span class="size-info"><?= $size['calories'] ?> calories</span>
                                <span class="size-price">₱<?= $size['price'] ?></span>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="order-field">
                    <label class="order-title">QUANTITY</label>
                    <div class="qty-row"><div class="qty-box">
                        <button type="button" class="qty-btn" onclick="changeQty(-1)">-</button>
                        <input type="number" id="qty-input" class="qty-input" name="quantity" value="1" readonly>
                        <button type="button" class="qty-btn" onclick="changeQty(1)">+</button>
                    </div></div>
                </div>
                <div class="order-total">Total: <strong id="order-total-price">₱150</strong></div>
                <button type="submit" class="btn-add-order">ADD TO CART</button>
            </form>
        </div>
    </div>
</div>
<script>const SIZES = { gato:150, grande:175, venti:195 };</script>
<script src="main.js"></script>
</body>
</html>