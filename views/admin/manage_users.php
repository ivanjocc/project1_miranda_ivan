<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    // Redirigir a la página de inicio de sesión si el usuario no está autenticado
    header("Location: ../authlogin.php");
    exit();
}

// Obtener el rol del usuario desde la sesión
$user_role = $_SESSION['user_role'];

// Verificar si el usuario tiene el rol de administrador
if ($user_role != 1) {
    // Redirigir a la página de inicio si el usuario no es un administrador
    header("Location: ../../index.php");
    exit();
}

// Simplemente muestra la lista de usuarios por ahora
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Users</title>
</head>
<body>
    <h2>User List</h2>

    <?php
    // Conecta a la base de datos (ajusta la ruta según tu estructura de archivos)
    require_once('../../config/database.php');

    // Consulta para obtener la lista de usuarios
    $sql = "SELECT `id`, `user_name`, `email` FROM `user`";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        // Muestra la lista de usuarios
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
                    <td><a href='upgrade_user.php?user_id={$row['id']}'>Admin</a> | <a href='delete_user.php?user_id={$row['id']}'>Delete</a></td>
                </tr>";
        }

        echo "</table>";

        // Liberar el resultado
        mysqli_free_result($result);
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    // Cierra la conexión a la base de datos
    mysqli_close($conn);
    ?>
</body>
</html>
