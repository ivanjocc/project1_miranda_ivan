<?php
include('../../config/database.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    // Redirect to login page or handle unauthorized access
    header("Location: ../auth/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Process the form data and send it to process_confirm_order.php
    $_SESSION['shipping_address'] = [
        'street_name' => $_POST['street_name'],
        'street_nb' => $_POST['street_nb'],
        'city' => $_POST['city'],
        'province' => $_POST['province'],
        'zip_code' => $_POST['zip_code'],
        'country' => $_POST['country'],
    ];

    header("Location: process_confirm_order.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Order</title>
</head>
<body>
    <h1>Confirm Your Order</h1>
    <form action="confirm_order.php" method="POST">
        <!-- Add fields for shipping address -->
        <label for="street_name">Street Name:</label>
        <input type="text" name="street_name" required><br>

        <!-- Add other address fields as needed -->

        <button type="submit">Confirm Order</button>
    </form>
</body>
</html>
