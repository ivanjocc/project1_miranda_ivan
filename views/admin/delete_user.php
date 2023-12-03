<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    // Redirigir a la página de inicio de sesión si el usuario no está autenticado
    header("Location: ../auth/login.php");
    exit();
}

// Obtener el rol del usuario desde la sesión
$user_role = $_SESSION['user_role'];

// Verificar si el usuario tiene el rol de administrador
if ($user_role != 1) {
    // Redirigir a la página de inicio si el usuario no es un administrador
    header("Location: ../../index.php");
    exit();
}

// Verificar si se proporcionó el ID del usuario a borrar
if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    // Conectar a la base de datos (ajusta la ruta según tu estructura de archivos)
    require_once('../../config/database.php');

    // Consulta para eliminar al usuario
    $delete_query = "DELETE FROM `user` WHERE `id` = $user_id";
    $result = mysqli_query($conn, $delete_query);

    // Verificar si se realizó la eliminación correctamente
    if ($result) {
        header("Location: dashboard.php");
    } else {
        echo "Error al eliminar el usuario: " . mysqli_error($conn);
    }

    // Cierra la conexión a la base de datos
    mysqli_close($conn);
} else {
    echo "ID de usuario no proporcionado.";
}
?>
