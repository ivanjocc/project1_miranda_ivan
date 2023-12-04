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

        // Muestra una alerta de que el artículo ha sido agregado
        echo '<script>alert("Item has been added to the cart!");</script>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cat Shop</title>
    <style>
        /* Custom styles for adjusting image size and spacing */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            background-color: #f8f9fa; /* Background color for the entire page */
        }

        header {
            background-color: #343a40; /* Header background color */
            color: white;
            padding: 15px;
            text-align: center;
        }

        nav {
            display: flex;
            justify-content: space-around;
            list-style-type: none;
            padding: 0;
            margin: 0;
            background-color: #343a40; /* Navigation background color */
        }

        nav a {
            text-decoration: none;
            color: white;
            padding: 10px;
        }

        main {
            max-width: 1200px;
            margin: 20px auto;
        }

        .cat-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
        }

        .cat-item img {
            width: 100%;
            max-height: 200px; /* Altura máxima de las imágenes */
            object-fit: cover; /* Mantiene la relación de aspecto y cubre el contenedor */
            border-bottom: 1px solid #ddd;
        }

        .cat-item img {
            width: 100%; /* Make the image fill the container */
            height: auto; /* Maintain aspect ratio */
            border-bottom: 1px solid #ddd; /* Border between image and details */
        }

        .cat-item-details {
            padding: 10px;
        }

        form {
            display: flex;
            justify-content: center;
            margin-top: 10px;
        }

        button {
            background-color: #007bff; /* Button background color */
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3; /* Button background color on hover */
        }

        footer {
            background-color: #343a40; /* Footer background color */
            color: white;
            text-align: center;
            padding: 15px;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
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
