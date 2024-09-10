<?php
session_start();

include 'db_connect.php';
include 'functions.php';

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Connect to database
$conn = getDBConnection(); 

// Get user ID
$username = $_SESSION['username'];
$user_id = getUserIdByUsername($conn, $username);

$conn->begin_transaction();

try {
    // Calculate total cost of the order
    $total_cost = 0;
    foreach ($_SESSION['cart'] as $item) {
        $total_cost += $item['price'] * $item['quantity'];
    }

    // Insert order into purchases table
    $sql_insert = "INSERT INTO purchases (user_id, total_cost) VALUES (?, ?)";
    $stmt_insert = $conn->prepare($sql_insert);
    
    if ($stmt_insert === false) {
        throw new Exception('SQL prepare error: ' . htmlspecialchars($conn->error));
    }
    
    $stmt_insert->bind_param("id", $user_id, $total_cost);
    $stmt_insert->execute();
    $order_id = $stmt_insert->insert_id; // Get the auto-generated order_id
    $stmt_insert->close();

    // Insert each item in the cart into purchase_items table
    foreach ($_SESSION['cart'] as $item) {
        $product_name = $item['name'];
        $quantity = $item['quantity'];
        $price = $item['price'];
        $purchase_date = date('Y-m-d H:i:s');

        // Insert into purchase_items table
        $sql_insert_item = "INSERT INTO purchase_items (order_id, user_id, product_name, quantity, price, purchase_date) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt_insert_item = $conn->prepare($sql_insert_item);
        
        if ($stmt_insert_item === false) {
            throw new Exception('SQL prepare error: ' . htmlspecialchars($conn->error));
        }
        
        $stmt_insert_item->bind_param("iisids", $order_id, $user_id, $product_name, $quantity, $price, $purchase_date);
        $stmt_insert_item->execute();
        $stmt_insert_item->close();
    }

    // Update quantity_available in products table
    foreach ($_SESSION['cart'] as $item) {
        $product_id = $item['id'];
        $quantity = $item['quantity'];

        $sql_update_product = "UPDATE products SET quantity_available = quantity_available - ? WHERE product_id = ?";
        $stmt_update_product = $conn->prepare($sql_update_product);

        if ($stmt_update_product === false) {
            throw new Exception('SQL prepare error: ' . htmlspecialchars($conn->error));
        }

        $stmt_update_product->bind_param("ii", $quantity, $product_id);
        $stmt_update_product->execute();
        $stmt_update_product->close();
    }

    // Log user activity
    logActivity($conn, $username, 'Order', 'User made a purchase');

    
    $conn->commit();

    // Clear the cart after successful checkout
    $_SESSION['cart'] = array();

    
    $conn->close();

    // Redirect to a thank you page
    header("Location: thank_you.php");
    exit;
} catch (Exception $e) {
    
    $conn->rollback();
    echo "Transaction failed: " . $e->getMessage();
}
?>
