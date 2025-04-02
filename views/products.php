<?php
include('header.php');
require_once('../config/db.php');

$query = "SELECT ProductID, ProductName, Price, ImageURL, CategoryID FROM Products";
$result = mysqli_query($conn, $query);
?>

<head>
    <link rel="stylesheet" href="../css/styles.css">
</head>

<div class="products-page">
        <h2>Каталог товаров</h2>
        <div class="products-grid">
            <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                <div class="product-card">
                    <img src="../<?php echo $row['ImageURL']; ?>" alt="<?php echo $row['ProductName']; ?>">
                    <h3><?php echo $row['ProductName']; ?></h3>
                    <p class="Price"><?php echo $row['Price']; ?> ₽</p>
                    <p class="CategoryID">Категория: <?php echo $row['CategoryID']; ?></p>
                    <a href="product.php?id=<?php echo $row['ProductID']; ?>" class="btn">Подробнее</a>
                    <form action="add_to_cart.php" method="POST">
                        <input type="hidden" name="product_id" value="<?php echo $row['ProductID']; ?>">
                        <label for="size">Размер:</label>
                        <select name="size" required>
                            <option value="S">S</option>
                            <option value="M">M</option>
                            <option value="L">L</option>
                            <option value="XL">XL</option>
                        </select>
                        <button type="submit">Добавить в корзину</button>
                    </form>
                </div>
            <?php endwhile; ?>
        </div>
</div>

<footer>
    <?php include('footer.php'); ?>
</footer>

<?php mysqli_close($conn); ?>
