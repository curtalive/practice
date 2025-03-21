<?php include('header.php'); 
session_start();
require_once('../config/db.php');

// Проверяем, была ли отправлена форма
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Получаем данные пользователя из базы данных
    $query = "SELECT * FROM Users WHERE Email = '$email'";
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);

    if ($user && password_verify($password, $user['PasswordHash'])) {
        // Устанавливаем сессию
        $_SESSION['user_id'] = $user['UserID'];
        $_SESSION['role'] = $user['role'];  // Сохраняем роль пользователя в сессии

        // Перенаправляем на главную страницу или в панель администратора
        if ($_SESSION['role'] == 'admin') {
            header('Location: ../admin/dashboard.php');  // Для администратора
        } else {
            header('Location: profile.php');   // Для обычного пользователя
        }
    } else {
        echo "Неверные данные для входа.";
    }
}
 
mysqli_close($conn);
?>
<head>
<link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    
<div class="container">
    <h2>Авторизация</h2>
        <form class = "login" action="login.php" method="POST">
            <div class="form-group">
                <label for="email">Электронная почта:</label>
                <input type="email" id="email" name="email" placeholder="Введите email" required>
                <div class="error"></div>
            </div>

            <div class="form-group">
                <label for="password">Пароль:</label>
                <input type="password" id="password" name="password" placeholder="Введите пароль" required>
                <div class="error"></div>
            </div>

            <button class="login_button" type="submit">Войти</button>
            
            <div class="toggle-link">
                <p>Нет аккаунта? <a href="register.php">Зарегистрироваться</a></p>
            </div>
        </form>

</div>
    <?php include('footer.php'); ?>
</body>