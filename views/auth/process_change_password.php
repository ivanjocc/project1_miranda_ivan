<!-- process_change_password.php -->
<?php
require_once('../../config/database.php');

// Suponiendo que la información del usuario se almacena en una sesión después del inicio de sesión
session_start();
if (!isset($_SESSION['user_id'])) {
    // Redirigir a la página de inicio de sesión si el usuario no está autenticado
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_new_password = $_POST['confirm_new_password'];

    // Obtener la contraseña actual del usuario desde la base de datos
    $sql = "SELECT `pwd` FROM `user` WHERE `id` = $user_id";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc($result);

    if (password_verify($current_password, $user['pwd'])) {
        // Verificar que la contraseña actual ingresada coincide con la almacenada en la base de datos

        if ($new_password === $confirm_new_password) {
            // Las nuevas contraseñas coinciden

            // Actualizar la contraseña en la base de datos
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $update_sql = "UPDATE `user` SET `pwd` = '$hashed_password' WHERE `id` = $user_id";
            mysqli_query($conn, $update_sql);

            // Redirigir a la página de perfil después de cambiar la contraseña
            header("Location: profile.php");
            exit();
        } else {
            echo "New passwords do not match.";
        }
    } else {
        echo "Current password is incorrect.";
    }
}
?>
