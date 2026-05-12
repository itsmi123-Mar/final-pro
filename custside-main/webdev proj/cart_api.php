<?php
session_start();
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'error' => 'Invalid method']);
    exit;
}

$action = $_POST['action'] ?? '';
$index  = (int)($_POST['index'] ?? -1);

if (!isset($_SESSION['cart']) || $index < 0 || $index >= count($_SESSION['cart'])) {
    echo json_encode(['success' => false, 'error' => 'Invalid item']);
    exit;
}

if ($action === 'remove') {
    array_splice($_SESSION['cart'], $index, 1);
    echo json_encode(['success' => true]);
}
elseif ($action === 'update_qty') {
    $new_qty = max(1, min(20, (int)($_POST['qty'] ?? 1)));
    $_SESSION['cart'][$index]['quantity'] = $new_qty;
    $_SESSION['cart'][$index]['total'] = $_SESSION['cart'][$index]['price'] * $new_qty;
    echo json_encode(['success' => true]);
}
else {
    echo json_encode(['success' => false, 'error' => 'Unknown action']);
}
?>