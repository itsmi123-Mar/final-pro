<?php
session_start();
require_once 'db.php';

// Handle place order
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['place_order'])) {
    if (!empty($_SESSION['cart'])) {
        $order_group_id = 'ORD_' . date('YmdHis') . '_' . uniqid();
        $status = 'Pending';
        $payment_method = $_POST['payment_method'] ?? 'Gcash'; // Get selected payment method

        foreach ($_SESSION['cart'] as $item) {
            $stmt = mysqli_prepare($conn,
                "INSERT INTO orders (order_group_id, product_id, product_name, product_size, quantity, price, total, status, payment_method)
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)"
            );
            mysqli_stmt_bind_param($stmt, "sissiddss",
                $order_group_id,
                $item['product_id'],
                $item['product_name'],
                $item['size_label'],
                $item['quantity'],
                $item['price'],
                $item['total'],
                $status,
                $payment_method
            );
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }

        $_SESSION['cart'] = [];
        $_SESSION['order_placed'] = $order_group_id;
        header("Location: view_orders.php?placed=1");
        exit;
    }
}

$cart = $_SESSION['cart'] ?? [];
$success = isset($_GET['placed']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>King's Cup | Checkout</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .checkout-table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 24px rgba(0,0,0,0.1);
        }
        .checkout-table th {
            background: #3b1f0e;
            color: white;
            padding: 14px;
            text-align: left;
        }
        .checkout-table td {
            padding: 14px;
            border-bottom: 1px solid #eee;
            vertical-align: middle;
        }
        .qty-control {
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .qty-control button {
            background: #f0e6d8;
            border: none;
            width: 28px;
            height: 28px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
        }
        .qty-control button:hover {
            background: #c8860a;
            color: white;
        }
        .qty-control span {
            min-width: 30px;
            text-align: center;
        }
        .remove-btn {
            background: #c0392b;
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 6px;
            cursor: pointer;
        }
        .remove-btn:hover {
            background: #a82313;
        }
        .order-total-row {
            font-weight: bold;
            background: #f9f5ef;
        }
        .btn-place {
            background: #2c5e2e;
        }
        .btn-place:hover {
            background: #1e4620;
        }
        .btn-add-more {
            background: #c8860a;
        }
        .btn-add-more:hover {
            background: #a56e08;
        }
        .action-buttons {
            display: flex;
            justify-content: flex-end;
            gap: 15px;
            margin-top: 30px;
        }
        .payment-section {
            background: #f9f5ef;
            padding: 20px;
            border-radius: 12px;
            margin-top: 20px;
            display: flex;
            gap: 30px;
            align-items: center;
        }
        .payment-section label {
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: bold;
            cursor: pointer;
        }
        .payment-section input[type="radio"] {
            width: 18px;
            height: 18px;
            cursor: pointer;
        }
    </style>
</head>
<body>
<nav class="navbar"><div class="nav-inner">
    <a href="index.php" class="nav-logo"><span class="logo-text">King's Cup</span></a>
    <ul class="nav-links">
        <li><a href="menu.php">Menu</a></li>
        <li><a href="view_orders.php" class="active">View Orders</a></li>
        <li><a href="order_status.php">Order Status</a></li>
        <li><a href="order_history.php">Order History</a></li>
    </ul>
</div></nav>

<div class="order-page">
    <h1 style="margin-bottom:20px;">King's Cup | Checkout</h1>

    <?php if ($success): ?>
        <div style="background:#d4edda; padding:12px; border-radius:8px; margin-bottom:20px;">
            ✅ Order placed successfully! Your order ID is: <strong><?= htmlspecialchars($_SESSION['order_placed'] ?? '') ?></strong>. You can track it using Order Status.
        </div>
        <?php unset($_SESSION['order_placed']); ?>
    <?php endif; ?>

    <?php if (empty($cart)): ?>
        <div style="background:#fff3cd; padding:20px; border-radius:12px; text-align:center;">
            <p>Your cart is empty. <a href="menu.php" style="color:#c8860a;">Browse Menu →</a></p>
        </div>
    <?php else: ?>
        <form method="POST" id="placeOrderForm">
            <table class="checkout-table">
                <thead>
                    <tr><th>Products Ordered</th><th>Unit Price</th><th>Quantity</th><th>Item Subtotal</th><th></th></tr>
                </thead>
                <tbody id="cart-items">
                    <?php foreach ($cart as $idx => $item): ?>
                        <tr data-index="<?= $idx ?>">
                            <td><?= htmlspecialchars($item['product_name']) . ' (' . htmlspecialchars($item['size_label']) . ')' ?></td>
                            <td>₱<?= number_format($item['price'], 2) ?></td>
                            <td>
                                <div class="qty-control">
                                    <button type="button" class="qty-down" data-index="<?= $idx ?>" data-delta="-1">-</button>
                                    <span class="qty-val"><?= $item['quantity'] ?></span>
                                    <button type="button" class="qty-up" data-index="<?= $idx ?>" data-delta="1">+</button>
                                </div>
                            </td>
                            <td class="item-subtotal">₱<?= number_format($item['total'], 2) ?></td>
                            <td><button type="button" class="remove-btn" data-index="<?= $idx ?>">Remove</button></td>
                        </tr>
                    <?php endforeach; ?>
                    <tr class="order-total-row">
                        <td colspan="3" style="text-align:right;">Order Total:</td>
                        <td colspan="2" id="grand-total">₱<?= number_format(array_sum(array_column($cart, 'total')), 2) ?></td>
                    </tr>
                </tbody>
            </table>

            <!-- Payment Method Selection -->
            <div class="payment-section">
                <span style="font-weight:bold;">Payment Method:</span>
                <label>
                    <input type="radio" name="payment_method" value="Gcash" checked> 💸 Gcash
                </label>
                <label>
                    <input type="radio" name="payment_method" value="Maya"> 💳 Maya
                </label>
            </div>

            <div class="action-buttons">
                <a href="menu.php" class="btn-add-order btn-add-more" style="text-decoration:none; text-align:center; line-height:normal;">➕ Add More Items</a>
                <button type="submit" name="place_order" value="1" class="btn-add-order btn-place" onclick="return confirm('Place order now?');">✔️ Place Order</button>
            </div>
        </form>
    <?php endif; ?>
</div>

<script>
    async function updateCart(action, index, qty = null) {
        const formData = new URLSearchParams();
        formData.append('action', action);
        formData.append('index', index);
        if (qty !== null) formData.append('qty', qty);

        const res = await fetch('cart_api.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: formData
        });
        const data = await res.json();
        if (data.success) {
            location.reload();
        } else {
            alert('Error updating cart');
        }
    }

    document.querySelectorAll('.remove-btn').forEach(btn => {
        btn.addEventListener('click', (e) => {
            const idx = btn.dataset.index;
            updateCart('remove', idx);
        });
    });

    document.querySelectorAll('.qty-down, .qty-up').forEach(btn => {
        btn.addEventListener('click', (e) => {
            const idx = btn.dataset.index;
            const delta = parseInt(btn.dataset.delta);
            const qtySpan = btn.parentElement.querySelector('.qty-val');
            let newQty = parseInt(qtySpan.innerText) + delta;
            if (newQty < 1) newQty = 1;
            if (newQty > 20) newQty = 20;
            if (newQty !== parseInt(qtySpan.innerText)) {
                updateCart('update_qty', idx, newQty);
            }
        });
    });
</script>
</body>
</html>