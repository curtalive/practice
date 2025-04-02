<?php
session_start();
require_once('../config/db.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$product_id = $_POST['product_id'] ?? null;
$quantity = 1; 

if (!$product_id) {
    die("Ошибка: не указан товар.");
}

$query_order = "SELECT OrderID FROM Orders WHERE UserID = $user_id AND Status = 'Создан' LIMIT 1";
$result_order = mysqli_query($conn, $query_order);
$order = mysqli_fetch_assoc($result_order);

if (!$order) {
    $query_create_order = "INSERT INTO Orders (UserID, TotalAmount, Status) VALUES ($user_id, 0, 'Создан')";
    if (mysqli_query($conn, $query_create_order)) {
        $order_id = mysqli_insert_id($conn);
    } else {
        die("Ошибка при создании заказа: " . mysqli_error($conn));
    }
} else {
    $order_id = $order['OrderID'];
}

$query_check = "SELECT OrderDetailID, Quantity FROM OrderDetails WHERE OrderID = $order_id AND ProductID = $product_id LIMIT 1";
$result_check = mysqli_query($conn, $query_check);
$existing_item = mysqli_fetch_assoc($result_check);

if ($existing_item) {
    $new_quantity = $existing_item['Quantity'] + $quantity;
    $query_update = "UPDATE OrderDetails SET Quantity = $new_quantity WHERE OrderDetailID = {$existing_item['OrderDetailID']}";
    mysqli_query($conn, $query_update);
} else {
    $query_product = "SELECT Price FROM Products WHERE ProductID = $product_id LIMIT 1";
    $result_product = mysqli_query($conn, $query_product);
    $product = mysqli_fetch_assoc($result_product);
    $price = $product['Price'];
    $size = $_POST['size'] ?? 'M';

    $query_insert = "INSERT INTO OrderDetails (OrderID, ProductID, Quantity, Price, Size) 
        VALUES ($order_id, $product_id, $quantity, $price, '$size')";
    mysqli_query($conn, $query_insert);
}

header("Location: cart.php");
exit;
?>
