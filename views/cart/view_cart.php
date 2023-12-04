<?php
session_start();

// Inicializa el carrito si no existe
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Manejo de la adición al carrito
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_to_cart'])) {
        // Obtén los detalles del producto y agrega al carrito
        $productId = $_POST['product_id'];
        $productName = $_POST['product_name'];
        $productPrice = $_POST['product_price'];

        // Verifica si el producto ya está en el carrito
        $productInCart = false;
        foreach ($_SESSION['cart'] as &$cartItem) {
            if ($cartItem['id'] === $productId) {
                $cartItem['quantity'] += 1; // Incrementa la cantidad
                $productInCart = true;
                break;
            }
        }
        unset($cartItem); // Liberar la referencia explícita

        // Si el producto no está en el carrito, agrégalo
        if (!$productInCart) {
            $_SESSION['cart'][] = [
                'id' => $productId,
                'name' => $productName,
                'price' => $productPrice,
                'quantity' => 1,
            ];
        }
    } elseif (isset($_POST['empty_cart'])) {
        // Vaciar el carrito al hacer clic en el botón
        $_SESSION['cart'] = [];
    }
}

// Suma total de los productos en el carrito
$totalPrice = 0;
foreach ($_SESSION['cart'] as $item) {
    $totalPrice += $item['price'] * $item['quantity'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Cart</title>
</head>
<body>

<main>
    <h1>Your Shopping Cart</h1>

    <div class="cart-container">
        <?php
        // Muestra los elementos en el carrito
        foreach ($_SESSION['cart'] as $item) {
            echo '<div class="cart-item">';
            echo '<p>' . $item['name'] . '</p>';
            echo '<p>Price: $' . $item['price'] . '</p>';
            echo '<p>Quantity: ' . $item['quantity'] . '</p>';
            echo '</div>';
        }
        ?>

        <!-- Muestra la suma total de los productos -->
        <p>Total Price: $<?php echo number_format($totalPrice, 2); ?></p>

        <!-- Formulario para confirmar la orden -->
        <form action="../order/confirm_order.php" method="post">
            <button type="submit" name="confirm_order">Confirm Order</button>
        </form>

        <!-- Formulario para vaciar el carrito -->
        <form action="" method="post">
            <button type="submit" name="empty_cart">Empty Cart</button>
        </form>
        <a href="../../index.php">Home</a>
    </div>
</main>

</body>
</html>