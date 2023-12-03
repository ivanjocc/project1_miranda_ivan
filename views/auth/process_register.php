<?php
require_once('../../config/database.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Receive form data
    $user_name = $_POST['user_name'];
    $email = $_POST['email'];
    $pwd = $_POST['pwd'];

    // Hash the password
    $hashed_password = password_hash($pwd, PASSWORD_DEFAULT);

    // Insert the new user into the database
    $sql = "INSERT INTO `user` (`user_name`, `email`, `pwd`, `role_id`) 
            VALUES ('$user_name', '$email', '$hashed_password', (SELECT `id` FROM `role` WHERE `name` = 'client'))";

    if (mysqli_query($conn, $sql)) {
        header("Location: profile.php");
    } else {
        echo "Error registering user: " . mysqli_error($conn);
    }
} else {
    echo "Access not allowed";
}

// Close the database connection
mysqli_close($conn);
?>
