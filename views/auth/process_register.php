<?php

// Inicia la sesión
session_start();

// Incluye el archivo de conexión a la base de datos y la clase User
require_once('../../config/database.php');
require_once('../../models/User.php');

// Obtiene los datos del formulario
$userName = $_POST['userName'];
$email = $_POST['email'];
$password = $_POST['password'];
$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];

// Crea una instancia del modelo User
$userModel = new User($userName, $email, $password, $firstName, $lastName);

// Verifica si el nombre de usuario ya está en uso
if ($userModel->isUserNameTaken($userName)) {
    // Si el nombre de usuario está en uso, redirecciona a la página de registro con un mensaje de error
    header("Location: register.php?error=usernametaken");
    exit();
}

// Verifica si el correo electrónico ya está en uso
if ($userModel->isEmailTaken($email)) {
    // Si el correo electrónico está en uso, redirecciona a la página de registro con un mensaje de error
    header("Location: register.php?error=emailtaken");
    exit();
}

// Crea un nuevo usuario
$userID = $userModel->createUser($userName, $email, $password, $firstName, $lastName);

// Inicia sesión con el nuevo usuario
$_SESSION['user_id'] = $userID;
$_SESSION['user_name'] = $userName;

// Redirecciona a la página de perfil con un mensaje de éxito
header("Location: profile.php?success=registered");
exit();

?>
