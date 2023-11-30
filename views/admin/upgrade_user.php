<?php

require_once('../../config/database.php');

require_once('../../models/User.php');

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["userId"])) {
    // Obtener el ID del usuario de la URL
    $userId = $_GET["userId"];

    // Validar y limpiar el ID del usuario para prevenir inyecciones SQL
    if (!is_numeric($userId)) {
        // Manejar el error, por ejemplo, redirigir a una página de error o mostrar un mensaje
        echo "Error en el ID del usuario.";
        exit();
    }

    $conn = connexionDB(); // Asume que connexionDB es una función que establece la conexión a la base de datos

    // Ejemplo de actualización del rol del usuario
    $updateUserRoleQuery = "UPDATE user SET role_id = (SELECT id FROM role WHERE name = 'admin') WHERE id = ?";
    $updateUserRoleStmt = mysqli_prepare($conn, $updateUserRoleQuery);
    mysqli_stmt_bind_param($updateUserRoleStmt, "i", $userId);

    // Ejecutar la consulta
    $result = mysqli_stmt_execute($updateUserRoleStmt);

    // Cerrar la declaración y la conexión
    mysqli_stmt_close($updateUserRoleStmt);
    mysqli_close($conn);

    // Verificar el resultado y redirigir según sea necesario
    if ($result) {
        header("Location: manage_users.php");
        exit();
    } else {
        // Hubo un error en la actualización, redirigir a alguna página de error o mostrar un mensaje
        echo "Error al actualizar el rol del usuario.";
    }
} else {
    // La solicitud no es GET o falta el parámetro userId, redirigir a alguna página de error o mostrar un mensaje
    echo "Error en la solicitud.";
}
?>
