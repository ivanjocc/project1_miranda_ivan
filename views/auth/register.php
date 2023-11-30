<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="../../public/css/styles.css">
</head>
<body>
    <header>
        <h1>Register</h1>
    </header>

    <nav>
        <!-- Navigation menu for the registration interface, if needed -->
    </nav>

    <main>
        <form action="process_register.php" method="post">
            <label for="userName">Username:</label>
            <input type="text" id="userName" name="userName" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <label for="firstName">First Name:</label>
            <input type="text" id="firstName" name="firstName" required>

            <label for="lastName">Last Name:</label>
            <input type="text" id="lastName" name="lastName" required>

            <button type="submit">Register</button>
        </form>

        <p>Already have an account? <a href="login.php">Login here</a>.</p>
    </main>

    <footer>
        <!-- Footer content, if needed -->
    </footer>
</body>
</html>
