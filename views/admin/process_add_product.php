<?php
require_once('../../config/database.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];
    $description = $_POST['description'];

    // Manejar la subida de la imagen
    $targetDir = "../../public/img/";
    $targetFile = $targetDir . basename($_FILES["image"]["name"]);
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Verificar si el archivo es una imagen JPG
    if ($imageFileType != "jpg") {
        echo "Solo se permiten archivos JPG.";
        exit();
    }

    // Mover el archivo a la carpeta de imágenes
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
        // Insertar el nuevo producto en la base de datos
        $imgPath = "public/img/" . basename($_FILES["image"]["name"]);
        $insertQuery = "INSERT INTO `product` (`name`, `quantity`, `price`, `img_url`, `description`, `img_path`) VALUES ('$name', $quantity, $price, '$imgPath', '$description', '$targetFile')";
        $result = mysqli_query($conn, $insertQuery);

        if ($result) {
            header("Location: dashboard.php");
        } else {
            echo "Error al añadir el producto: " . mysqli_error($conn);
        }
    } else {
        echo "Error al subir la imagen.";
    }
} else {
    echo "Acceso no permitido.";
}

// Cerrar la conexión a la base de datos
mysqli_close($conn);
?>
