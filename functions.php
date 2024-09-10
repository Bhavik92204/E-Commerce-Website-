<?php
function logActivity($conn, $username, $activity_type, $activity_description = '') {
    $sql = "INSERT INTO user_activities (username, activity_type, activity_description) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die('Error preparing statement: ' . $conn->error);
    }
    $stmt->bind_param("sss", $username, $activity_type, $activity_description);
    if (!$stmt->execute()) {
        die('Error executing statement: ' . $stmt->error);
    }
    $stmt->close();
}

// Function to check if a user is an employee
function isEmployee($conn, $username) {
    $sql = "SELECT * FROM users WHERE username = ? AND is_employee = 1";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die('Error preparing statement: ' . $conn->error);
    }
    $stmt->bind_param("s", $username);
    if (!$stmt->execute()) {
        die('Error executing statement: ' . $stmt->error);
    }
    $result = $stmt->get_result();
    return $result->num_rows > 0; // Return true if the user is found and is an employee
}

// Function to get all products
function getAllProducts($conn) {
    $sql = "SELECT product_id, name, category, price, quantity, image, quantity_available FROM products";
    $result = $conn->query($sql);
    $products = [];
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
    return $products;
}

// Function to insert a new product
function insertProduct($conn, $name, $category, $price, $quantity, $image, $quantity_available) {
    $sql = "INSERT INTO products (name, category, price, quantity, image, quantity_available) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssdisi", $name, $category, $price, $quantity, $image, $quantity_available);
    $stmt->execute();
    $stmt->close();
}

// Function to update a product
function updateProduct($conn, $product_id, $name, $category, $price, $quantity, $image, $quantity_available) {
    $sql = "UPDATE products SET name = ?, category = ?, price = ?, quantity = ?, image = ?, quantity_available = ? WHERE product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssdisii", $name, $category, $price, $quantity, $image, $quantity_available, $product_id);
    $stmt->execute();
    $stmt->close();
}

// Function to delete a product
function deleteProduct($conn, $product_id) {
    $sql = "DELETE FROM products WHERE product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $stmt->close();
}

function getDBConnection() {
    include 'db_connect.php';
    return $conn;
}

// Function to get user ID by username
function getUserIdByUsername($conn, $username) {
    $sql = "SELECT user_id FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        throw new Exception('SQL prepare error: ' . htmlspecialchars($conn->error));
    }
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['user_id'];
    } else {
        throw new Exception('User not found with username: ' . $username);
    }
}

?>
