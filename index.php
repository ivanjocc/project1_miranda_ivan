<?php
// Include the database configuration
include_once 'config/database.php';

// Include any necessary model files
include_once 'models/User.php';
include_once 'models/Product.php';
include_once 'models/Order.php';
include_once 'models/Role.php';
include_once 'models/Address.php';
include_once 'models/OrderHasProduct.php';

// Example: Get all products from the database
function getAllProducts()
{
    $conn = connexionDB(); // Assuming you have a function named connexionDB for database connection
    $query = "SELECT * FROM product";
    $result = mysqli_query($conn, $query);

    $products = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $product = new Product($row['id'], $row['name'], $row['quantity'], $row['price'], $row['img_url'], $row['description']);
        $products[] = $product;
    }

    mysqli_close($conn);

    return $products;
}

// Example: Display products on the homepage
$products = getAllProducts();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <link rel="stylesheet" href="public/css/styles.css">
</head>

<body>
    <header>
        <h1>Welcome to Our E-commerce Website</h1>
    </header>

    <nav>
        <a href="views/auth/login.php">Login</a>
        <a href="views/auth/register.php">Register</a>
        <a href="views/cart/view_cart.php">View Cart</a>
        <a href="views/auth/profile.php">Profile</a>
    </nav>

    <main>
        <h2>Featured Products</h2>

        <div class="product-list">
            <?php foreach ($products as $product) : ?>
                <div class="product">
                    <img src="<?php echo $product->getImgUrl(); ?>" alt="<?php echo $product->getName(); ?>">
                    <h3><?php echo $product->getName(); ?></h3>
                    <p><?php echo $product->getDescription(); ?></p>
                    <p>Price: $<?php echo $product->getPrice(); ?></p>
                    <!-- Agregar esto dentro del bucle de productos en index.php -->
                    <form method="post" action="views/cart/addToCart.php">
                        <input type="hidden" name="productId" value="<?php echo $product->getId(); ?>">
                        <button type="submit">Add to Cart</button>
                    </form>

                    <!-- <button>Add to Cart</button> -->
                </div>
            <?php endforeach; ?>
        </div>
    </main>

    <footer>
        <!-- Footer content, if needed -->
    </footer>

    <script src="public/js/script.js"></script>
</body>

</html>