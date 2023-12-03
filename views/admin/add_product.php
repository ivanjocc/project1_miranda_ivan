<!-- Añade enctype para manejar archivos -->
<form action="process_add_product.php" method="post" enctype="multipart/form-data">
    <label for="name">Product Name:</label>
    <input type="text" name="name" required><br>
    <label for="quantity">Quantity:</label>
    <input type="number" name="quantity" required><br>
    <label for="price">Price:</label>
    <input type="text" name="price" required><br>
    <!-- Añade un campo para la imagen -->
    <label for="image">Product Image (JPG only):</label>
    <input type="file" name="image" accept=".jpg" required><br>
    <label for="description">Description:</label>
    <textarea name="description" required></textarea><br>
    <input type="submit" value="Add Product">
</form>
