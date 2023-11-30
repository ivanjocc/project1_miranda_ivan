<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link rel="stylesheet" href="../../public/css/styles.css">
</head>
<body>
    <header>
        <h1>Manage Users</h1>
    </header>

    <nav>
        <!-- Navigation menu for the admin interface, if needed -->
    </nav>

    <main>
        <table>
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Role</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <!-- Loop through users and display information -->
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo $user->getId(); ?></td>
                        <td><?php echo $user->getUserName(); ?></td>
                        <td><?php echo $user->getEmail(); ?></td>
                        <td><?php echo $user->getFirstName(); ?></td>
                        <td><?php echo $user->getLastName(); ?></td>
                        <td><?php echo $user->getRole(); ?></td>
                        <td>
                            <a href="upgrade_user.php?userId=<?php echo $user->getId(); ?>">Upgrade to Admin</a>
                            |
                            <a href="delete_user.php?userId=<?php echo $user->getId(); ?>" onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>

    <footer>
        <!-- Footer content, if needed -->
    </footer>
</body>
</html>
