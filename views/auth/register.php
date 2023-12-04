<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Registration</title>
</head>
<body>
    <h2>User Registration</h2>
    <form action="process_register.php" method="post">
        <!-- Campos para la tabla 'user' -->
        <label for="user_name">Username:</label>
        <input type="text" name="user_name" required>
        <br>
        <label for="email">Email:</label>
        <input type="email" name="email" required>
        <br>
        <label for="pwd">Password:</label>
        <input type="password" name="pwd" required>
        <br>

        <!-- Campos adicionales para la tabla 'address' -->
        <label for="street_name">Street Name:</label>
        <input type="text" name="street_name" required>
        <br>
        <label for="street_nb">Street Number:</label>
        <input type="text" name="street_nb" required>
        <br>
        <label for="city">City:</label>
        <input type="text" name="city" required>
        <br>
        <label for="province">Province:</label>
        <input type="text" name="province" required>
        <br>
        <label for="zip_code">Zip Code:</label>
        <input type="text" name="zip_code" required>
        <br>
        <label for="country">Country:</label>
        <input type="text" name="country" required>
        <br>

        <input type="submit" value="Register">
    </form>
</body>
</html>
