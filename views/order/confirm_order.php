<?php
// Inicia la sesión
session_start();

// Verifica si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    // Si no está autenticado, redirecciona a la página de inicio de sesión
    header("Location: ../../views/auth/login.php");
    exit();
}

// Incluye el archivo de conexión a la base de datos y la clase OrderController
require_once('../../config/database.php');
require_once('../../controllers/OrderController.php');
require_once('../../models/Address.php');  // Asegúrate de tener la ruta correcta

// Obtiene la información necesaria para confirmar la orden
$userId = $_SESSION['user_id'];
$orderItems = [];  // Reemplaza esto con la lógica para obtener los elementos de la orden
$orderTotal = 0;   // Initialize $orderTotal
// Dirección de envío por defecto
$shippingAddress = new Address(
    null,
    'Calle Principal',
    '123',
    'Ciudad Principal',
    'Provincia Principal',
    '12345',
    'País Principal'
);

// Dirección de pago por defecto
$paymentAddress = new Address(
    null,
    'Calle de Pago',
    '456',
    'Ciudad de Pago',
    'Provincia de Pago',
    '54321',
    'País de Pago'
);

// Crea una instancia del controlador de órdenes
$orderController = new OrderController();

// Utiliza el método confirmOrder del controlador de órdenes para confirmar la orden
$result = $orderController->confirmOrder($userId, $orderItems, $shippingAddress, $paymentAddress);

// Verifica el resultado y redirecciona según sea necesario
if ($result) {
    header("Location: ../../views/order/success.php");
    exit();
} else {
    header("Location: ../../views/order/failure.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Order</title>
    <link rel="stylesheet" href="../../public/css/styles.css">
</head>
<body>
    <header>
        <h1>Confirm Order</h1>
    </header>

    <nav>
        <!-- Navigation menu for the order confirmation interface, if needed -->
    </nav>

    <main>
        <h2>Order Summary</h2>

        <table>
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <!-- Loop through order items and display information -->
                <?php foreach ($orderItems as $item): ?>
                    <tr>
                        <td><?php echo $item->getProductName(); ?></td>
                        <td><?php echo $item->getQuantity(); ?></td>
                        <td><?php echo $item->getPrice(); ?></td>
                        <td><?php echo $item->getTotal(); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <p>Total: <?php echo $orderTotal; ?></p>

        <h2>Shipping Information</h2>
        <p><?php echo $shippingAddress->getStreetName() . ' ' . $shippingAddress->getStreetNumber(); ?></p>
        <p><?php echo $shippingAddress->getCity() . ', ' . $shippingAddress->getProvince(); ?></p>
        <p><?php echo $shippingAddress->getZipCode() . ', ' . $shippingAddress->getCountry(); ?></p>

        <h2>Payment Information</h2>
        <p><?php echo $paymentAddress->getStreetName() . ' ' . $paymentAddress->getStreetNumber(); ?></p>
        <p><?php echo $paymentAddress->getCity() . ', ' . $paymentAddress->getProvince(); ?></p>
        <p><?php echo $paymentAddress->getZipCode() . ', ' . $paymentAddress->getCountry(); ?></p>

        <form action="process_confirm_order.php" method="post">
            <button type="submit">Confirm Order</button>
        </form>
    </main>

    <footer>
        <!-- Footer content, if needed -->
    </footer>
</body>
</html>
