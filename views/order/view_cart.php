<?php
session_start();

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['user_id'])) {
    // El usuario no ha iniciado sesión, redirige a la página de login
    header("Location: ../auth/login.php");
    exit();
}

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
    } elseif (isset($_POST['confirm_order'])) {
        // Redirigir a la página de confirmación de pedido
        header("Location: confirm_order.php");
        exit();
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
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        main {
            max-width: 800px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            background-color: #007BFF;
            color: #fff;
            padding: 10px;
            text-align: center;
        }

        .cart-container {
            margin-top: 20px;
        }

        .cart-item {
            border: 1px solid #ddd;
            padding: 10px;
            margin-bottom: 10px;
        }

        .cart-item p {
            margin: 5px 0;
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

        a {
            display: block;
            text-align: center;
            margin-top: 10px;
            color: #007BFF;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
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
            <!-- Formulario para confirmar la orden -->
            <form action="confirm_order.php" method="post">
                <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                <?php foreach ($_SESSION['cart'] as $item) : ?>
                    <input type="hidden" name="product_id[]" value="<?php echo $item['id']; ?>">
                    <input type="hidden" name="product_name[]" value="<?php echo $item['name']; ?>">
                    <input type="hidden" name="product_price[]" value="<?php echo $item['price']; ?>">
                <?php endforeach; ?>
                <button type="submit" name="confirm_order">Confirm Order</button>
            </form>
            <br>

            <!-- Formulario para vaciar el carrito -->
            <form action="" method="post">
                <button type="submit" name="empty_cart">Empty Cart</button>
            </form>
            <a href="../../index.php">Home</a>
        </div>
    </main>

</body>

</html>