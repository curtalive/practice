<?php include('header.php'); ?>
<?php require_once('../config/db.php'); ?>

<?php
$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $age = (int) $_POST['age'];
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);
    $agree = isset($_POST['agree']); // Проверяем, установлена ли галочка согласия

    // Валидация
    if (empty($username) || empty($lastname) || empty($email) || empty($password) || empty($confirm_password) || !$agree) {
        $errors[] = "Все поля обязательны для заполнения.";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Некорректный email.";
    }
    if ($password !== $confirm_password) {
        $errors[] = "Пароли не совпадают.";
    }
    if ($age < 18) {
        $errors[] = "Возраст должен быть 18 лет или старше.";
    }

    if (empty($errors)) {
        // Хэшируем пароль
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);
        $query = "INSERT INTO Users (Username, Email, PasswordHash, role) VALUES ('$username', '$email', '$passwordHash', 'user')";
        
        if (mysqli_query($conn, $query)) {
            echo "<p class='success'>Регистрация прошла успешно. <a href='login.php'>Войти</a></p>";
        } else {
            $errors[] = "Ошибка регистрации: " . mysqli_error($conn);
        }
    }
}

mysqli_close($conn);
?>

<head>
    <link rel="stylesheet" href="../css/styles.css">
</head>

<div class="container">
    <h2>Регистрация</h2>

    <?php if (!empty($errors)): ?>
        <div class="error-box">
            <?php foreach ($errors as $error): ?>
                <p class="error"><?= htmlspecialchars($error) ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form class="login" action="register.php" method="POST">
        <label for="username">Имя</label>
        <input type="text" name="username" required>

        <label for="lastname">Фамилия</label>
        <input type="text" name="lastname" required>

        <label for="email">Email</label>
        <input type="email" name="email" required>

        <label for="age">Возраст</label>
        <input type="number" name="age" min="18" required>

        <label for="gender">Пол</label>
        <select name="gender" required>
            <option value="male">Мужской</option>
            <option value="female">Женский</option>
        </select>

        <label for="password">Пароль</label>
        <input type="password" name="password" required>

        <label for="confirm_password">Повтор пароля</label>
        <input type="password" name="confirm_password" required>

        <label class="checkbox">
            <input type="checkbox" name="agree" required> Я соглашаюсь на обработку персональных данных
        </label>

        <button type="submit">Зарегистрироваться</button>

        <div class="toggle-link">
            <p>Уже есть аккаунт? <a href="login.php">Войти</a></p>
        </div>
    </form>
</div>

<footer>
    <?php include('footer.php'); ?>
</footer>
