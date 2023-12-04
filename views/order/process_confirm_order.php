<?php
session_start();

// Verifica si el usuario está autenticado, de lo contrario redirige a la página de inicio de sesión
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

// Incluye la conexión a la base de datos y las funciones de utilidad
require_once 'db.php';

// Obtiene la información del usuario
$user = $_SESSION['user'];

// Obtiene la información de la orden
$orderRef = $_SESSION['order_ref'];
$order = getOrderDetailsByRef($orderRef);

// Obtiene la información de la dirección de facturación
$billingAddress = getAddressById($user['billing_address_id']);

// Obtiene la información de la dirección de envío
$shippingAddress = getAddressById($user['shipping_address_id']);

// Aquí puedes realizar cualquier lógica adicional necesaria antes de procesar la orden

// Por ejemplo, marcar la orden como confirmada en la base de datos

// Redirige a la página de confirmación
header('Location: confirmation.php');
exit();
?>
