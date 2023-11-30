<?php

class ProductController
{
    public function viewProductDetails($productId)
    {
        // Lógica para obtener y mostrar los detalles de un producto
        // (Puedes utilizar el modelo Product para interactuar con la base de datos)

        $conn = connexionDB(); // Asume que connexionDB es una función que establece la conexión a la base de datos

        // Obtener detalles del producto
        $query = "SELECT * FROM product WHERE id = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $productId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $productDetails = mysqli_fetch_assoc($result);

        mysqli_stmt_close($stmt);
        mysqli_close($conn);

        return $productDetails;
    }

    public function addToCart($userId, $productId, $quantity)
    {
        // Lógica para agregar productos al carrito de compras
        // (Puedes utilizar los modelos User y OrderHasProduct para interactuar con la base de datos)

        $conn = connexionDB(); // Asume que connexionDB es una función que establece la conexión a la base de datos

        // Obtener el ID de la orden del usuario que está en estado de carrito (sin confirmar)
        $orderQuery = "SELECT id FROM user_order WHERE user_id = ? AND ref IS NULL";
        $orderStmt = mysqli_prepare($conn, $orderQuery);
        mysqli_stmt_bind_param($orderStmt, "i", $userId);
        mysqli_stmt_execute($orderStmt);
        $orderResult = mysqli_stmt_get_result($orderStmt);

        $orderId = null;

        if ($orderResult && $order = mysqli_fetch_assoc($orderResult)) {
            $orderId = $order['id'];
        } else {
            // Crear una nueva orden en estado de carrito (sin confirmar)
            $insertOrderQuery = "INSERT INTO user_order (date, user_id) VALUES (NOW(), ?)";
            $insertOrderStmt = mysqli_prepare($conn, $insertOrderQuery);
            mysqli_stmt_bind_param($insertOrderStmt, "i", $userId);
            mysqli_stmt_execute($insertOrderStmt);

            $orderId = mysqli_insert_id($conn);

            mysqli_stmt_close($insertOrderStmt);
        }

        // Agregar el producto al carrito (OrderHasProduct)
        $insertProductQuery = "INSERT INTO order_has_product (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)";
        $insertProductStmt = mysqli_prepare($conn, $insertProductQuery);

        // Obtener el precio del producto desde la base de datos
        $productQuery = "SELECT price FROM product WHERE id = ?";
        $productStmt = mysqli_prepare($conn, $productQuery);
        mysqli_stmt_bind_param($productStmt, "i", $productId);
        mysqli_stmt_execute($productStmt);
        $productResult = mysqli_stmt_get_result($productStmt);

        $productPrice = 0;

        if ($productResult && $product = mysqli_fetch_assoc($productResult)) {
            $productPrice = $product['price'];
        }

        mysqli_stmt_bind_param($insertProductStmt, "iiid", $orderId, $productId, $quantity, $productPrice);
        $result = mysqli_stmt_execute($insertProductStmt);

        mysqli_stmt_close($insertProductStmt);
        mysqli_stmt_close($productStmt);
        mysqli_stmt_close($orderStmt);
        mysqli_close($conn);

        return $result;
    }

    public function updateCartItem($userId, $productId, $quantity)
    {
        // Lógica para actualizar la cantidad de un producto en el carrito de compras
        // (Puedes utilizar los modelos User y OrderHasProduct para interactuar con la base de datos)

        $conn = connexionDB(); // Asume que connexionDB es una función que establece la conexión a la base de datos

        // Obtener el ID de la orden del usuario que está en estado de carrito (sin confirmar)
        $orderQuery = "SELECT id FROM user_order WHERE user_id = ? AND ref IS NULL";
        $orderStmt = mysqli_prepare($conn, $orderQuery);
        mysqli_stmt_bind_param($orderStmt, "i", $userId);
        mysqli_stmt_execute($orderStmt);
        $orderResult = mysqli_stmt_get_result($orderStmt);

        $orderId = null;

        if ($orderResult && $order = mysqli_fetch_assoc($orderResult)) {
            $orderId = $order['id'];
        } else {
            // Crear una nueva orden en estado de carrito (sin confirmar)
            $insertOrderQuery = "INSERT INTO user_order (date, user_id) VALUES (NOW(), ?)";
            $insertOrderStmt = mysqli_prepare($conn, $insertOrderQuery);
            mysqli_stmt_bind_param($insertOrderStmt, "i", $userId);
            mysqli_stmt_execute($insertOrderStmt);

            $orderId = mysqli_insert_id($conn);

            mysqli_stmt_close($insertOrderStmt);
        }

        // Actualizar la cantidad del producto en el carrito (OrderHasProduct)
        $updateProductQuery = "UPDATE order_has_product SET quantity = ? WHERE order_id = ? AND product_id = ?";
        $updateProductStmt = mysqli_prepare($conn, $updateProductQuery);
        mysqli_stmt_bind_param($updateProductStmt, "iii", $quantity, $orderId, $productId);
        $result = mysqli_stmt_execute($updateProductStmt);

        mysqli_stmt_close($updateProductStmt);
        mysqli_stmt_close($orderStmt);
        mysqli_close($conn);

        return $result;
    }

