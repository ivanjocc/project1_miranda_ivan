<?php
include('../../config/database.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    // Redirigir a la página de inicio de sesión o manejar acceso no autorizado
    header("Location: ../auth/login.php");
    exit();
}

$conn = $GLOBALS['conn'];

// Obtener información del usuario
$user_id = $_SESSION['user_id'];

// Obtener información de la dirección de envío desde la base de datos
$sql = "SELECT u.*, a.*
        FROM `user` u
        JOIN `address` a ON u.shipping_address_id = a.id
        WHERE u.id = $user_id";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);

    // Obtener información de la dirección de envío
    $street_name = $row['street_name'];
    $street_nb = $row['street_nb'];
    $city = $row['city'];
    $province = $row['province'];
    $zip_code = $row['zip_code'];
    $country = $row['country'];
} else {
    // Manejar el caso en el que no se pueda obtener la información de la dirección
    // Puedes redirigir a una página de error o realizar otra acción según tus necesidades
    header("Location: failure.php");
    exit();
}

// Obtener productos del carrito
$cart_products = $_SESSION['cart'];

// Calcular el precio total basado en los productos en el carrito
$total_price = 0;
foreach ($cart_products as $product) {
    $total_price += $product['quantity'] * $product['price'];
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Order</title>
    <link rel="stylesheet" href="../../public/css/cursor.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        h1 {
            background-color: #007BFF;
            color: #fff;
            padding: 10px;
            text-align: center;
        }

        p {
            margin: 10px 0;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            border: 1px solid #ddd;
            padding: 10px;
            margin-bottom: 10px;
        }

        button {
            background-color: #007BFF;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <h1>Confirm Your Order</h1>

    <!-- Mostrar información del usuario y dirección de envío -->
    <p>User ID: <?php echo $user_id; ?></p>
    <p>Shipping Address:</p>
    <p>Street Name: <?php echo $street_name; ?></p>
    <p>Street Number: <?php echo $street_nb; ?></p>
    <p>City: <?php echo $city; ?></p>
    <p>Province: <?php echo $province; ?></p>
    <p>Zip Code: <?php echo $zip_code; ?></p>
    <p>Country: <?php echo $country; ?></p>

    <p>Cart Products:</p>
    <ul>
        <?php foreach ($cart_products as $product) : ?>
            <li>
                <?php echo $product['name']; ?> -
                Quantity: <?php echo $product['quantity']; ?>,
                Price: <?php echo $product['price']; ?>
            </li>
        <?php endforeach; ?>
    </ul>

    <!-- Formulario para enviar la orden -->
    <form action="process_confirm_order.php" method="post">
        <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
        <input type="hidden" name="total_price" value="<?php echo $total_price; ?>">
        <?php foreach ($cart_products as $product) : ?>
            <input type="hidden" name="product_id[]" value="<?php echo $product['id']; ?>">
            <input type="hidden" name="quantity[]" value="<?php echo $product['quantity']; ?>">
            <input type="hidden" name="price[]" value="<?php echo $product['price']; ?>">
        <?php endforeach; ?>
        <button type="submit">Place Order</button>
    </form>



</body>

</html>