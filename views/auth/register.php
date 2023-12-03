<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Registration</title>
</head>
<body>
    <h2>User Registration</h2>
    <form action="process_register.php" method="post">
        <label for="user_name">Username:</label>
        <input type="text" name="user_name" required>
        <br>
        <label for="email">Email:</label>
        <input type="email" name="email" required>
        <br>
        <label for="pwd">Password:</label>
        <input type="password" name="pwd" required>
        <br>
        <input type="submit" value="Register">
    </form>
</body>
</html>
