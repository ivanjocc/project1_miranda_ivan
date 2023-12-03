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

            // Mostrar cada gato con un botón para agregarlo al carrito
            echo '<div class="cat-item">';
            echo '<img src="' . $catImage . '" alt="' . $catName . '">';
            echo '<p>' . $catName . '</p>';
            echo '<button>Add to Cart</button>';
            echo '</div>';
        }
        ?>
    </div>
</main>

<?php include 'includes/footer.php'; ?>

</body>
</html>
