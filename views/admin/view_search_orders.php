<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Orders</title>
    <link rel="stylesheet" href="../../public/css/cursor.css">
    <style>
        /* Styles for the page layout and search form */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        h1,
        h2 {
            /* Styles for heading sections */
            background-color: #007BFF;
            color: #fff;
            padding: 10px;
            text-align: center;
        }

        form {
            /* Styles for the search form */
            width: 50%;
            margin: 20px auto;
            padding: 15px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            /* Styles for form labels */
            display: block;
            margin-bottom: 8px;
        }

        input[type="text"] {
            /* Styles for text input fields */
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            box-sizing: border-box;
        }

        button {
            /* Styles for the search button */
            background-color: #007BFF;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            /* Hover effect for the search button */
            background-color: #0056b3;
        }

        .dashboard-link {
            /* Styles for the Dashboard link */
            display: block;
            text-align: center;
            margin-top: 10px;
            padding: 10px 15px;
            color: #fff;
            background-color: #28a745;
            text-decoration: none;
            border-radius: 4px;
        }

        .dashboard-link:hover {
            /* Hover effect for the Dashboard link */
            background-color: #218838;
        }

        hr {
            /* Styles for the horizontal rule */
            margin: 20px 0;
            border: 0;
            border-top: 1px solid #ddd;
        }

        h2 {
            /* Styles for secondary headings */
            margin-top: 20px;
        }

        /* Styles for bold labels */
        Order ID,
        Reference,
        Date,
        Total,
        User ID {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <h1>Search Orders</h1>
    <span style="color: red; font-weight: bold;">Note: Write 'ord' and click in 'Search' to see all the orders</span>

    <!-- Search Form -->
    <form action="view_search_orders.php" method="post">
        <label for="search_ref">Search by Reference:</label>
        <input type="text" name="search_ref" required>
        <button type="submit">Search</button>
    </form>

    <!-- Dashboard Link -->
    <a class="dashboard-link" href="./dashboard.php">Dashboard</a>
</body>

</html>

<?php
// Start a session
session_start();

// Check if the user is authenticated
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page if the user is not authenticated
    header("Location: ../auth/login.php");
    exit();
}

// Get the user role from the session
$user_role = $_SESSION['user_role'];

// Check if the user has the administrator role
if ($user_role != 1) {
    // Redirect to the home page if the user is not an administrator
    header("Location: ../../index.php");
    exit();
}

// Require the database configuration file
require_once('../../config/database.php');

// Handle order search
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get and sanitize the search reference
    $search_ref = mysqli_real_escape_string($conn, $_POST['search_ref']);

    // Query to search for orders containing the provided reference
    $search_query = "SELECT * FROM `user_order` WHERE `ref` LIKE '%$search_ref%'";
    $search_result = mysqli_query($conn, $search_query);

    if ($search_result) {
        // Display search results
        echo "<h2>Search Results</h2>";
        while ($order = mysqli_fetch_assoc($search_result)) {
            echo "Order ID: " . $order['id'] . "<br>";
            echo "Reference: " . $order['ref'] . "<br>";
            echo "Date: " . $order['date'] . "<br>";
            echo "Total: $" . $order['total'] . "<br>";
            echo "User ID: " . $order['user_id'] . "<br>";
            echo "<hr>";
        }
    } else {
        echo "Error in search: " . mysqli_error($conn);
    }
}

// Close the database connection
mysqli_close($conn);
?>
