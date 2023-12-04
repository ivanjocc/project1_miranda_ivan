<?php
require_once('../../config/database.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verificar campos vacíos
    $required_fields = ['user_name', 'email', 'pwd', 'street_name', 'street_nb', 'city', 'province', 'zip_code', 'country'];
    $errors = [];

    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            $errors[] = "The '$field' field is required.";
        }
    }

    if (!empty($errors)) {
        // Redirigir con mensajes de error
        $error_message = implode("<br>", $errors);
        header("Location: register.php?error=$error_message");
        exit();
    }

    // Recibir datos del formulario
    $user_name = $_POST['user_name'];
    $email = $_POST['email'];
    $pwd = $_POST['pwd'];
    $street_name = $_POST['street_name'];
    $street_nb = $_POST['street_nb'];
    $city = $_POST['city'];
    $province = $_POST['province'];
    $zip_code = $_POST['zip_code'];
    $country = $_POST['country'];

    // Hash de la contraseña
    $hashed_password = password_hash($pwd, PASSWORD_DEFAULT);

    // Inserción del nuevo usuario en la tabla 'user'
    $sql_user = "INSERT INTO `user` (`user_name`, `email`, `pwd`, `role_id`) 
                 VALUES ('$user_name', '$email', '$hashed_password', (SELECT `id` FROM `role` WHERE `name` = 'client'))";

    if (mysqli_query($conn, $sql_user)) {
        // Obtener el ID del usuario recién registrado
        $user_id = mysqli_insert_id($conn);

        // Inserción de la dirección en la tabla 'address'
        $sql_address = "INSERT INTO `address` (`street_name`, `street_nb`, `city`, `province`, `zip_code`, `country`)
                        VALUES ('$street_name', '$street_nb', '$city', '$province', '$zip_code', '$country')";

        if (mysqli_query($conn, $sql_address)) {
            // Obtener el ID de la dirección recién registrada
            $address_id = mysqli_insert_id($conn);

            // Actualizar el ID de la dirección en la tabla 'user'
            $sql_update_user = "UPDATE `user` SET `billing_address_id` = $address_id, `shipping_address_id` = $address_id
                                WHERE `id` = $user_id";

            if (mysqli_query($conn, $sql_update_user)) {
                header("Location: profile.php");
            } else {
                echo "Error updating user with address ID: " . mysqli_error($conn);
            }
        } else {
            echo "Error inserting address: " . mysqli_error($conn);
        }
    } else {
        echo "Error registering user: " . mysqli_error($conn);
    }
} else {
    echo "Access not allowed";
}

// Cerrar la conexión a la base de datos
mysqli_close($conn);
?>
