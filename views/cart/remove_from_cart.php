<?php

// Inicia la sesión
session_start();

// Verifica si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    // Si no está autenticado, redirecciona a la página de inicio de sesión
    header("Location: login.php");
    exit();
}

// Incluye el archivo de conexión a la base de datos y la clase ProductController
require_once('../../config/database.php');
require_once('../../controllers/ProductController.php');

// Obtiene el ID del producto a eliminar del carrito
$productId = $_GET['productId'];

// Crea una instancia del controlador de productos
$productController = new ProductController();

// Elimina el producto del carrito
$productController->removeFromCart($_SESSION['user_id'], $productId);

// Redirecciona a la página del carrito de compras con un mensaje de éxito
header("Location: view_cart.php?success=removed");
exit();

?>
