<?php
session_start();

// Define the function for calculating the cart total
function calculateCartTotal($cartItems) {
    $total = 0;

    foreach ($cartItems as $item) {
        $total += $item['quantity'] * $item['price'];
    }

    return $total;
}

// Check if the cart is set in the session
if (isset($_SESSION["cart"])) {
    $cartItems = $_SESSION["cart"];

    // Perform any necessary calculations for $cartTotal
    $cartTotal = calculateCartTotal($cartItems);
} else {
    // If the cart is empty, set $cartItems as an empty array
    $cartItems = [];
    $cartTotal = 0;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Cart</title>
    <link rel="stylesheet" href="../../public/css/styles.css">
</head>

<body>
    <header>
        <h1>Shopping Cart</h1>
    </header>

    <nav>
        <!-- Navigation menu for the shopping cart interface, if needed -->
    </nav>

    <main>
        <?php if (empty($cartItems)) : ?>
            <p>Your cart is empty.</p>
        <?php else : ?>
            <table>
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Total</th>
                        <!-- <th>Action</th> -->
                    </tr>
                </thead>
                <tbody>
                    <!-- Loop through cart items and display information -->
                    <?php foreach ($cartItems as $item) : ?>
                        <tr>
                            <td><?php echo $item['name']; ?></td>
                            <td><?php echo $item['quantity']; ?></td>
                            <td><?php echo $item['price']; ?></td>
                            <td><?php echo $item['quantity'] * $item['price']; ?></td>
                            <!-- <td>
                                <a href="update_cart_item.php?productId=<?php echo $item['id']; ?>">Update</a>
                                |
                                <a href="remove_from_cart.php?productId=<?php echo $item['id']; ?>" onclick="return confirm('Are you sure you want to remove this item from the cart?')">Remove</a>
                            </td> -->
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <p>Total: <?php echo $cartTotal; ?></p>
            <a href="../order/confirm_order.php">Proceed to Checkout</a>
        <?php endif; ?>
    </main>

    <footer>
        <!-- Footer content, if needed -->
    </footer>
</body>

</html>
