<?php

class AdminController {
    public function addProduct($productName, $quantity, $price, $imgUrl, $description) {

        // Crear una instancia del modelo Product
        $product = new Product(null, $productName, $quantity, $price, $imgUrl, $description);

        // Lógica para agregar el producto a la base de datos
        $conn = connexionDB();

        $query = "INSERT INTO product (name, quantity, price, img_url, description) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $query);

        if (!$stmt) {
            // Error en la preparación de la consulta
            mysqli_close($conn);
            return false;
        }

        mysqli_stmt_bind_param($stmt, "sids", $productName, $quantity, $price, $imgUrl, $description);
        $result = mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($conn);

        return $result;
    }

    public function manageUsers() {

        $conn = connexionDB();

        $query = "SELECT * FROM user";
        $result = mysqli_query($conn, $query);

        $users = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $user = new User(
                $row['id'],
                $row['user_name'],
                $row['email'],
                $row['pwd'],
                $row['fname'],
                $row['lname'],
                $row['billing_address_id'],
                $row['shipping_address_id'],
                $row['token'],
                $row['role_id']
            );
            $users[] = $user;
        }

        mysqli_close($conn);

        return $users;
    }

    public function upgradeUserToAdmin($userId) {

        $conn = connexionDB();

        // Verificar si el usuario existe
        $userQuery = "SELECT * FROM user WHERE id = ?";
        $userStmt = mysqli_prepare($conn, $userQuery);
        mysqli_stmt_bind_param($userStmt, "i", $userId);
        mysqli_stmt_execute($userStmt);
        $userResult = mysqli_stmt_get_result($userStmt);

        if ($userResult && $user = mysqli_fetch_assoc($userResult)) {
            // Actualizar el rol del usuario a administrador
            $adminRoleId = 1; // Asume que el ID del rol de administrador es 1 (ajústalo según tu base de datos)
            $updateQuery = "UPDATE user SET role_id = ? WHERE id = ?";
            $updateStmt = mysqli_prepare($conn, $updateQuery);
            mysqli_stmt_bind_param($updateStmt, "ii", $adminRoleId, $userId);
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

    public function deleteUser($userId) {

        $conn = connexionDB();

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
