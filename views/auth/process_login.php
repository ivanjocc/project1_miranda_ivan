<?php
require_once('../../config/database.php');

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_name = $_POST['user_name'];
    $password = $_POST['pwd'];

    // Fetch user data from the database based on the provided username
    $sql = "SELECT * FROM `user` WHERE `user_name` = '$user_name'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $user = mysqli_fetch_assoc($result);

        // Check if the password matches and the user is an admin
        if ($user && password_verify($password, $user['pwd']) && $user['role_id'] == 1) {
            // Password is correct, start the session and store user ID and role
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_role'] = $user['role_id'];

            // Redirect based on the user's role
            if ($user['role_id'] == 1) { // Use '==' for loose comparison
                header("Location: ../admin/dashboard.php");
            } else {
                header("Location: profile.php");
            }
            exit();
        } else {
            echo "Invalid username or password for admin";
        }
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    echo "Access not allowed";
}

// Close the database connection
mysqli_close($conn);
?>
