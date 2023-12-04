<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>User Registration</title>
    <link rel="stylesheet" href="../../public/css/cursor.css">
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
    <h2>User Registration</h2>
    <form action="process_register.php" method="post">
        <!-- Campos para la tabla 'user' -->
        <label for="user_name">Username:</label>
        <input type="text" name="user_name">
        <br>
        <label for="email">Email:</label>
        <input type="email" name="email">
        <br>
        <label for="pwd">Password:</label>
        <input type="password" name="pwd">
        <br>

        <!-- Campos adicionales para la tabla 'address' -->
        <label for="street_name">Street Name:</label>
        <input type="text" name="street_name">
        <br>
        <label for="street_nb">Street Number:</label>
        <input type="text" name="street_nb">
        <br>
        <label for="city">City:</label>
        <input type="text" name="city">
        <br>
        <label for="province">Province:</label>
        <input type="text" name="province">
        <br>
        <label for="zip_code">Zip Code:</label>
        <input type="text" name="zip_code">
        <br>
        <label for="country">Country:</label>
        <input type="text" name="country">
        <br>

        <input type="submit" value="Register">
        <a href="../../index.php">Home</a>

        <?php
        // Mostrar mensajes de error si existen
        if (isset($_GET['error'])) {
            $error = $_GET['error'];
            echo "<p style='color:red'>$error</p>";
        }
        ?>
    </form>
</body>

</html>