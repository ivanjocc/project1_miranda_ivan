<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link rel="stylesheet" href="../../public/css/styles.css">
</head>
<body>
    <header>
        <h1>Add Product</h1>
    </header>

    <nav>
        <!-- Navigation menu for the admin interface, if needed -->
    </nav>

    <main>
        <form action="process_add_product.php" method="post">
            <label for="productName">Product Name:</label>
            <input type="text" id="productName" name="productName" required>

            <label for="quantity">Quantity:</label>
            <input type="number" id="quantity" name="quantity" required>

            <label for="price">Price:</label>
            <input type="number" step="0.01" id="price" name="price" required>

            <label for="imgUrl">Image URL:</label>
            <input type="text" id="imgUrl" name="imgUrl" required>

            <label for="description">Description:</label>
            <textarea id="description" name="description" rows="4" required></textarea>

            <button type="submit">Add Product</button>
        </form>
    </main>

    <footer>
        <!-- Footer content, if needed -->
    </footer>
</body>
</html>
