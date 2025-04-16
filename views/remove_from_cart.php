<?php
session_start();
require_once('../config/db.php');

// Проверка авторизации
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Проверка наличия ID позиции в корзине
if (!isset($_POST['order_detail_id'])) {
    echo "Ошибка: Не передан товар для удаления.";
    exit;
}

$order_detail_id = (int)$_POST['order_detail_id'];

// Получаем ID заказа пользователя со статусом "Создан"
$user_id = $_SESSION['user_id'];
$query_order = "SELECT OrderID FROM Orders WHERE UserID = $user_id AND Status = 'Создан' LIMIT 1";
$result_order = mysqli_query($conn, $query_order);
$order = mysqli_fetch_assoc($result_order);

if (!$order) {
    header("Location: cart.php");
    exit;
}

$order_id = $order['OrderID'];

// Удаляем товар из OrderDetails
$query_delete = "DELETE FROM OrderDetails WHERE OrderDetailID = $order_detail_id AND OrderID = $order_id";
mysqli_query($conn, $query_delete);

// Обновляем общую сумму заказа
$query_update_total = "UPDATE Orders 
    SET TotalAmount = (SELECT IFNULL(SUM(Quantity * Price), 0) FROM OrderDetails WHERE OrderID = $order_id) 
    WHERE OrderID = $order_id";
mysqli_query($conn, $query_update_total);
  
// Перенаправляем обратно в корзину
header("Location: cart.php");
exit;
?>
