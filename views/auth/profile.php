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
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        h2 {
            color: #333;
            text-align: center;
            padding-top: 40px;
            margin-bottom: 20px;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            box-sizing: border-box;
            max-width: 400px;
            width: 100%;
            text-align: center;
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 16px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #007BFF;
            color: #fff;
            cursor: pointer;
        }

        a {
            display: block;
            text-align: center;
            margin-top: 10px;
            color: #007BFF;
            text-decoration: none;
        }

        a:last-child {
            padding-bottom: 30px;
        }

        a:hover {
            text-decoration: underline;
        }

        img {
            border-radius: 50%;
            margin-bottom: 10px;
        }
    </style>

</head>

<body>
    <h2>User Profile</h2>
    <form action="process_update_profile.php" method="post" enctype="multipart/form-data">
        <!-- Mostrar la información del usuario y agregar campos de formulario según la estructura de tu base de datos -->
        <img src="../../public/images/avatar.jpg" alt="Default Profile Picture" width="100">
        <br>
        <label for="user_name">Username:</label>
        <input type="text" name="user_name" value="<?php echo $user['user_name']; ?>" required readonly>
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
    <br>
    <a href="../../index.php">Home</a>
</body>

</html>