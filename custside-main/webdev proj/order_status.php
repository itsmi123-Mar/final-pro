<?php
session_start();
require_once 'db.php';

$order_id = $_GET['order_id'] ?? '';
$order_data = null;
$order_items = [];

if (!empty($order_id)) {
    // Get order group info
    $stmt = mysqli_prepare($conn, 
        "SELECT order_group_id, MIN(created_at) as created_at, SUM(total) as total_amount, MAX(status) as status
         FROM orders WHERE order_group_id = ? GROUP BY order_group_id"
    );
    mysqli_stmt_bind_param($stmt, "s", $order_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $order_data = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    // Get items
    if ($order_data) {
        $stmt = mysqli_prepare($conn, "SELECT product_name, product_size, quantity, price, total FROM orders WHERE order_group_id = ?");
        mysqli_stmt_bind_param($stmt, "s", $order_id);
        mysqli_stmt_execute($stmt);
        $items_result = mysqli_stmt_get_result($stmt);
        $order_items = mysqli_fetch_all($items_result, MYSQLI_ASSOC);
        mysqli_stmt_close($stmt);
    }
}

// Get order type from session after placing (default "In-Store")
$order_type = $_SESSION['order_type'] ?? 'In-Store';
unset($_SESSION['order_type']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Status - King's Cup</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .thankyou-container {
            max-width: 800px;
            margin: 40px auto;
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .thankyou-header {
            background: #3b1f0e;
            color: white;
            padding: 30px;
            text-align: center;
        }
        .thankyou-header h1 {
            font-family: 'Playfair Display', serif;
            font-size: 2.5rem;
            margin-bottom: 10px;
        }
        .order-info {
            padding: 30px;
            border-bottom: 1px solid #eee;
        }
        .order-info p {
            margin: 8px 0;
        }
        .order-summary {
            padding: 30px;
        }
        .order-summary table {
            width: 100%;
            border-collapse: collapse;
        }
        .order-summary th, .order-summary td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        .order-summary th {
            background: #f5efe6;
        }
        .total-row {
            font-weight: bold;
            background: #f9f5ef;
        }
        .btn-home {
            display: inline-block;
            background: #c8860a;
            color: white;
            padding: 12px 24px;
            border-radius: 8px;
            text-decoration: none;
            margin: 20px 30px 30px;
        }
        .btn-home:hover {
            background: #a56e08;
        }
        .status-badge {
            display: inline-block;
            padding: 6px 14px;
            border-radius: 20px;
            font-weight: bold;
            font-size: 0.85rem;
        }
        .status-Pending { background: #ffc107; color: #333; }
        .status-Approved { background: #17a2b8; color: white; }
        .status-Ready\ for\ Pickup { background: #28a745; color: white; }
        .status-Completed { background: #6c757d; color: white; }
        .search-form {
            text-align: center;
            margin-top: 30px;
        }
        .search-form input {
            padding: 12px;
            width: 300px;
            border: 1px solid #ddd;
            border-radius: 8px;
        }
        .search-form button {
            padding: 12px 24px;
            background: #3b1f0e;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }
    </style>
</head>
<body>
<nav class="navbar"><div class="nav-inner">
    <a href="index.php" class="nav-logo"><span class="logo-text">King's Cup</span></a>
    <ul class="nav-links">
        <li><a href="menu.php">Menu</a></li>
        <li><a href="view_orders.php">Cart</a></li>
        <li><a href="order_status.php" class="active">Track Order</a></li>
        <li><a href="order_history.php">History</a></li>
    </ul>
</div></nav>

<div class="order-page">
    <?php if (!empty($order_id) && $order_data): ?>
        <div class="thankyou-container">
            <div class="thankyou-header">
                <h1>✨ Thank You! ✨</h1>
                <p>Your order has been received</p>
            </div>
            <div class="order-info">
                <p><strong>Order #</strong> <?= htmlspecialchars($order_data['order_group_id']) ?></p>
                <p><strong>Order Type:</strong> <?= htmlspecialchars($order_type) ?></p>
                <p><strong>Status:</strong> 
                    <span class="status-badge status-<?= str_replace(' ', '_', $order_data['status']) ?>">
                        <?= $order_data['status'] ?>
                    </span>
                </p>
                <p><strong>Placed on:</strong> <?= date('F j, Y \a\t g:i A', strtotime($order_data['created_at'])) ?></p>
            </div>
            <div class="order-summary">
                <h3>Order Summary</h3>
                <table>
                    <thead>
                        <tr><th>Item</th><th>Price</th><th>Quantity</th><th>Subtotal</th></tr>
                    </thead>
                    <tbody>
                        <?php foreach ($order_items as $item): ?>
                            <tr>
                                <td><?= htmlspecialchars($item['product_name']) ?> (<?= htmlspecialchars($item['product_size']) ?>)</td>
                                <td>₱<?= number_format($item['price'], 2) ?></td>
                                <td><?= $item['quantity'] ?></td>
                                <td>₱<?= number_format($item['total'], 2) ?></td>
                            </tr>
                        <?php endforeach; ?>
                        <tr class="total-row">
                            <td colspan="3" style="text-align:right;"><strong>Order Total:</strong></td>
                            <td><strong>₱<?= number_format($order_data['total_amount'], 2) ?></strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <a href="menu.php" class="btn-home">← Back to Menu</a>
        </div>
    <?php else: ?>
        <div style="text-align: center; padding: 50px;">
            <h2>Track Your Order</h2>
            <form method="GET" class="search-form">
                <input type="text" name="order_id" placeholder="Enter your Order ID (e.g. ORD_...)" required>
                <button type="submit">Track Order</button>
            </form>
            <?php if (!empty($order_id) && !$order_data): ?>
                <p style="color: red; margin-top: 20px;">❌ Order not found. Please check your Order ID.</p>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>
</body>
</html>