<?php
// Настройки подключения к базе данных
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'clothing_store';

// Создание соединения
$conn = mysqli_connect($host, $user, $password, $dbname);
// Проверка соединения
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
 