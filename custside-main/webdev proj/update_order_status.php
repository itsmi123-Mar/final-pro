<?php
require_once 'db.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'error' => 'Invalid method']);
    exit;
}

$order_group_id = $_POST['order_group_id'] ?? '';
$new_status = $_POST['status'] ?? '';

$allowed = ['Approved', 'Ready for Pickup', 'Completed'];
if (!in_array($new_status, $allowed)) {
    echo json_encode(['success' => false, 'error' => 'Invalid status']);
    exit;
}

// Update all rows with the same order_group_id
$stmt = mysqli_prepare($conn, "UPDATE orders SET status = ? WHERE order_group_id = ?");
mysqli_stmt_bind_param($stmt, "ss", $new_status, $order_group_id);
$result = mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

if ($result) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'Database error']);
}
?>