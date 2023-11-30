<?php

class AuthController
{
    public function register($userName, $email, $password, $firstName, $lastName)
    {
        // Lógica para registrar un nuevo usuario
        // (Puedes utilizar el modelo User para interactuar con la base de datos)

        $conn = connexionDB(); // Asume que connexionDB es una función que establece la conexión a la base de datos

        // Verificar si el nombre de usuario o correo electrónico ya existe
        $checkQuery = "SELECT * FROM user WHERE user_name = ? OR email = ?";
        $checkStmt = mysqli_prepare($conn, $checkQuery);
        mysqli_stmt_bind_param($checkStmt, "ss", $userName, $email);
        mysqli_stmt_execute($checkStmt);
        $checkResult = mysqli_stmt_get_result($checkStmt);

        if ($checkResult && mysqli_fetch_assoc($checkResult)) {
            // El nombre de usuario o correo electrónico ya está en uso
            $result = false;
        } else {
            // Registrar al nuevo usuario
            $hashPassword = password_hash($password, PASSWORD_DEFAULT);
            $role_id = 2; // Asume que el ID del rol de cliente es 2 (ajústalo según tu base de datos)

            $insertQuery = "INSERT INTO user (user_name, email, pwd, fname, lname, role_id) VALUES (?, ?, ?, ?, ?, ?)";
            $insertStmt = mysqli_prepare($conn, $insertQuery);
            mysqli_stmt_bind_param($insertStmt, "sssssi", $userName, $email, $hashPassword, $firstName, $lastName, $role_id);
            $result = mysqli_stmt_execute($insertStmt);

            mysqli_stmt_close($insertStmt);
        }

        mysqli_stmt_close($checkStmt);
        mysqli_close($conn);

        return $result;
    }

    public function login($userName, $password)
    {
        // Lógica para realizar el inicio de sesión
        // (Puedes utilizar el modelo User para interactuar con la base de datos)

        $conn = connexionDB(); // Asume que connexionDB es una función que establece la conexión a la base de datos

        // Obtener información del usuario por nombre de usuario
        $query = "SELECT * FROM user WHERE user_name = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "s", $userName);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result && $user = mysqli_fetch_assoc($result)) {
            // Verificar la contraseña
            if (password_verify($password, $user['pwd'])) {
                // Inicio de sesión exitoso
                mysqli_stmt_close($stmt);
                mysqli_close($conn);

                return true;
            }
        }

        // Inicio de sesión fallido
        mysqli_stmt_close($stmt);
        mysqli_close($conn);

        return false;
    }

    public function logout()
    {
        // Lógica para cerrar la sesión del usuario

        // Puedes usar sesiones en PHP para gestionar el inicio y cierre de sesión
        session_start();

        // Destruir todas las variables de sesión
        $_SESSION = array();

        // Si se desea destruir la sesión completamente, borra también la cookie de la sesión
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }

        // Finalmente, destruir la sesión
        session_destroy();

        // Retorna true si el cierre de sesión fue exitoso
        return true;
    }

    public function deleteAccount($userId)
    {
        // Lógica para eliminar la cuenta de un usuario
        // (Puedes utilizar el modelo User para interactuar con la base de datos)

        $conn = connexionDB(); // Asume que connexionDB es una función que establece la conexión a la base de datos

        // Verificar si el usuario existe
        $userQuery = "SELECT * FROM user WHERE id = ?";
        $userStmt = mysqli_prepare($conn, $userQuery);
        mysqli_stmt_bind_param($userStmt, "i", $userId);
        mysqli_stmt_execute($userStmt);
        $userResult = mysqli_stmt_get_result($userStmt);

        if ($userResult && $user = mysqli_fetch_assoc($userResult)) {
            // Eliminar al usuario
            $deleteQuery = "DELETE FROM user WHERE id = ?";
            $deleteStmt = mysqli_prepare($conn, $deleteQuery);
            mysqli_stmt_bind_param($deleteStmt, "i", $userId);
            $result = mysqli_stmt_execute($deleteStmt);

            mysqli_stmt_close($deleteStmt);

            // También puedes llamar a la función de logout si deseas cerrar la sesión al eliminar la cuenta
            // $this->logout();
        } else {
            // El usuario no existe
            $result = false;
        }

        mysqli_stmt_close($userStmt);
        mysqli_close($conn);

        return $result;
    }

    public function updateProfile($userId, $firstName, $lastName)
    {
        // Lógica para actualizar el perfil de un usuario
        // (Puedes utilizar el modelo User para interactuar con la base de datos)

        $conn = connexionDB(); // Asume que connexionDB es una función que establece la conexión a la base de datos

        // Verificar si el usuario existe
        $userQuery = "SELECT * FROM user WHERE id = ?";
        $userStmt = mysqli_prepare($conn, $userQuery);
        mysqli_stmt_bind_param($userStmt, "i", $userId);
        mysqli_stmt_execute($userStmt);
        $userResult = mysqli_stmt_get_result($userStmt);

        if ($userResult && $user = mysqli_fetch_assoc($userResult)) {
            // Actualizar el perfil del usuario
            $updateQuery = "UPDATE user SET fname = ?, lname = ? WHERE id = ?";
            $updateStmt = mysqli_prepare($conn, $updateQuery);
            mysqli_stmt_bind_param($updateStmt, "ssi", $firstName, $lastName, $userId);
            $result = mysqli_stmt_execute($updateStmt);

            mysqli_stmt_close($updateStmt);
        } else {
            // El usuario no existe
            $result = false;
        }

        mysqli_stmt_close($userStmt);
        mysqli_close($conn);

        return $result;
    }
}

?>
