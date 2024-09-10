<?php
session_start();

$servername = "localhost";
$username = "quizoni1_admin";
$password = "adminpass123!";
$dbname = "quizoni1_miraiProject";

// Initialize cart if not already set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

// Handle Add to Cart and Head to Checkout actions
if (isset($_POST['action'])) {
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $quantity = $_POST['quantity']; 

    // Add item to cart with quantity
    if ($_POST['action'] == 'add_to_cart') {
        $_SESSION['cart'][] = array(
            'id' => $product_id,
            'name' => $product_name,
            'price' => $product_price,
            'quantity' => $quantity 
        );
    } elseif ($_POST['action'] == 'head_to_checkout') {
        // Directly add the selected item to cart with quantity of 1 for checkout
        $_SESSION['cart'] = array(
            array(
                'id' => $product_id,
                'name' => $product_name,
                'price' => $product_price,
                'quantity' => 1 
            )
        );

       
        header("Location: cart.php");
        exit;
    }
}


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle Search
$search_query = "";
$sql = "SELECT * FROM products";
if (isset($_GET['search'])) {
    $search_query = $_GET['search'];
    $sql .= " WHERE name LIKE '%$search_query%'";
} elseif (isset($_GET['category'])) {
    $category = $_GET['category'];
    $sql .= " WHERE category = '$category'";
}

$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Catalog</title>
    <style>
        /* Styling for product items */
        .product-grid {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            padding: 20px;
        }
        .product-item {
            background-color: #ffffff;
            border: 2px solid #0033a0; 
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            width: calc(33% - 20px); 
            margin-bottom: 30px; 
        }
        .product-item img {
            width: 100%;
            height: auto;
        }
        .product-item h3 {
            color: #0033a0;
            margin: 10px 0;
        }
        .product-item p {
            color: #0033a0; 
            font-size: 1.2em;
            margin: 10px 0;
        }
        .product-item .add-to-cart,
        .product-item .head-to-checkout {
            display: inline-block;
            padding: 10px 20px;
            background-color: #ffffff; 
            color: #0033a0; 
            text-decoration: none;
            border: 2px solid #0033a0; 
            border-radius: 5px;
            transition: background-color 0.3s ease, color 0.3s ease;
            margin-bottom: 20px;
            margin-right: 10px;
        }
        .product-item .add-to-cart:hover,
        .product-item .head-to-checkout:hover {
            background-color: #0033a0; 
            color: #ffffff; 
        }
        .product-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
        .search-form {
            margin-bottom: 20px;
            text-align: center;
        }
        .search-form input[type=text] {
            padding: 10px;
            width: 200px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .search-form button {
            padding: 10px 20px;
            background-color: #0033a0;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .search-form button:hover {
            background-color: #001f66;
        }
        .cart-section {
            text-align: center;
            margin-top: 20px;
        }
        .cart-section a {
            display: inline-block;
            padding: 10px 20px;
            background-color: #0033a0;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
            margin-right: 15px; 
            margin-bottom: 10px;
        }
        .cart-section a:hover {
            background-color: #001f66;
        }
        .category-links {
            text-align: center;
            margin-bottom: 25px;
        }
        .category-links a {
            display: inline-block;
            padding: 10px 20px;
            background-color: #0033a0;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
            margin-right: 10px;
        }
        .category-links a:hover {
            background-color: #001f66;
        }
    </style>
</head>
<body>
    <div class="search-form">
        <form action="" method="GET">
            <input type="text" name="search" placeholder="Search products..." value="<?php echo htmlspecialchars($search_query); ?>">
            <button type="submit">Search</button>
        </form>
    </div>

    <div class="cart-section">
        <a href="index.php" class="navigation-link">Home</a>
        <a href="products.php" class="navigation-link">Catalog</a>
        <a href="cart.php" class="navigation-link">View Cart</a>
    </div>

    <div class="category-links">
        <a href="products.php?category=Apparel">Apparel</a>
        <a href="products.php?category=Accessories">Accessories</a>
        <a href="products.php?category=Limited-Edition Collectibles">Limited-Edition Collectibles</a>
        <a href="products.php?category=Sports">Sports</a>
        <a href="products.php?category=Home and Interior">Home and Interior</a>
    </div>

    <div class="product-grid">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="product-item">
                        <img src="uploads/' . htmlspecialchars($row["image"]) . '" alt="' . htmlspecialchars($row["name"]) . '">
                        <h3>' . htmlspecialchars($row["name"]) . '</h3>
                        <p>$' . htmlspecialchars($row["price"]) . '</p>
                        <form action="" method="POST">
                            <input type="hidden" name="product_id" value="' . htmlspecialchars($row["id"]) . '">
                            <input type="hidden" name="product_name" value="' . htmlspecialchars($row["name"]) . '">
                            <input type="hidden" name="product_price" value="' . htmlspecialchars($row["price"]) . '">
                            <label for="quantity">Quantity:</label>
                            <select name="quantity" id="quantity">';
                
                // Generate options for quantity
                for ($i = 1; $i <= $row['quantity_available']; $i++) {
                    echo '<option value="' . $i . '">' . $i . '</option>';
                }
                
                echo '</select>
                            <button type="submit" name="action" value="add_to_cart" class="add-to-cart">Add to Cart</button>
                            <button type="submit" name="action" value="head_to_checkout" class="head-to-checkout">Head to Checkout</button>
                        </form>
                    </div>';
            }
        } else {
            echo '<p>No products found.</p>';
        }
        $conn->close();
        ?>
    </div>
</body>
</html>
