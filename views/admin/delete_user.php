<?php

// Asegúrate de incluir o requerir el archivo que contiene la función connexionDB y cualquier otro archivo necesario
require_once('../../config/database.php');

// Asegúrate de incluir el modelo User si no se ha incluido aún
require_once('../../models/User.php');

// Verifica si se ha proporcionado un userId a través de la URL
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["userId"])) {
    // Obtener el ID del usuario de la URL
    $userId = $_GET["userId"];

    // Validar y limpiar el userId para prevenir inyecciones SQL (dependiendo de la implementación de la función validateInput)
    $userId = validateInput($userId);

    $conn = connexionDB(); // Asume que connexionDB es una función que establece la conexión a la base de datos

    // Ejemplo de eliminación de usuario
    $deleteUserQuery = "DELETE FROM user WHERE id = ?";
    $deleteUserStmt = mysqli_prepare($conn, $deleteUserQuery);
    mysqli_stmt_bind_param($deleteUserStmt, "i", $userId);

    // Ejecutar la consulta
    $result = mysqli_stmt_execute($deleteUserStmt);

    // Cerrar la declaración y la conexión
    mysqli_stmt_close($deleteUserStmt);
    mysqli_close($conn);

    // Verificar el resultado y redirigir según sea necesario
    if ($result) {
        header("Location: manage_users.php");
        exit();
    } else {
        // Hubo un error en la eliminación, redirigir a alguna página de error o mostrar un mensaje
        echo "Error al eliminar el usuario.";
    }
} else {
    // La solicitud no es GET o falta el parámetro userId, redirigir a alguna página de error o mostrar un mensaje
    echo "Error en la solicitud.";
}

// Función para validar y limpiar datos (sustituye esto con tu propia implementación)
function validateInput($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>
