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
    </style>
</head>

<body>
    <h2>Change Password</h2>
    <form action="process_change_password.php" method="post">
        <label for="current_password">Current Password:</label>
        <input type="password" name="current_password" required>
        <br>
        <label for="new_password">New Password:</label>
        <input type="password" name="new_password" required>
        <br>
        <label for="confirm_new_password">Confirm New Password:</label>
        <input type="password" name="confirm_new_password" required>
        <br>
        <input type="submit" value="Change Password">
        <a href="../../index.php">Home</a>
    </form>
</body>

</html>