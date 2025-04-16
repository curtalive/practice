<?php
session_start();
include('header.php');
require_once('../config/db.php');

if (!isset($_SESSION['user_id'])) {
    echo "<p>Вы не авторизованы. <a href='login.php'>Войдите</a>, чтобы управлять корзиной.</p>";
    exit;
}

$user_id = $_SESSION['user_id'];

$query_order = "SELECT OrderID FROM Orders WHERE UserID = $user_id AND Status = 'Создан' LIMIT 1";
$result_order = mysqli_query($conn, $query_order);
$order = mysqli_fetch_assoc($result_order);

if (!$order) {
    $query_create_order = "INSERT INTO Orders (UserID, TotalAmount, Status) VALUES ($user_id, 0, 'Создан')";
    if (mysqli_query($conn, $query_create_order)) {
        $order_id = mysqli_insert_id($conn);
    } else {
        echo "Ошибка при создании заказа: " . mysqli_error($conn);
        exit;
    }
} else {
    $order_id = $order['OrderID'];
}
  
$query_cart = "
    SELECT od.OrderDetailID, p.ProductID, p.ProductName, p.ImageURL, od.Quantity, od.Size, od.Price
    FROM OrderDetails od
    JOIN Products p ON od.ProductID = p.ProductID
    WHERE od.OrderID = $order_id
";
$result_cart = mysqli_query($conn, $query_cart);
?>

<head>
    <link rel="stylesheet" href="../css/styles.css">
</head>

<div class="cart-container">
    <h2>Корзина</h2>

    <?php if (mysqli_num_rows($result_cart) > 0): ?>
        <table>
            <tr>
                <th>Изображение</th>
                <th>Название</th>
                <th>Размер</th>
                <th>Количество</th>
                <th>Цена</th>
                <th>Удалить</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($result_cart)): ?>
                <tr>
                    <td><img src="../<?= $row['ImageURL'] ?>" alt="<?= $row['ProductName'] ?>" width="50"></td>
                    <td><?= $row['ProductName'] ?></td>
                    <td><?= $row['Size'] ?></td>
                    <td><?= $row['Quantity'] ?></td>
                    <td><?= $row['Price'] * $row['Quantity'] ?> ₽</td>
                    <td>
                        <form method="POST" action="remove_from_cart.php">
                            <input type="hidden" name="order_detail_id" value="<?= $row['OrderDetailID'] ?>">
                            <button type="submit">Удалить</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
        <form method="POST" action="checkout.php">
            <button type="submit">Оформить заказ</button>
        </form>
    <?php else: ?>
        <p>Ваша корзина пуста.</p>
    <?php endif; ?>
</div>

<footer>
    <?php include('footer.php'); ?>
</footer>
