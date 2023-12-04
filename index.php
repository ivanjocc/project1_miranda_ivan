<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cat Shop</title>

    <style>
        /* Custom styles for adjusting image size and spacing */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            background-color: #f8f9fa; /* Background color for the entire page */
        }

        header {
            background-color: #343a40; /* Header background color */
            color: white;
            padding: 15px;
            text-align: center;
        }

        nav {
            display: flex;
            justify-content: space-around;
            list-style-type: none;
            padding: 0;
            margin: 0;
            background-color: #343a40; /* Navigation background color */
        }

        nav a {
            text-decoration: none;
            color: white;
            padding: 10px;
        }

        main {
            max-width: 1200px;
            margin: 20px auto;
        }

        .cat-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
        }

        .cat-item img {
            width: 100%;
            max-height: 200px; /* Altura máxima de las imágenes */
            object-fit: cover; /* Mantiene la relación de aspecto y cubre el contenedor */
            border-bottom: 1px solid #ddd;
        }

        .cat-item img {
            width: 100%; /* Make the image fill the container */
            height: auto; /* Maintain aspect ratio */
            border-bottom: 1px solid #ddd; /* Border between image and details */
        }

        .cat-item-details {
            padding: 10px;
        }

        form {
            display: flex;
            justify-content: center;
            margin-top: 10px;
        }

        button {
            background-color: #007bff; /* Button background color */
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3; /* Button background color on hover */
        }

        footer {
            background-color: #343a40; /* Footer background color */
            color: white;
            text-align: center;
            padding: 15px;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>

<body>

    <header>
        <nav>
            <a href="index.php">Home</a>
            <a href="views/auth/register.php">Register</a>
            <a href="views/auth/login.php">Login</a>
            <a href="views/auth/profile.php">Profile</a>
            <a href="views/order/view_cart.php">Cart</a>
        </nav>
    </header>

    <main>
        <h1>Welcome to the Cat Shop</h1>

        <div class="cat-container">
            <?php
            // Get the list of cat images from the images directory
            $catImages = glob('public/img/*.jpg');

            foreach ($catImages as $catImage) {
                // Get the filename (without the path)
                $catName = pathinfo($catImage, PATHINFO_FILENAME);

                // Display each cat with a form to add it to the cart
                echo '<div class="cat-item">';
                echo '<img src="' . $catImage . '" alt="' . $catName . '">';
                echo '<div class="cat-item-details">';
                echo '<h5>' . $catName . '</h5>';

                // Add a form with hidden fields to send product details
                echo '<form method="post">';
                echo '<input type="hidden" name="product_id" value="' . $catName . '">';
                echo '<input type="hidden" name="product_name" value="' . $catName . '">';
                echo '<input type="hidden" name="product_price" value="19.99">'; // Adjust the price as needed
                echo '<button type="submit" name="add_to_cart">Add to Cart</button>';
                echo '</form>';

                echo '</div>';
                echo '</div>';
            }
            ?>
        </div>
    </main>
    <br>

    <?php
    include('./includes/footer.php');
    ?>

</body>

</html>
