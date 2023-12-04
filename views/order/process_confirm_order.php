<?php
include('../../config/database.php'); // Ajusta la ruta según sea necesario
session_start();

// Verificar si se ha iniciado sesión y se ha enviado la información de la orden
if (!isset($_SESSION['user_id']) || !isset($_SESSION['shipping_address']) || !isset($_SESSION['cart_products'])) {
    // Redirigir a la página de inicio de sesión o manejar acceso no autorizado
    header("Location: ../auth/login.php"); // Ajusta la ruta según sea necesario
    exit();
}

$conn = $GLOBALS['conn'];

// Obtener información del usuario
$user_id = $_SESSION['user_id'];

// Obtener información de la dirección de envío
$shipping_address = $_SESSION['shipping_address'];
$street_name = $shipping_address['street_name'];
$street_nb = $shipping_address['street_nb'];
$city = $shipping_address['city'];
$province = $shipping_address['province'];
$zip_code = $shipping_address['zip_code'];
$country = $shipping_address['country'];

// Obtener productos del carrito
$cart_products = $_SESSION['cart_products'];

// Calcular el precio total basado en los productos en el carrito
$total_price = 0;
foreach ($cart_products as $product) {
    $total_price += $product['quantity'] * $product['price'];
}

// Generar una referencia para la orden (ajustar según tus requisitos)
$order_reference = "ORDER-" . uniqid();

// Insertar datos en la tabla user_order
$sql = "INSERT INTO `user_order` (`ref`, `date`, `total`, `user_id`) VALUES ('$order_reference', NOW(), $total_price, $user_id)";
$result = mysqli_query($conn, $sql);

if ($result) {
    // Obtener el ID de la orden para usarlo en la tabla order_has_product
    $order_id = mysqli_insert_id($conn);

    // Insertar datos en la tabla order_has_product para cada producto en el carrito
    foreach ($cart_products as $product) {
        $product_id = $product['id'];
        $quantity = $product['quantity'];
        $price = $product['price'];

        $sql = "INSERT INTO `order_has_product` (`order_id`, `product_id`, `quantity`, `price`) VALUES ($order_id, $product_id, $quantity, $price)";
        mysqli_query($conn, $sql);
    }

    // Limpiar las variables de sesión
    unset($_SESSION['shipping_address']);
    unset($_SESSION['cart_products']);

    // Realizar otras acciones según sea necesario

    // Redirigir a la página de éxito
    header("Location: success.php");
    exit();
} else {
    // Redirigir a la página de fallo
    header("Location: failure.php");
    exit();
}
?>
