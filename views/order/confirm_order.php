<?php
include('../../config/database.php'); // Ajusta la ruta según sea necesario
session_start();

if (!isset($_SESSION['user_id']) || !isset($_SESSION['shipping_address'])) {
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
$cart_products = $_SESSION['cart'];

// Calcular el precio total basado en los productos en el carrito
$total_price = 0;
foreach ($cart_products as $product) {
    $total_price += $product['quantity'] * $product['price'];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Order</title>
</head>
<body>
    <h1>Confirm Your Order</h1>

    <!-- Mostrar información del usuario y dirección de envío -->
    <p>User ID: <?php echo $user_id; ?></p>
    <p>Shipping Address:</p>
    <p>Street Name: <?php echo $street_name; ?></p>
    <p>Street Number: <?php echo $street_nb; ?></p>
    <p>City: <?php echo $city; ?></p>
    <p>Province: <?php echo $province; ?></p>
    <p>Zip Code: <?php echo $zip_code; ?></p>
    <p>Country: <?php echo $country; ?></p>

    <!-- Mostrar productos en el carrito -->
    <p>Cart Products:</p>
    <ul>
        <?php foreach ($cart_products as $product): ?>
            <li>
                <?php echo $product['name']; ?> -
                Quantity: <?php echo $product['quantity']; ?>,
                Price: <?php echo $product['price']; ?>
            </li>
        <?php endforeach; ?>
    </ul>

    <!-- Mostrar el precio total -->
    <p>Total Price: $<?php echo number_format($total_price, 2); ?></p>

    <!-- Formulario para enviar la orden -->
    <form action="process_confirm_order.php" method="post">
        <!-- Puedes incluir campos adicionales según sea necesario -->

        <button type="submit">Place Order</button>
    </form>
</body>
</html>
