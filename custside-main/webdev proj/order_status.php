<?php
session_start();
require_once 'db.php';

$search = $_GET['order_id'] ?? '';
$order_items = [];
if (!empty($search)) {
    $stmt = mysqli_prepare($conn, "SELECT * FROM orders WHERE order_group_id = ?");
    mysqli_stmt_bind_param($stmt, "s", $search);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $order_items = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_stmt_close($stmt);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Status</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<nav class="navbar"><div class="nav-inner">
    <a href="index.php" class="nav-logo"><span class="logo-text">King's Cup</span></a>
    <ul class="nav-links">
        <li><a href="menu.php">Menu</a></li>
        <li><a href="view_orders.php">Cart</a></li>
        <li><a href="order_status.php" class="active">Order Status</a></li>
        <li><a href="order_history.php">Order History</a></li>
    </ul>
</div></nav>

<div class="order-page">
    <h1>Track Your Order</h1>
    <form method="GET" style="margin-bottom:30px;">
        <input type="text" name="order_id" placeholder="Enter Order ID (e.g. ORD_...)" required style="padding:14px; width:280px; border-radius:8px;">
        <button type="submit" class="btn-add-order" style="width:auto; padding:14px 22px;">CHECK STATUS</button>
    </form>

    <?php if (!empty($search) && empty($order_items)): ?>
        <p>No order found with ID: <?= htmlspecialchars($search) ?></p>
    <?php elseif (!empty($order_items)): ?>
        <div style="background:white; padding:30px; border-radius:12px;">
            <h2>Order #<?= htmlspecialchars($search) ?></h2>
            <table style="width:100%; border-collapse:collapse;">
                <tr style="background:#f5efe6;"><th>Product</th><th>Size</th><th>Qty</th><th>Price</th><th>Total</th><th>Status</th></tr>
                <?php foreach ($order_items as $item): ?>
                    <tr style="border-bottom:1px solid #ddd;">
                        <td style="padding:12px;"><?= htmlspecialchars($item['product_name']) ?></td>
                        <td><?= htmlspecialchars($item['product_size']) ?></td>
                        <td><?= $item['quantity'] ?></td>
                        <td>₱<?= number_format($item['price'],2) ?></td>
                        <td>₱<?= number_format($item['total'],2) ?></td>
                        <td><span style="color:<?= $item['status']=='Pending'?'orange':'green' ?>;"><?= $item['status'] ?></span></td>
                    </tr>
                <?php endforeach; ?>
            </table>
            <p style="margin-top:20px;"><strong>Ordered at:</strong> <?= $order_items[0]['created_at'] ?? '' ?></p>
        </div>
    <?php endif; ?>
</div>
</body>
</html>