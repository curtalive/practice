
<?php
session_start(); // Запускаем сессию
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Магазин одежды</title>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="icon" href="../favicon.ico">
</head>

<body>
<header>
    <div class="header-container">
        <!-- Название/Логотип в будущем -->
        <a href="index.php" class="logo">Loomix</a>

        <!-- Поиск -->
        <div class="search-bar">
            <form method="GET" action="catalog.php" class="search-form">
                <input type="text" name="search" class="search-input" placeholder="Поиск товаров..." 
                    value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
                <button type="submit" class="search-button">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>

        <!-- Навигация -->
        <nav>
            <ul>
                <li>
                    <a href="
                        <?php 
                        if (!isset($_SESSION['user_id'])) {
                            echo 'login.php'; // Гость → авторизация
                        } elseif ($_SESSION['role'] == 'admin') {
                            echo 'admin/dashboard.php'; // Админ → админка
                        } else {
                            echo 'profile.php'; // Обычный пользователь → профиль
                        }
                        ?>
                    ">
                        <i class="fas fa-user"></i>
                    </a>
                </li>
                <li>
                    <div class="icons">
                        <a href="cart.php"><i class="fas fa-shopping-cart"></i></a>
                    </div>
                </li>
                <li><a href="index.php">Главная</a></li>
                <li><a href="catalog.php">Каталог</a></li>
                <li><a href="about.php">О нас</a></li>
                <li><a href="contact.php">Контакты</a></li>
                <!-- Кнопка выхода -->
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="logout.php">Выйти</a></li>
                <?php endif; ?>
            </ul>
        </nav>


    </div>
</header>
