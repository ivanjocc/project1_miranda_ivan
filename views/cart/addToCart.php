<?php
session_start();

// Include the database configuration and Product class
include_once '../../config/database.php';
include_once '../../models/Product.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $productId = $_POST["productId"];

    // Retrieve all products from the database
    $conn = connexionDB(); // Assuming you have a function named connexionDB for database connection
    $query = "SELECT * FROM product";
    $result = mysqli_query($conn, $query);

    $products = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $product = new Product($row['id'], $row['name'], $row['quantity'], $row['price'], $row['img_url'], $row['description']);
        $products[] = $product;
    }

    mysqli_close($conn);

    // Find the selected product in the list of products
    $selectedProduct = null;
    foreach ($products as $product) {
        if ($product->getId() == $productId) {
            $selectedProduct = $product;
            break;
        }
    }

    // Check if the product was found and is available in stock
    if ($selectedProduct && $selectedProduct->isAvailableInStock()) {
        // Check if the cart session variable exists
        if (!isset($_SESSION["cart"])) {
            $_SESSION["cart"] = [];
        }

        // Add the product to the cart using the product ID as the key
        $_SESSION["cart"][$productId] = [
            "id" => $selectedProduct->getId(),
            "name" => $selectedProduct->getName(),
            "quantity" => 1, // You can adjust the quantity as needed
            "price" => $selectedProduct->getPrice(),
            // Add other product details if needed
        ];

        // Redirect back to the homepage (index.php)
        header("Location: view_cart.php");
        exit();
    } else {
        // If the product is not available in stock, you can show an error message or redirect to another page
        echo "Error: Product not available in stock.";
    }
}
?>
