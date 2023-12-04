<?php
require_once('../../config/database.php');

session_start();
if (!isset($_SESSION['user_id'])) {
    // Redirigir a la página de inicio de sesión si el usuario no está autenticado
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Change Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        h2 {
            color: #333;
            text-align: center;
        }

        form {
            max-width: 400px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 16px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #4caf50;
            color: #fff;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        a {
            display: block;
            margin-top: 20px;
            text-decoration: none;
            color: #3498db;
            text-align: center;
        }

        a:hover {
            text-decoration: underline;
            color: #2a78ad;
        }

        .error {
            color: red;
        }
    </style>
</head>

<body>
    <h2>Change Password</h2>
    <form action="process_change_password.php" method="post">
        <label for="current_password">Current Password:</label>
        <input type="password" name="current_password">
        <br>
        <label for="new_password">New Password:</label>
        <input type="password" name="new_password">
        <br>
        <label for="confirm_new_password">Confirm New Password:</label>
        <input type="password" name="confirm_new_password">
        <br>
        <input type="submit" value="Change Password">
        <a href="../../index.php">Home</a>
        <?php
        // Mostrar mensajes de error si existen
        if (isset($_GET['error'])) {
            $error = $_GET['error'];
            echo "<p class='error'>$error</p>";
        }
        ?>
    </form>
</body>

</html>