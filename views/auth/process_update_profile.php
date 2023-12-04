<?php
require_once('../../config/database.php');

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];

    // Obtener datos del formulario
    $user_name = $_POST['user_name'];
    $email = $_POST['email'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];

    // Validar que todos los campos estén llenos
    if (empty($user_name) || empty($email) || empty($fname) || empty($lname)) {
        $error_message = "All fields must be filled.";
        header("Location: profile.php?error=$error_message");
        exit();
    }

    // Actualizar la información del usuario en la base de datos
    $sql = "UPDATE `user` 
            SET `user_name` = '$user_name', `email` = '$email', `fname` = '$fname', `lname` = '$lname' 
            WHERE `id` = $user_id";

    if (mysqli_query($conn, $sql)) {
        header("Location: profile.php");
    } else {
        $error_message = "Error updating profile: " . mysqli_error($conn);
        header("Location: profile.php?error=$error_message");
        exit();
    }
} else {
    echo "Access not allowed";
}

mysqli_close($conn);
?>
