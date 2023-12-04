<?php
include('../../config/database.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    // Redirigir a la página de inicio de sesión o manejar acceso no autorizado
    header("Location: ../auth/login.php");
    exit();
}

$conn = $GLOBALS['conn'];

// Obtener información del usuario
$user_id = $_SESSION['user_id'];

// Obtener información de la dirección de envío desde la base de datos
$sql = "SELECT u.*, a.* FROM `user` u
        JOIN `address` a ON u.shipping_address_id = a.id
        WHERE u.id = $user_id";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);

    // Obtener información de la dirección de envío
    $street_name = $row['street_name'];
    $street_nb = $row['street_nb'];
    $city = $row['city'];
    $province = $row['province'];
    $zip_code = $row['zip_code'];
    $country = $row['country'];
} else {
    // Manejar el caso en el que no se pueda obtener la información de la dirección
    header("Location: failure.php?error=address");
    exit();
}

// Obtener productos del carrito
$cart_products = $_SESSION['cart'];

// Calcular el precio total basado en los productos en el carrito
$total_price = 0;
foreach ($cart_products as $product) {
    $total_price += $product['quantity'] * $product['price'];
}

// Insertar en la tabla user_order
$sql_insert_order = "INSERT INTO `user_order` (`ref`, `date`, `total`, `user_id`) VALUES ('$order_reference', NOW(), $total_price, $user_id)";
$result_insert_order = mysqli_query($conn, $sql_insert_order);

if (!$result_insert_order) {
    // Manejar el error al insertar en la tabla user_order
    header("Location: failure.php?error=order");
    exit();
}

// Obtener el ID de la orden para usarlo según sea necesario
$order_id = mysqli_insert_id($conn);

// Limpiar las variables de sesión
unset($_SESSION['cart']);

// Redirigir a la página de éxito
header("Location: success.php");
exit();
?>