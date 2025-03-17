-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Мар 17 2025 г., 14:41
-- Версия сервера: 8.0.30
-- Версия PHP: 8.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `clothing_store`
--

-- --------------------------------------------------------

--
-- Структура таблицы `Categories`
--

CREATE TABLE `Categories` (
  `CategoryID` int NOT NULL,
  `CategoryName` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `Categories`
--

INSERT INTO `Categories` (`CategoryID`, `CategoryName`) VALUES
(5, 'Аксессуары'),
(2, 'Джинсы'),
(3, 'Куртки'),
(4, 'Обувь'),
(1, 'Футболки');

-- --------------------------------------------------------

--
-- Структура таблицы `OrderDetails`
--

CREATE TABLE `OrderDetails` (
  `OrderDetailID` int NOT NULL,
  `OrderID` int NOT NULL,
  `ProductID` int NOT NULL,
  `Quantity` int NOT NULL,
  `Size` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `Orders`
--

CREATE TABLE `Orders` (
  `OrderID` int NOT NULL,
  `UserID` int NOT NULL,
  `OrderDate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `TotalAmount` decimal(10,2) DEFAULT NULL,
  `Status` enum('Создан','В процессе','Завершен','Отменен') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'Создан'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `Products`
--

CREATE TABLE `Products` (
  `ProductID` int NOT NULL,
  `ProductName` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `Price` decimal(10,2) NOT NULL,
  `DiscountedPrice` decimal(10,2) DEFAULT NULL,
  `Stock` int NOT NULL,
  `Size` enum('XS','S','M','L','XL','XXL','None') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `CategoryID` int NOT NULL,
  `PromotionID` int DEFAULT NULL,
  `ImageURL` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `Products`
--

INSERT INTO `Products` (`ProductID`, `ProductName`, `Description`, `Price`, `DiscountedPrice`, `Stock`, `Size`, `CategoryID`, `PromotionID`, `ImageURL`) VALUES
(11, 'Белая футболка', 'Классическая белая футболка из хлопка', '123.00', '123.00', 1213, 'M', 1, NULL, 'images/tshirt_white.jpg'),
(12, 'Синие джинсы', 'Узкие джинсы с высокой посадкой', '434.00', '434.00', 122, 'L', 2, NULL, 'images/jeans_blue.jpg'),
(13, 'Кожаная куртка', 'Стильная черная куртка из натуральной кожи', '9990.00', '9990.00', 6, 'XL', 3, NULL, 'images/jacket_black.jpg'),
(14, 'Кроссовки Nike', 'Легкие и удобные спортивные кроссовки', '7490.00', '7490.00', 298, 'None', 4, NULL, 'images/nike_shoes.jpg'),
(15, 'Часы Casio', 'Электронные наручные часы с подсветкой', '3990.00', '3990.00', 14, 'None', 5, NULL, 'images/casio_watch.jpg'),
(18, 'Кофта', 'wef', '123.00', '98.40', 123, 'XS', 5, 1, 'images/adidas_hoodie.jpg'),
(19, 'Кофта', 'dfbdfb', '1233.00', '1233.00', 1232, 'XS', 3, 4, 'images/adidas_hoodie.jpg'),
(20, 'Черная футболка', 'Классическая черная футболка', '1200.00', '960.00', 10, 'XS', 1, 1, 'images/black_shirt.jpg'),
(21, 'Кофта', 'уау', '500.00', '500.00', 12, 'XS', 1, NULL, '');

-- --------------------------------------------------------

--
-- Структура таблицы `Promotions`
--

CREATE TABLE `Promotions` (
  `PromotionID` int NOT NULL,
  `PromotionName` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `DiscountPercentage` decimal(5,2) NOT NULL,
  `StartDate` date NOT NULL,
  `EndDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `Promotions`
--

INSERT INTO `Promotions` (`PromotionID`, `PromotionName`, `DiscountPercentage`, `StartDate`, `EndDate`) VALUES
(1, 'Весенняя распродажа', '20.00', '2025-03-01', '2025-03-31'),
(3, 'Весенняя распродажа', '15.00', '2025-03-05', '2025-03-31'),
(4, 'Черная пятница', '50.00', '2025-11-11', '2025-11-12');

-- --------------------------------------------------------

--
-- Структура таблицы `Users`
--

CREATE TABLE `Users` (
  `UserID` int NOT NULL,
  `Username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `PasswordHash` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `RegistrationDate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `role` enum('admin','user') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `Users`
--

INSERT INTO `Users` (`UserID`, `Username`, `Email`, `PasswordHash`, `RegistrationDate`, `role`) VALUES
(4, 'Vovchik', 'curtalive@vk.com', '$2y$10$FBm0H/uFaTMa40Ss3n8lH.sZHE5OVQntbYJQst9rkP7T9//ya4zh.', '2025-02-14 08:26:27', 'admin'),
(5, 'Anton', 'Halahanus@tutu.ru', '$2y$10$wg/tjv/iaGUV574AkS.1V.6/M7yltnVvER8KmSsZ2q/8Wz6cxtLyO', '2025-02-14 08:30:04', 'user'),
(10, 'jggjhg', 'weg@vk.com', '$2y$10$bnzgBI0j5wbS9mAUFLod0.DXTTpu/bYUMmhE/ww2LFds4cru9jb3q', '2025-01-07 08:06:12', 'user');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `Categories`
--
ALTER TABLE `Categories`
  ADD PRIMARY KEY (`CategoryID`),
  ADD UNIQUE KEY `CategoryName` (`CategoryName`);

--
-- Индексы таблицы `OrderDetails`
--
ALTER TABLE `OrderDetails`
  ADD PRIMARY KEY (`OrderDetailID`),
  ADD KEY `OrderID` (`OrderID`),
  ADD KEY `ProductID` (`ProductID`);

--
-- Индексы таблицы `Orders`
--
ALTER TABLE `Orders`
  ADD PRIMARY KEY (`OrderID`),
  ADD KEY `UserID` (`UserID`);

--
-- Индексы таблицы `Products`
--
ALTER TABLE `Products`
  ADD PRIMARY KEY (`ProductID`),
  ADD KEY `CategoryID` (`CategoryID`),
  ADD KEY `PromotionID` (`PromotionID`);

--
-- Индексы таблицы `Promotions`
--
ALTER TABLE `Promotions`
  ADD PRIMARY KEY (`PromotionID`);

--
-- Индексы таблицы `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `Username` (`Username`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `Categories`
--
ALTER TABLE `Categories`
  MODIFY `CategoryID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `OrderDetails`
--
ALTER TABLE `OrderDetails`
  MODIFY `OrderDetailID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT для таблицы `Orders`
--
ALTER TABLE `Orders`
  MODIFY `OrderID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT для таблицы `Products`
--
ALTER TABLE `Products`
  MODIFY `ProductID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT для таблицы `Promotions`
--
ALTER TABLE `Promotions`
  MODIFY `PromotionID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `Users`
--
ALTER TABLE `Users`
  MODIFY `UserID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `OrderDetails`
--
ALTER TABLE `OrderDetails`
  ADD CONSTRAINT `orderdetails_ibfk_1` FOREIGN KEY (`OrderID`) REFERENCES `Orders` (`OrderID`) ON DELETE CASCADE,
  ADD CONSTRAINT `orderdetails_ibfk_2` FOREIGN KEY (`ProductID`) REFERENCES `Products` (`ProductID`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `Orders`
--
ALTER TABLE `Orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `Users` (`UserID`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `Products`
--
ALTER TABLE `Products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`CategoryID`) REFERENCES `Categories` (`CategoryID`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`PromotionID`) REFERENCES `Promotions` (`PromotionID`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
