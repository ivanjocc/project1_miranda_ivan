<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    // Redirigir a la página de inicio de sesión si el usuario no está autenticado
    header("Location: ../auth/login.php");
    exit();
}

// Obtener el rol del usuario desde la sesión
$user_role = $_SESSION['user_role'];

// Verificar si el usuario tiene el rol de administrador
if ($user_role != 1) { 
    // Redirigir a la página de inicio si el usuario no es un administrador
    header("Location: ../../index.php");
    exit();
}

// Si el usuario es un administrador, mostrar el panel de administración
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
</head>
<body>
    <h2>Welcome to the Admin Dashboard</h2>
    
    <ul>
        <li><a href="add_product.php">Add Product</a></li>
        <li><a href="manage_users.php">User List</a></li>
        <li><a href="view_search_orders.php">Order List</a></li>
        <li><a href="../auth/logout.php">Log out</a></li>
    </ul>
    
</body>
</html>
