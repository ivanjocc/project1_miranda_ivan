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
