<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: ../auth/login.php');
    exit();
}

// Incluye la conexión a la base de datos y las funciones de utilidad
require_once '../../config/database.php';

// Obtiene la información del usuario
$user = $_SESSION['user'];

// Obtiene la información de la orden
$orderRef = $_SESSION['order_ref'];
$order = getOrderDetailsByRef($orderRef);

// Obtiene la información de la dirección de facturación
$billingAddress = getAddressById($user['billing_address_id']);

// Obtiene la información de la dirección de envío
$shippingAddress = getAddressById($user['shipping_address_id']);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Order</title>
</head>
<body>

<main>
    <h1>Confirm Your Order</h1>

    <h2>Order Details</h2>
    <p>Order Reference: <?php echo $order['ref']; ?></p>
    <p>Date: <?php echo $order['date']; ?></p>
    <p>Total Amount: $<?php echo number_format($order['total'], 2); ?></p>

    <h2>Billing Address</h2>
    <p><?php echo $billingAddress['street_name'] . ' ' . $billingAddress['street_nb']; ?></p>
    <p><?php echo $billingAddress['city'] . ', ' . $billingAddress['province'] . ' ' . $billingAddress['zip_code']; ?></p>
    <p><?php echo $billingAddress['country']; ?></p>

    <h2>Shipping Address</h2>
    <p><?php echo $shippingAddress['street_name'] . ' ' . $shippingAddress['street_nb']; ?></p>
    <p><?php echo $shippingAddress['city'] . ', ' . $shippingAddress['province'] . ' ' . $shippingAddress['zip_code']; ?></p>
    <p><?php echo $shippingAddress['country']; ?></p>

    <!-- Formulario para procesar la confirmación de la orden -->
    <form action="process_confirm_order.php" method="post">
        <button type="submit" name="confirm_order">Confirm Order</button>
    </form>
</main>


</body>
</html>