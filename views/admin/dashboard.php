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
    <link rel="stylesheet" href="../../public/css/cursor.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        h2 {
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }

        ul {
            list-style-type: none;
            padding: 0;
            text-align: center;
        }

        li {
            margin: 10px 0;
        }

        a {
            display: block;
            padding: 10px;
            background-color: #007BFF;
            color: #fff;
            text-decoration: none;
            border-radius: 8px;
            transition: background-color 0.3s ease;
        }

        a:hover {
            background-color: #0056b3;
        }
    </style>

</head>

<body>
    <h2>Welcome to the Admin Dashboard</h2>

    <ul>
        <li><a href="../../index.php">Home</a></li>
        <li><a href="add_product.php">Add Product</a></li>
        <li><a href="manage_users.php">User List</a></li>
        <li><a href="view_search_orders.php">Order List</a></li>
        <li><a href="../auth/logout.php">Log out</a></li>
    </ul>

</body>

</html>