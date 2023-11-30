<?php

// Inicia la sesión
session_start();

// Verifica si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    // Si no está autenticado, redirecciona a la página de inicio de sesión
    header("Location: login.php");
    exit();
}

// Incluye el archivo de conexión a la base de datos y la clase PasswordChange
require_once('../../config/database.php');
require_once('../../models/PasswordChange.php');

// Obtiene el ID del usuario desde la sesión
$userID = $_SESSION['user_id'];

// Obtiene la contraseña actual ingresada por el usuario
$currentPassword = $_POST['currentPassword'];

// Obtiene la nueva contraseña ingresada por el usuario
$newPassword = $_POST['newPassword'];

// Obtiene la confirmación de la nueva contraseña ingresada por el usuario
$confirmNewPassword = $_POST['confirmNewPassword'];

// Verifica si la nueva contraseña y la confirmación coinciden
if ($newPassword !== $confirmNewPassword) {
    // Si no coinciden, redirecciona a la página de cambio de contraseña con un mensaje de error
    header("Location: change_password.php?error=nomatch");
    exit();
}

// Crea una instancia de la clase PasswordChange
$passwordChangeModel = new PasswordChange($userID, $currentPassword, $newPassword);

// Verifica si la contraseña actual es válida
if ($passwordChangeModel->verifyPassword()) {
    // Si la contraseña actual es válida, actualiza la contraseña del usuario
    $result = $passwordChangeModel->updatePassword();

    // Verifica si la actualización fue exitosa
    if ($result['success']) {
        // Redirecciona a la página de perfil con un mensaje de éxito
        header("Location: profile.php?success=passwordchanged");
        exit();
    } else {
        // Si hay un error en la actualización, redirecciona a la página de cambio de contraseña con un mensaje de error
        header("Location: change_password.php?error=" . urlencode($result['error']));
        exit();
    }
} else {
    // Si la contraseña actual no es válida, redirecciona a la página de cambio de contraseña con un mensaje de error
    header("Location: change_password.php?error=invalidpassword");
    exit();
}

?>
