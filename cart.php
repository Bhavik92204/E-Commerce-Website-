<?php
session_start();

include 'db_connect.php';
include 'functions.php';

// Handle Remove from Cart
if (isset($_GET['action']) && $_GET['action'] == 'remove_from_cart' && isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    // Remove item from cart
    foreach ($_SESSION['cart'] as $key => $item) {
        if ($item['id'] == $product_id) {
            unset($_SESSION['cart'][$key]);
            break;
        }
    }
    header("Location: cart.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <style>
        /* Styling for cart items */
        .cart-items {
            margin: 20px auto;
            max-width: 600px;
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 8px;
        }
        .cart-items h2 {
            color: #0033a0; /* Blue text color */
            text-align: center;
            margin-bottom: 20px;
        }
        .cart-items ul {
            list-style-type: none;
            padding: 0;
        }
        .cart-items li {
            margin-bottom: 10px;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .cart-items li .remove-link {
            color: #d9534f; /* Red text color */
            cursor: pointer;
            transition: color 0.3s ease;
        }
        .cart-items li .remove-link:hover {
            color: #a94442; /* Darker red on hover */
        }
        .cart-items li .quantity {
            margin-left: 10px;
        }
        .checkout-btn {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #0033a0;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            display: block;
            margin-left: auto;
            margin-right: auto;
            text-align: center;
            text-decoration: none;
            width: 120px;
        }
        .checkout-btn:hover {
            background-color: #001f66;
        }
        .total-cost {
            text-align: center;
            margin-top: 20px;
            margin-bottom: 10px;
            font-size: 1.2em;
        }
        .back-link {
            display: block;
            text-align: center;
            margin-top: 10px;
        }
        .back-link a {
            color: #0033a0; /* Blue text color */
            text-decoration: none;
            transition: color 0.3s ease;
        }
        .back-link a:hover {
            color: #001f66; 
        }
    </style>
</head>
<body>
    <div class="cart-items">
        <h2>Shopping Cart</h2>
        <?php
        $total_cost = 0;
        if (!empty($_SESSION['cart'])) {
            echo '<ul>';
            foreach ($_SESSION['cart'] as $key => $item) {
                echo '<li>
                        <span>' . $item['name'] . ' - $' . $item['price'] * $item['quantity'] . '</span>
                        <span class="quantity">Quantity: ' . $item['quantity'] . '</span>
                        <a href="cart.php?action=remove_from_cart&product_id=' . $item['id'] . '" class="remove-link">Remove</a>
                      </li>';
                $total_cost += $item['price'] * $item['quantity'];
            }
            echo '</ul>';
            echo '<div class="total-cost">Total Cost: $' . number_format($total_cost, 2) . '</div>';
            echo '<form method="post" action="checkout.php">
                      <input type="submit" name="checkout" value="Checkout" class="checkout-btn">
                  </form>';
        } else {
            echo '<p>Your cart is empty.</p>';
        }
        ?>
        <div class="back-link"><a href="products.php">&larr; Back to Catalog</a></div>
    </div>
</body>
</html>
