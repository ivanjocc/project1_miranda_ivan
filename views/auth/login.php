<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <form action="process_login.php" method="post">
        <!-- Add login form fields -->
        <label for="user_name">Username:</label>
        <input type="text" name="user_name" required>
        <br>
        <label for="pwd">Password:</label>
        <input type="password" name="pwd" required>
        <br>
        <input type="submit" value="Login">
    </form>
</body>
</html>
