<?php

require_once('../../config/database.php');
require_once('../../models/User.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["firstName"]) && isset($_POST["lastName"])) {
    // Obtener datos del formulario
    $userId = $user->getId(); // Asume que $user contiene la información del usuario autenticado
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];

    // Validar y limpiar los datos para prevenir inyecciones SQL
    $firstName = htmlspecialchars($firstName);
    $lastName = htmlspecialchars($lastName);

    // Asegúrate de escapar los datos si los estás utilizando directamente en una consulta SQL
    $firstName = mysqli_real_escape_string($conn, $firstName);
    $lastName = mysqli_real_escape_string($conn, $lastName);

    $conn = connexionDB(); // Asume que connexionDB es una función que establece la conexión a la base de datos

    // Ejemplo de consulta para actualizar el perfil del usuario
    $updateProfileQuery = "UPDATE user SET fname = ?, lname = ? WHERE id = ?";
    $updateProfileStmt = mysqli_prepare($conn, $updateProfileQuery);
    mysqli_stmt_bind_param($updateProfileStmt, "ssi", $firstName, $lastName, $userId);

    // Ejecutar la consulta
    mysqli_stmt_execute($updateProfileStmt);

    // Verificar si la actualización fue exitosa
    if (mysqli_affected_rows($conn) > 0) {
        // Redirigir a la página de perfil con un mensaje de éxito
        header("Location: profile.php?success=1");
        exit();
    } else {
        // Redirigir a la página de perfil con un mensaje de error
        header("Location: profile.php?error=1");
        exit();
    }

    // Cerrar la declaración y la conexión
    mysqli_stmt_close($updateProfileStmt);
    mysqli_close($conn);
} else {
    // La solicitud no es POST o faltan parámetros, redirigir a alguna página de error o mostrar un mensaje
    echo "Error en la solicitud.";
}
?>