    public function removeFromCart($userId, $productId)
    {
        // Lógica para eliminar un producto del carrito de compras
        // (Puedes utilizar los modelos User y OrderHasProduct para interactuar con la base de datos)

        $conn = connexionDB(); // Asume que connexionDB es una función que establece la conexión a la base de datos

        // Obtener el ID de la orden del usuario que está en estado de carrito (sin confirmar)
        $orderQuery = "SELECT id FROM user_order WHERE user_id = ? AND ref IS NULL";
        $orderStmt = mysqli_prepare($conn, $orderQuery);
        mysqli_stmt_bind_param($orderStmt, "i", $userId);
        mysqli_stmt_execute($orderStmt);
        $orderResult = mysqli_stmt_get_result($orderStmt);

        $orderId = null;

        if ($orderResult && $order = mysqli_fetch_assoc($orderResult)) {
            $orderId = $order['id'];
        }

        // Eliminar el producto del carrito (OrderHasProduct)
        $deleteProductQuery = "DELETE FROM order_has_product WHERE order_id = ? AND product_id = ?";
        $deleteProductStmt = mysqli_prepare($conn, $deleteProductQuery);
        mysqli_stmt_bind_param($deleteProductStmt, "ii", $orderId, $productId);
        $result = mysqli_stmt_execute($deleteProductStmt);

        mysqli_stmt_close($deleteProductStmt);
        mysqli_stmt_close($orderStmt);
        mysqli_close($conn);

        return $result;
    }

    public function viewCart($userId)
    {
        // Lógica para mostrar el contenido del carrito de compras
        // (Puedes utilizar los modelos User y OrderHasProduct para interactuar con la base de datos)

        $conn = connexionDB(); // Asume que connexionDB es una función que establece la conexión a la base de datos

        // Obtener el ID de la orden del usuario que está en estado de carrito (sin confirmar)
        $orderQuery = "SELECT id FROM user_order WHERE user_id = ? AND ref IS NULL";
        $orderStmt = mysqli_prepare($conn, $orderQuery);
        mysqli_stmt_bind_param($orderStmt, "i", $userId);
        mysqli_stmt_execute($orderStmt);
        $orderResult = mysqli_stmt_get_result($orderStmt);

        $orderId = null;

        if ($orderResult && $order = mysqli_fetch_assoc($orderResult)) {
            $orderId = $order['id'];
        }

        // Obtener los productos en el carrito (OrderHasProduct)
        $cartQuery = "SELECT p.id, p.name, o.quantity, o.price FROM order_has_product o
                      INNER JOIN product p ON o.product_id = p.id
                      WHERE o.order_id = ?";
        $cartStmt = mysqli_prepare($conn, $cartQuery);
        mysqli_stmt_bind_param($cartStmt, "i", $orderId);
        mysqli_stmt_execute($cartStmt);
        $cartResult = mysqli_stmt_get_result($cartStmt);

        $cartItems = [];

        while ($item = mysqli_fetch_assoc($cartResult)) {
            $cartItems[] = $item;
        }

        mysqli_stmt_close($cartStmt);
        mysqli_stmt_close($orderStmt);
        mysqli_close($conn);

        return $cartItems;
    }
}

?>
