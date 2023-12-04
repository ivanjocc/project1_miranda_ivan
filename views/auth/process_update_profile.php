<?php
require_once('../../config/database.php'); // Adjust the path based on your file structure

// Suponiendo que la información del usuario se almacena en una sesión después del inicio de sesión
session_start();
if (!isset($_SESSION['user_id'])) {
    // Redirigir a la página de inicio de sesión si el usuario no está autenticado
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener el ID del usuario desde la sesión
    $user_id = $_SESSION['user_id'];

    // Obtener datos del formulario
    $user_name = $_POST['user_name'];
    $email = $_POST['email'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];

    // Actualizar la información del usuario en la base de datos
    $sql = "UPDATE `user` 
            SET `user_name` = '$user_name', `email` = '$email', `fname` = '$fname', `lname` = '$lname' 
            WHERE `id` = $user_id";

    if (mysqli_query($conn, $sql)) {
        // echo "Profile updated successfully";
        header("Location: profile.php");
    } else {
        echo "Error updating profile: " . mysqli_error($conn);
    }
} else {
    echo "Access not allowed";
}

// Cerrar la conexión a la base de datos
mysqli_close($conn);
?>