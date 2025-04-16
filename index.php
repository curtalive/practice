<?php 
session_start();
include('views/header.php'); 
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loomix - Главная</title>
    <link rel="stylesheet" href="css/styles.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
</head>
<body>
    <main>

        <section class="slider">
            <h2>Популярные товары</h2>
            <div class="slider-container">
                <div class="slide">
                    <img src="creative/tshirt_white.jpg" alt="Белая футболка">
                    <p>Белая футболка - 1230 ₽</p>
                    <a href="products.php">Подробнее</a>
                </div>
                <div class="slide">
                    <img src="creative/jeans_blue.jpg" alt="Синие джинсы">
                    <p>Синие джинсы - 4340 ₽</p>
                    <a href="products.php">Подробнее</a>
                </div>
                <button class="prev">&#10094;</button>
                <button class="next">&#10095;</button>
            </div>
        </section>

        <?php if (!isset($_SESSION['user_id'])): ?>
        <section class="auth-section">
            <h2>Вход в аккаунт</h2>
            <form action="views/login.php" method="POST">
                <input type="email" name="email" placeholder="Введите email" required>
                <input type="password" name="password" placeholder="Введите пароль" required>
                <button type="submit">Войти</button>
            </form>
            <p>Нет аккаунта? <a href="views/register.php">Зарегистрируйтесь</a></p>
            <a href="#">Забыли пароль?</a>
        </section>
        <?php endif; ?>

        <section class="about">
            <h2>О нас</h2>
            <div class="about-content">
                <img src="creative/hands.png" alt="О компании">
                <p>
                    <?php 
                        $aboutText = file_get_contents("media/text/about.txt");
                        echo nl2br(htmlspecialchars($aboutText));
                    ?>
                </p>
            </div>
        </section>

        <section class="reviews">
            <h2>Отзывы клиентов</h2>
            <div class="review-container">
                <div class="review">
                    <img src="creative/review.png" alt="Клиент 1">
                    <p>"Отличный магазин! Быстрая доставка!"</p>
                    <span>- Алексей, 12.03.2025</span>
                </div>
                <div class="review">
                    <img src="creative/review.png" alt="Клиент 2">
                    <p>"Качественные вещи, рекомендую!"</p>
                    <span>- Мария, 15.03.2025</span>
                </div>
            </div>
        </section>
    </main>

    <?php include('views/footer.php'); ?>
    <script src="js/script.js"></script>
</body>
</html>
  