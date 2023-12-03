<?php
session_start();

require_once('../../config/database.php');

// Verificar si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    // Redirigir a la página de inicio de sesión si el usuario no está autenticado
    header("Location: ../auth/login.php");
    exit();
}

// Obtener información del usuario desde la sesión
$user_id = $_SESSION['user_id'];

// Obtener información del carrito para el usuario actual
$cart_query = "SELECT p.*, c.quantity AS cart_quantity FROM product p
              INNER JOIN cart c ON p.id = c.product_id
              WHERE c.user_id = $user_id";

$cart_result = mysqli_query($conn, $cart_query);

// Verificar si se ha enviado un formulario para actualizar la cantidad en el carrito
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = $_POST['product_id'];
    $new_quantity = $_POST['new_quantity'];

    // Verificar la disponibilidad del producto
    $availability_query = "SELECT quantity FROM product WHERE id = $product_id";
    $availability_result = mysqli_query($conn, $availability_query);
    $availability = mysqli_fetch_assoc($availability_result)['quantity'];

    if ($new_quantity <= $availability) {
        // Actualizar la cantidad en el carrito
        $update_query = "UPDATE cart SET quantity = $new_quantity WHERE user_id = $user_id AND product_id = $product_id";
        mysqli_query($conn, $update_query);
    } else {
        echo "La cantidad solicitada excede la disponibilidad del producto.";
    }
}

// Calcular el monto total del carrito
$total_query = "SELECT SUM(p.price * c.quantity) AS total FROM product p
                INNER JOIN cart c ON p.id = c.product_id
                WHERE c.user_id = $user_id";

$total_result = mysqli_query($conn, $total_query);
$total = mysqli_fetch_assoc($total_result)['total'];

// Cerrar la conexión a la base de datos
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Cart</title>
</head>
<body>
    <h1>Shopping Cart</h1>

    <?php
    // Mostrar productos en el carrito
    while ($product = mysqli_fetch_assoc($cart_result)) {
        echo "<div>";
        echo "<h3>{$product['name']}</h3>";
        echo "<p>Price: {$product['price']}</p>";
        echo "<p>Available Quantity: {$product['quantity']}</p>";
        echo "<form method='post' action='view_cart.php'>";
        echo "<label for='new_quantity'>Quantity:</label>";
        echo "<input type='number' name='new_quantity' value='{$product['cart_quantity']}' min='1' max='{$product['quantity']}'>";
        echo "<input type='hidden' name='product_id' value='{$product['id']}'>";
        echo "<button type='submit'>Update Quantity</button>";
        echo "</form>";
        echo "</div>";
    }

    // Mostrar el monto total
    echo "<p>Total: $total</p>";
    ?>

</body>
</html>
