<?php
require_once('../../config/database.php');
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_new_password = $_POST['confirm_new_password'];

    // Validar campos vacíos
    if (empty($current_password) || empty($new_password) || empty($confirm_new_password)) {
        $error_message = "All fields are required.";
        header("Location: change_password.php?error=$error_message");
        exit();
    }

    // Obtener la contraseña actual del usuario desde la base de datos
    $sql = "SELECT `pwd` FROM `user` WHERE `id` = $user_id";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc($result);

    if (password_verify($current_password, $user['pwd'])) {
        if ($new_password === $confirm_new_password) {
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $update_sql = "UPDATE `user` SET `pwd` = '$hashed_password' WHERE `id` = $user_id";
            mysqli_query($conn, $update_sql);

            header("Location: profile.php");
            exit();
        } else {
            $error_message = "New passwords do not match.";
            header("Location: change_password.php?error=$error_message");
            exit();
        }
    } else {
        $error_message = "Current password is incorrect.";
        header("Location: change_password.php?error=$error_message");
        exit();
    }
}
?>
