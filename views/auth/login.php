<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../../public/css/styles.css">
</head>
<body>
    <header>
        <h1>Login</h1>
    </header>

    <nav>
        <!-- Navigation menu for the authentication interface, if needed -->
    </nav>

    <main>
        <form action="process_login.php" method="post">
            <label for="userName">Username:</label>
            <input type="text" id="userName" name="userName" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Login</button>
        </form>

        <p>Don't have an account? <a href="register.php">Register here</a>.</p>
    </main>

    <footer>
        <!-- Footer content, if needed -->
    </footer>
</body>
</html>
