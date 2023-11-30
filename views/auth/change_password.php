<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <link rel="stylesheet" href="../../public/css/styles.css">
</head>
<body>
    <header>
        <h1>Change Password</h1>
    </header>

    <nav>
        <!-- Navigation menu for the change password interface, if needed -->
    </nav>

    <main>
        <form action="process_change_password.php" method="post">
            <label for="currentPassword">Current Password:</label>
            <input type="password" id="currentPassword" name="currentPassword" required>

            <label for="newPassword">New Password:</label>
            <input type="password" id="newPassword" name="newPassword" required>

            <label for="confirmNewPassword">Confirm New Password:</label>
            <input type="password" id="confirmNewPassword" name="confirmNewPassword" required>

            <button type="submit">Change Password</button>
        </form>
    </main>

    <footer>
        <!-- Footer content, if needed -->
    </footer>
</body>
</html>
