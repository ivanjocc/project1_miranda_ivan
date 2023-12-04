<?php
include('../../config/database.php'); // Adjust the path accordingly
session_start();

if (!isset($_SESSION['user_id']) || !isset($_SESSION['shipping_address'])) {
    // Redirect to the appropriate page or handle unauthorized access
    header("Location: ../auth/login.php"); // Adjust the path accordingly
    exit();
}

$conn = $GLOBALS['conn'];

// Get user information
$user_id = $_SESSION['user_id'];

// Get shipping address information
$shipping_address = $_SESSION['shipping_address'];
$street_name = $shipping_address['street_name'];
$street_nb = $shipping_address['street_nb'];
$city = $shipping_address['city'];
$province = $shipping_address['province'];
$zip_code = $shipping_address['zip_code'];
$country = $shipping_address['country'];

// Get products from the cart (Assuming you have the cart information stored in session)
$cart_products = $_SESSION['cart_products'];

// Calculate total price based on the products in the cart
$total_price = 0;
foreach ($cart_products as $product) {
    $total_price += $product['quantity'] * $product['price'];
}

// Generate a reference for the order (You may adjust this based on your requirements)
$order_reference = "ORDER-" . uniqid();

// Insert data into user_order table
$sql = "INSERT INTO `user_order` (`ref`, `date`, `total`, `user_id`) VALUES ('$order_reference', NOW(), $total_price, $user_id)";
$result = mysqli_query($conn, $sql);

if ($result) {
    // Get the order ID for use in order_has_product table
    $order_id = mysqli_insert_id($conn);

    // Insert data into order_has_product table for each product in the cart
    foreach ($cart_products as $product) {
        $product_id = $product['id'];
        $quantity = $product['quantity'];
        $price = $product['price'];

        $sql = "INSERT INTO `order_has_product` (`order_id`, `product_id`, `quantity`, `price`) VALUES ($order_id, $product_id, $quantity, $price)";
        mysqli_query($conn, $sql);
    }

    // Clear the session variables
    unset($_SESSION['shipping_address']);
    unset($_SESSION['cart_products']);

    // Redirect to success page
    header("Location: success.php");
    exit();
} else {
    // Redirect to failure page
    header("Location: failure.php");
    exit();
}
?>
