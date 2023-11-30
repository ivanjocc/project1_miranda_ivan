<?php
require_once('../../config/database.php');
require_once('../../models/User.php');

session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="../../public/css/styles.css">
</head>
<body>
    <header>
        <h1>User Profile</h1>
    </header>

    <nav>
        <!-- Navigation menu for the user profile, if needed -->
    </nav>

    <main>
        <?php if (isset($_SESSION['user_name'])) : ?>
            <h2>Welcome, <?php echo $_SESSION['user_name']; ?>!</h2>

            <!-- Resto del contenido del perfil aquí -->

        <?php else : ?>
            <p>Error: User not authenticated.</p>
        <?php endif; ?>
    </main>
    <a href="../../index.php">Home</a>
    <a href="./logout.php">LogOut</a>

    <footer>
        <!-- Footer content, if needed -->
    </footer>
</body>
</html>
