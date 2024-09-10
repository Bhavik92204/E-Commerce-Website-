<?php
session_start();

include 'db_connect.php';
include 'functions.php';

// Check if user is logged in and is an employee
if (!isset($_SESSION['user_id']) || !isEmployee($conn, $_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Handle form submissions for insert, update, and delete operations
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['insert'])) {
        $name = $_POST['name'];
        $category = $_POST['category'];
        $price = $_POST['price'];
        $quantity = $_POST['quantity'];
        $quantity_available = $_POST['quantity_available'];
        $image = uploadImage(); 
        insertProduct($conn, $name, $category, $price, $quantity, $image, $quantity_available);
    } elseif (isset($_POST['update'])) {
        $product_id = $_POST['product_id'];
        $name = $_POST['name'];
        $category = $_POST['category'];
        $price = $_POST['price'];
        $quantity = $_POST['quantity'];
        $quantity_available = $_POST['quantity_available'];
        $image = uploadImage(); 
        updateProduct($conn, $product_id, $name, $category, $price, $quantity, $image, $quantity_available);
    } elseif (isset($_POST['delete'])) {
        $product_id = $_POST['product_id'];
        deleteProduct($conn, $product_id);
    }
}

// Function to handle image upload
function uploadImage() {
    $target_dir = "uploads/"; 
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $uploadOk = 1;

    // Check if image file is an actual image
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check === false) {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["image"]["size"] > 500000) { // 500KB limit for example
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }


    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

   
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            return basename($_FILES["image"]["name"]);
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
    return "";
}


$products = getAllProducts($conn);


logActivity($conn, $_SESSION['username'], 'Login', 'Employee logged into the dashboard.');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Dashboard</title>
    <link rel="stylesheet" href="styles.css"> 
    <style>
        /* Basic styling for demonstration */
        body {
            font-family: Arial, sans-serif;
            background-color: #A0AEBC;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh; 
        }
        html {
            height: 100%; 
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            background-color: #ffffff;
            padding: 50px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        header {
            background-color: #002366;
            color: #ffffff;
            padding: 10px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }
        h1 {
            margin: 10px 0;
            text-align: center;
        }
        .content {
            padding: 20px;
        }
        footer {
            text-align: center;
            padding: 10px;
            background-color: #002366;
            color: #ffffff;
            border-radius: 0 0 8px 8px;
            margin-top: auto; 
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #dddddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #0033a0;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
            margin-right: 10px; 
        }
        .button:hover {
            background-color: #001f66;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input, .form-group select, .form-group textarea {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }
        .home-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007BFF;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
            margin-bottom: 20px;
        }
        .home-button:hover {
            background-color: #0056b3;
        }
        .button-container {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<header>
    <h1>Employee Dashboard</h1>
</header>
<div class="container">
    <a href="index.php" class="home-button">Back to Home</a>
    <div class="content">
        <h2>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
        <p>This is the employee dashboard where you can manage products, view reports, and perform other administrative tasks.</p>

        <h3>Products</h3>
        <table>
            <thead>
                <tr>
                    <th>Product ID</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Image</th>
                    <th>Quantity Available</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                <tr>
                    <td><?php echo htmlspecialchars($product['product_id']); ?></td>
                    <td><?php echo htmlspecialchars($product['name']); ?></td>
                    <td><?php echo htmlspecialchars($product['category']); ?></td>
                    <td><?php echo htmlspecialchars($product['price']); ?></td>
                    <td><?php echo htmlspecialchars($product['quantity']); ?></td>
                    <td><?php echo htmlspecialchars($product['image']); ?></td>
                    <td><?php echo htmlspecialchars($product['quantity_available']); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h3>Insert New Product</h3>
        <form action="employee_dashboard.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="category">Category:</label>
                <input type="text" id="category" name="category" required>
            </div>
            <div class="form-group">
                <label for="price">Price:</label>
                <input type="number" step="0.01" id="price" name="price" required>
            </div>
            <div class="form-group">
                <label for="quantity">Quantity:</label>
                <input type="number" id="quantity" name="quantity" required>
            </div>
            <div class="form-group">
                <label for="image">Image:</label>
                <input type="file" id="image" name="image" required>
            </div>
            <div class="form-group">
                <label for="quantity_available">Quantity Available:</label>
                <input type="number" id="quantity_available" name="quantity_available" required>
            </div>
            <input type="submit" name="insert" value="Insert" class="button">
        </form>

        <h3>Update Product</h3>
        <form action="employee_dashboard.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="product_id">Product ID:</label>
                <input type="number" id="product_id" name="product_id" required>
            </div>
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="category">Category:</label>
                <input type="text" id="category" name="category" required>
            </div>
            <div class="form-group">
                <label for="price">Price:</label>
                <input type="number" step="0.01" id="price" name="price" required>
            </div>
            <div class="form-group">
                <label for="quantity">Quantity:</label>
                <input type="number" id="quantity" name="quantity" required>
            </div>
            <div class="form-group">
                <label for="image">Image:</label>
                <input type="file" id="image" name="image">
            </div>
            <div class="form-group">
                <label for="quantity_available">Quantity Available:</label>
                <input type="number" id="quantity_available" name="quantity_available" required>
            </div>
            <input type="submit" name="update" value="Update" class="button">
        </form>

        <h3>Delete Product</h3>
        <form action="employee_dashboard.php" method="post">
            <div class="form-group">
                <label for="product_id">Product ID:</label>
                <input type="number" id="product_id" name="product_id" required>
            </div>
            <input type="submit" name="delete" value="Delete" class="button">
        </form>

        <div class="button-container">
            <a href="purchase_items.php" class="button">View Purchase Items</a>
            <a href="user_activities.php" class="button">View User Activities</a>
        </div>
    </div>
</div>
<footer>
    <p>&copy; 2024 Mirai E-Commerce. All rights reserved.</p>
</footer>
</body>
</html>
