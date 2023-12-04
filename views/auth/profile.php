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

// Obtener la información del usuario desde la base de datos
$sql = "SELECT * FROM `user` WHERE `id` = $user_id";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Profile</title>
</head>
<body>
    <h2>User Profile</h2>
    <a href="../../index.php">Home</a>
    <form action="process_update_profile.php" method="post" enctype="multipart/form-data">
        <!-- Mostrar la información del usuario y agregar campos de formulario según la estructura de tu base de datos -->
        <img src="../../public/images/avatar.jpg" alt="Default Profile Picture" width="100">
        <br>
        <label for="user_name">Username:</label>
        <input type="text" name="user_name" value="<?php echo $user['user_name']; ?>" required disabled>
        <br>
        <label for="email">Email:</label>
        <input type="email" name="email" value="<?php echo $user['email']; ?>" required>
        <br>
        <label for="fname">First Name:</label>
        <input type="text" name="fname" value="<?php echo $user['fname']; ?>" required>
        <br>
        <label for="lname">Last Name:</label>
        <input type="text" name="lname" value="<?php echo $user['lname']; ?>" required>
        <br>
        <input type="submit" value="Save">
    </form>
    <a href="./change_password.php">Change password</a>
    <br>
    <a href="./logout.php">Log out</a>
</body>
</html>
