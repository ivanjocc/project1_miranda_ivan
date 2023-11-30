<?php

class OrderController
{
    public function viewOrders($isAdmin, $userId = null)
    {
        // Lógica para obtener y mostrar las órdenes
        // (Puedes utilizar el modelo UserOrder para interactuar con la base de datos)
        // Si $isAdmin es true, muestra todas las órdenes; si es false, muestra solo las órdenes del usuario con $userId

        $conn = connexionDB(); // Asume que connexionDB es una función que establece la conexión a la base de datos

        if ($isAdmin) {
            // Obtener todas las órdenes
            $query = "SELECT * FROM user_order";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
        } else {
            // Obtener órdenes específicas del usuario
            $query = "SELECT * FROM user_order WHERE user_id = ?";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "i", $userId);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
        }

        $orders = [];

        while ($row = mysqli_fetch_assoc($result)) {
            // Puedes construir objetos de tipo Order u otro formato según tu necesidad
            $orders[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($conn);

        return $orders;
    }

    public function confirmOrder($userId, $products, $billingAddressId, $shippingAddressId)
    {
        // Lógica para confirmar una nueva orden
        // (Puedes utilizar los modelos UserOrder y OrderHasProduct para interactuar con la base de datos)

        $conn = connexionDB(); // Asume que connexionDB es una función que establece la conexión a la base de datos

        // Crear una nueva orden
        $insertOrderQuery = "INSERT INTO user_order (ref, date, total, user_id) VALUES (?, NOW(), ?, ?)";
        $insertOrderStmt = mysqli_prepare($conn, $insertOrderQuery);
        $ref = uniqid('ORDER');
        $total = 0;

        // Calcular el total de la orden y realizar la inserción en OrderHasProduct
        foreach ($products as $product) {
            $total += $product['quantity'] * $product['price'];
        }

        mysqli_stmt_bind_param($insertOrderStmt, "sdi", $ref, $total, $userId);
        $orderResult = mysqli_stmt_execute($insertOrderStmt);

        if ($orderResult) {
            // Obtener el ID de la orden recién creada
            $orderId = mysqli_insert_id($conn);

            // Insertar productos en OrderHasProduct
            $insertOrderProductQuery = "INSERT INTO order_has_product (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)";
            $insertOrderProductStmt = mysqli_prepare($conn, $insertOrderProductQuery);

            foreach ($products as $product) {
                mysqli_stmt_bind_param($insertOrderProductStmt, "iidi", $orderId, $product['id'], $product['quantity'], $product['price']);
                mysqli_stmt_execute($insertOrderProductStmt);
            }

            mysqli_stmt_close($insertOrderProductStmt);
        }

        mysqli_stmt_close($insertOrderStmt);
        mysqli_close($conn);

        return $orderResult;
    }
}

?>
