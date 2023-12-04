<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Orders</title>
    <link rel="stylesheet" href="../../public/css/cursor.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        h1,
        h2 {
            background-color: #007BFF;
            color: #fff;
            padding: 10px;
            text-align: center;
        }

        form {
            width: 50%;
            margin: 20px auto;
            padding: 15px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input[type="text"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            box-sizing: border-box;
        }

        button {
            background-color: #007BFF;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        .dashboard-link {
            display: block;
            text-align: center;
            margin-top: 10px;
            padding: 10px 15px;
            color: #fff;
            background-color: #28a745;
            text-decoration: none;
            border-radius: 4px;
        }

        .dashboard-link:hover {
            background-color: #218838;
        }

        hr {
            margin: 20px 0;
            border: 0;
            border-top: 1px solid #ddd;
        }

        h2 {
            margin-top: 20px;
        }

        Order ID,
        Reference,
        Date,
        Total,
        User ID {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <h1>Search Orders</h1>
    <span style="color: red; font-weight: bold;">Note: Write 'ord' and click in 'Search' to see all the orders</span>

    <!-- Formulario de búsqueda -->
    <form action="view_search_orders.php" method="post">
        <label for="search_ref">Search by Reference:</label>
        <input type="text" name="search_ref" required>
        <button type="submit">Search</button>
    </form>

    <!-- Botón de Dashboard -->
    <a class="dashboard-link" href="./dashboard.php">Dashboard</a>
</body>

</html>

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

require_once('../../config/database.php');

// Manejar la búsqueda de órdenes
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $search_ref = mysqli_real_escape_string($conn, $_POST['search_ref']); // Evitar inyección SQL

    // Consultar las órdenes que contengan la referencia proporcionada
    $search_query = "SELECT * FROM `user_order` WHERE `ref` LIKE '%$search_ref%'";
    $search_result = mysqli_query($conn, $search_query);

    if ($search_result) {
        // Mostrar los resultados de la búsqueda
        echo "<h2>Search Results</h2>";
        while ($order = mysqli_fetch_assoc($search_result)) {
            echo "Order ID: " . $order['id'] . "<br>";
            echo "Reference: " . $order['ref'] . "<br>";
            echo "Date: " . $order['date'] . "<br>";
            echo "Total: $" . $order['total'] . "<br>";
            echo "User ID: " . $order['user_id'] . "<br>";
            echo "<hr>";
        }
    } else {
        echo "Error en la búsqueda: " . mysqli_error($conn);
    }
}

// Cerrar la conexión a la base de datos
mysqli_close($conn);
?>

