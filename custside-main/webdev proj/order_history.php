<?php
require_once 'db.php';
$group_query = "SELECT order_group_id, MIN(created_at) as created_at, SUM(total) as total_amount, MAX(status) as status
                FROM orders GROUP BY order_group_id ORDER BY created_at DESC";
$result = mysqli_query($conn, $group_query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order History</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<nav class="navbar"><div class="nav-inner">
    <a href="index.php" class="nav-logo"><span class="logo-text">King's Cup</span></a>
    <ul class="nav-links">
        <li><a href="menu.php">Menu</a></li>
        <li><a href="view_orders.php">Cart</a></li>
        <li><a href="order_status.php">Order Status</a></li>
        <li><a href="order_history.php" class="active">Order History</a></li>
    </ul>
</div></nav>

<div class="order-page">
    <h1>Your Order History</h1>
    <div style="overflow-x:auto;">
        <table style="width:100%; background:white; border-radius:12px; overflow:hidden;">
            <tr style="background:#3b1f0e; color:white;"><th>Order ID</th><th>Date</th><th>Total</th><th>Status</th><th></th></tr>
            <?php while($row = mysqli_fetch_assoc($result)): ?>
                <tr style="border-bottom:1px solid #ddd; text-align:center;">
                    <td style="padding:14px;"><?= htmlspecialchars($row['order_group_id']) ?></td>
                    <td><?= $row['created_at'] ?></td>
                    <td>₱<?= number_format($row['total_amount'],2) ?></td>
                    <td><?= htmlspecialchars($row['status']) ?></td>
                    <td><a href="order_status.php?order_id=<?= urlencode($row['order_group_id']) ?>" class="btn-check" style="background:#c8860a;">View</a></td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>
</div>
</body>
</html>