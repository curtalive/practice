<?php include('header.php');
require_once('../config/db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $role = 'user'; // По умолчанию роль пользователя - 'user'

    // Если администратор регистрирует нового пользователя
    if (isset($_POST['role']) && $_POST['role'] == 'admin') {
        $role = 'admin';
    }

    // Хэшируем пароль
    $passwordHash = password_hash($password, PASSWORD_BCRYPT);

    // SQL-запрос на добавление пользователя
    $query = "INSERT INTO Users (Username, Email, PasswordHash, role) VALUES ('$username', '$email', '$passwordHash', '$role')";
    
    if (mysqli_query($conn, $query)) {
        echo "Регистрация прошла успешно.";
    } else {
        echo "Ошибка регистрации: " . mysqli_error($conn); 
    }
}

mysqli_close($conn);
?>
<head>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<div class="container">
    <h2>Регистрация</h2>
    <form class = "login" action="" method="POST">
    <label for="username">Имя пользователя</label>
    <input type="text" name="username" required>

    <label for="email">Email</label>
    <input type="email" name="email" required>

    <label for="password">Пароль</label>
    <input type="password" name="password" required>

    <button type="submit">Зарегистрироваться</button>

    <div class="toggle-link">
        <p>Уже есть аккаунт? <a href="login.php">Войти</a></p>
    </div>
</form>
</div>

<footer>
    <?php include('footer.php'); ?>
</footer>