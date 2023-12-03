<?php
// Incluir la definición de la clase Order
require_once '../../models/Order.php';

// Crear una instancia de la clase Order
$newOrder = new Order(1, 'ABC123', '2023-11-29', 100.00, 123);

// Array que contiene las órdenes
$orders = [$newOrder];

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Orders</title>
    <link rel="stylesheet" href="../../public/css/styles.css">
</head>

<body>
    <header>
        <h1>View Orders</h1>
    </header>

    <nav>
        <!-- Navigation menu for the admin interface, if needed -->
    </nav>

    <main>
        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Reference</th>
                    <th>Date</th>
                    <th>Total</th>
                    <th>User ID</th>
                </tr>
            </thead>
            <tbody>
                <!-- Loop through orders and display information -->
                <?php foreach ($orders as $order) : ?>
                    <tr>
                        <td><?php echo $order->getId(); ?></td>
                        <td><?php echo $order->getReference(); ?></td>
                        <td><?php echo $order->getDate(); ?></td>
                        <td><?php echo $order->getTotal(); ?></td>
                        <td><?php echo $order->getUserId(); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>

    <footer>
        <!-- Footer content, if needed -->
    </footer>
</body>

</html>