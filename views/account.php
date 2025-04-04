<?php
session_start();
include('header.php');
require_once('../config/db.php');

if (!isset($_SESSION['user_id'])) {
    echo "<p>Вы не авторизованы. <a href='login.php'>Войдите</a>, чтобы просматривать профиль.</p>";
    exit;
}

$user_id = $_SESSION['user_id'];

$query_user = "SELECT Username, Email FROM Users WHERE UserID = $user_id";
$result_user = mysqli_query($conn, $query_user);
$user = mysqli_fetch_assoc($result_user);

$query_orders = "SELECT OrderID, OrderDate, TotalAmount, Status FROM Orders WHERE UserID = $user_id ORDER BY OrderDate DESC LIMIT 5";
$result_orders = mysqli_query($conn, $query_orders);
?>

<head>
    <link rel="stylesheet" href="../css/styles.css">
</head>

<div class="profile-container">
    <h2>Профиль пользователя</h2>

    <div class="user-info">
        <p><strong>Имя:</strong> <?= htmlspecialchars($user['Username']) ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($user['Email']) ?></p>
    </div>

    <h3>Мои заказы</h3>
    <?php if (mysqli_num_rows($result_orders) > 0): ?>
        <table class="order-history">
            <tr>
                <th>Номер заказа</th>
                <th>Дата</th>
                <th>Сумма</th>
                <th>Статус</th>
            </tr>
            <?php while ($order = mysqli_fetch_assoc($result_orders)) : ?>
                <tr>
                    <td><?= $order['OrderID'] ?></td>
                    <td><?= date('d.m.Y', strtotime($order['OrderDate'])) ?></td>
                    <td><?= $order['TotalAmount'] ?> ₽</td>
                    <td><?= $order['Status'] ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>У вас пока нет заказов.</p>
    <?php endif; ?>

    <form action="logout.php" method="POST">
        <button type="submit" class="logout-btn">Выйти</button>
    </form>
</div>

<footer>
    <?php include('footer.php'); ?>
</footer>
