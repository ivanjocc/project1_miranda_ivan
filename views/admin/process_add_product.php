<?php

require_once('../../config/database.php');

// Asegúrate de incluir el modelo Product si no se ha incluido aún
require_once('../../models/Product.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir datos del formulario
    $productName = $_POST["productName"];
    $quantity = $_POST["quantity"];
    $price = $_POST["price"];
    $imgUrl = $_POST["imgUrl"];
    $description = $_POST["description"];

    // Recibir datos del formulario y aplicar validación y limpieza
    $productName = isset($_POST["productName"]) ? validateAndClean($_POST["productName"]) : "";
    $quantity = isset($_POST["quantity"]) ? validateAndClean($_POST["quantity"]) : "";
    $price = isset($_POST["price"]) ? validateAndClean($_POST["price"]) : "";
    $imgUrl = isset($_POST["imgUrl"]) ? validateAndClean($_POST["imgUrl"]) : "";
    $description = isset($_POST["description"]) ? validateAndClean($_POST["description"]) : "";


    $conn = connexionDB(); // Asume que connexionDB es una función que establece la conexión a la base de datos

    // Ejemplo de inserción de datos en la tabla product
    $insertProductQuery = "INSERT INTO product (name, quantity, price, img_url, description) VALUES (?, ?, ?, ?, ?)";
    $insertProductStmt = mysqli_prepare($conn, $insertProductQuery);
    mysqli_stmt_bind_param($insertProductStmt, "siiss", $productName, $quantity, $price, $imgUrl, $description);

    // Ejecutar la consulta
    $result = mysqli_stmt_execute($insertProductStmt);

    // Cerrar la declaración y la conexión
    mysqli_stmt_close($insertProductStmt);
    mysqli_close($conn);

    // Verificar el resultado y redirigir según sea necesario
    if ($result) {
        header("Location: add_product.php");
        exit();
    } else {
        // Hubo un error al agregar el producto, redirigir a alguna página de error o mostrar un mensaje
        echo "Error al agregar el producto.";
    }
} else {
    // La solicitud no es POST, redirigir a alguna página de error o mostrar un mensaje
    echo "Error en la solicitud.";
}

// Función para validar y limpiar datos (un ejemplo básico)
function validateAndClean($data) {
    // Eliminar espacios en blanco al inicio y al final
    $cleanedData = trim($data);
    // Eliminar caracteres especiales que puedan ser peligrosos
    $cleanedData = htmlspecialchars($cleanedData);
    // Puedes aplicar más validaciones según tus necesidades
    return $cleanedData;
}

?>
