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
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cat Shop</title>
</head>
<body>

<?php include 'includes/header.php'; ?>

<main>
    <h1>Welcome to the Cat Shop</h1>

    <div class="cat-container">
        <?php
        // Obtener la lista de gatos desde el directorio de imágenes
        $catImages = glob('public/img/*.jpg');
        
        foreach ($catImages as $catImage) {
            // Obtener el nombre del archivo (sin la ruta)
            $catName = pathinfo($catImage, PATHINFO_FILENAME);

            // Mostrar cada gato con un formulario para agregarlo al carrito
            echo '<div class="cat-item">';
            echo '<img src="' . $catImage . '" alt="' . $catName . '">';
            echo '<p>' . $catName . '</p>';
            
            // Agrega un formulario con campos ocultos para enviar detalles del producto
            echo '<form method="post">';
            echo '<input type="hidden" name="product_id" value="' . $catName . '">';
            echo '<input type="hidden" name="product_name" value="' . $catName . '">';
            echo '<input type="hidden" name="product_price" value="19.99">'; // Aquí debes ajustar el precio según tus necesidades
            echo '<button type="submit" name="add_to_cart">Add to Cart</button>';
            echo '</form>';
            
            echo '</div>';
        }
        ?>
    </div>
</main>

<?php include 'includes/footer.php'; ?>

</body>
</html>