<?php

require_once('../../config/database.php');
require_once('../../models/User.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["userName"]) && isset($_POST["password"])) {
    // Obtener datos del formulario
    $userName = $_POST["userName"];
    $password = $_POST["password"];

    // Validar y limpiar los datos para prevenir inyecciones SQL
    $userName = htmlspecialchars($userName);
    $password = htmlspecialchars($password);

    // Asegúrate de escapar los datos si los estás utilizando directamente en una consulta SQL
    $userName = mysqli_real_escape_string($conn, $userName);
    $password = mysqli_real_escape_string($conn, $password);

    $conn = connexionDB(); // Asume que connexionDB es una función que establece la conexión a la base de datos

    // Ejemplo de consulta para obtener información del usuario
    $getUserQuery = "SELECT * FROM user WHERE user_name = ? AND pwd = ?";
    $getUserStmt = mysqli_prepare($conn, $getUserQuery);
    mysqli_stmt_bind_param($getUserStmt, "ss", $userName, $password);

    // Ejecutar la consulta
    mysqli_stmt_execute($getUserStmt);
    mysqli_stmt_store_result($getUserStmt);

    // Verificar si se encontró un usuario con las credenciales proporcionadas
    if (mysqli_stmt_num_rows($getUserStmt) == 1) {
        // Autenticación exitosa, redirigir a alguna página de éxito o al panel del usuario
        header("Location: profile.php");
        exit();
    } else {
        // Autenticación fallida, redirigir a la página de inicio de sesión con un mensaje de error
        header("Location: login.php?error=1");
        exit();
    }

    // Cerrar la declaración y la conexión
    mysqli_stmt_close($getUserStmt);
    mysqli_close($conn);
} else {
    // La solicitud no es POST o faltan parámetros, redirigir a alguna página de error o mostrar un mensaje
    echo "Error en la solicitud.";
}
?>
