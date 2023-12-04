<?php
session_start();

// Check if the user is authenticated
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page if the user is not authenticated
    header("Location: ../auth/login.php");
    exit();
}

// Get the user's role from the session
$user_role = $_SESSION['user_role'];

// Check if the user has the administrator role
if ($user_role != 1) {
    // Redirect to the homepage if the user is not an administrator
    header("Location: ../../index.php");
    exit();
}

// Simply display the list of users for now
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Manage Users</title>
    <link rel="stylesheet" href="../../public/css/cursor.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        h2 {
            background-color: #007BFF;
            color: #fff;
            padding: 10px;
            text-align: center;
        }

        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: #fff;
        }

        th,
        td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #007BFF;
            color: #fff;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        a {
            text-decoration: none;
            text-align: center;
            color: #007BFF;
            display: block;
            margin-top: 10px;
            padding: 8px;
            background-color: #fff;
            border: 1px solid #007BFF;
            border-radius: 4px;
            transition: background-color 0.3s, color 0.3s;
        }

        a:hover {
            background-color: #007BFF;
            color: #fff;
        }
    </style>

</head>

<body>
    <h2>User List</h2>
    <a href="./dashboard.php">Dashboard</a>

    <?php
    // Connect to the database (adjust the path based on your file structure)
    require_once('../../config/database.php');

    // Query to get the list of users
    $sql = "SELECT `id`, `user_name`, `email` FROM `user`";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        // Display the list of users
        echo "<table border='1'>
                <tr>
                    <th>User ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>";

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['user_name']}</td>
                    <td>{$row['email']}</td>
                    <td><a href='upgrade_user.php?user_id={$row['id']}'>Admin</a>  <a href='delete_user.php?user_id={$row['id']}'>Delete</a></td>
                </tr>";
        }

        echo "</table>";

        // Free the result set
        mysqli_free_result($result);
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    // Close the database connection
    mysqli_close($conn);
    ?>
</body>

</html>
