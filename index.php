<?php
session_start(); 


require_once 'db_connect.php';


require_once 'functions.php';

// Check if user is not logged in, redirect to landingPage
if (!isset($_SESSION['username'])) {
    header("Location: landingPage.php");
    exit;
}

// Get username from session
$username = $_SESSION['username'];

// Determine if the logged-in user is an employee
$is_employee = isEmployee($conn, $username);

// Log user activity
logActivity($conn, $username, 'Visited Home', 'User visited the home page.');

// Check if the Sign Out button is clicked
if (isset($_GET['logout'])) {

    logActivity($conn, $username, 'Logged Out', 'User logged out from the system.');

   
    session_unset();
    session_destroy();

    // Redirect to landingPage after logging out
    header("Location: landingPage.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mirai E-Commerce | Home</title>
    <link rel="stylesheet" href="styles.css">
    <style>
       
        .carousel {
            width: 60%;
            margin: 20px auto;
            overflow: hidden;
            position: relative;
        }
        .carousel-inner {
            display: flex;
            transition: transform 0.5s ease;
        }
        .carousel-item {
            display: none;
            flex: 0 0 100%;
            justify-content: center;
            align-items: center;
            border: 2px solid #0033a0; 
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .carousel-item.active {
            display: flex;
        }
        .product-image {
            width: 100%;
            height: auto;
            object-fit: contain;
        }
        .carousel-controls {
            position: absolute;
            bottom: 10px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .carousel-control {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background-color: #bbb;
            margin: 0 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .carousel-control.active {
            background-color: #0033a0;
        }
    </style>
</head>
<body>
    
    <header style="position: relative;">
        <img src="images/logo.png" alt="Mirai Logo" style="width: 200px; height: auto; position: absolute; top: 10px; left: 10px;">
        <h1>Welcome to Mirai</h1>
        <h2>Shop Tokyo 2020 Olympic Merchandise</h2>

        
        <nav class="navigation">
            <a href="index.php" class="button">Home</a>
            <a href="products.php" class="button">Catalog</a>
            <a href="about_us.php" class="button">About Us</a>
            <a href="orders.php" class="button">Orders</a> <!-- New Orders button -->
            <?php if(isset($_SESSION['username'])): ?>
                <?php if($is_employee): ?>
                    <a href="employee_dashboard.php" class="button">Dashboard</a>
                <?php endif; ?>
                <a href="index.php?logout=true" class="button" style="background-color: #ffffff;">Sign Out</a>
            <?php endif; ?>
        </nav>
    </header>

   
    <div class="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="images/carousel1.jpg" class="product-image" alt="Product 1">
            </div>
            <div class="carousel-item">
                <img src="images/carousel2.jpg" class="product-image" alt="Product 2">
            </div>
            <div class="carousel-item">
                <img src="images/carousel3.jpg" class="product-image" alt="Product 3">
            </div>
            
        </div>

        
        <div class="carousel-controls">
            <span class="carousel-control active"></span>
            <span class="carousel-control"></span>
            <span class="carousel-control"></span>
        </div>
    </div>

    
    <footer>
        <p>&copy; 2024 Mirai E-Commerce. All rights reserved.</p>
    </footer>

    
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const carouselItems = document.querySelectorAll('.carousel-item');
            const carouselControls = document.querySelectorAll('.carousel-control');

            let currentSlide = 0;
            const slideInterval = 7000; // 7 seconds interval for auto rotation
            let slideTimer; 

            function nextSlide() {
                carouselItems[currentSlide].classList.remove('active');
                carouselControls[currentSlide].classList.remove('active');
                currentSlide = (currentSlide + 1) % carouselItems.length;
                carouselItems[currentSlide].classList.add('active');
                carouselControls[currentSlide].classList.add('active');
            }

           
            carouselItems[currentSlide].classList.add('active');
            carouselControls[currentSlide].classList.add('active');

           
            function startSlideInterval() {
                slideTimer = setInterval(nextSlide, slideInterval);
            }

            startSlideInterval(); 

           
            carouselControls.forEach((control, index) => {
                control.addEventListener('click', () => {
                    clearInterval(slideTimer); 
                    carouselItems[currentSlide].classList.remove('active');
                    carouselControls[currentSlide].classList.remove('active');
                    currentSlide = index;
                    carouselItems[currentSlide].classList.add('active');
                    carouselControls[currentSlide].classList.add('active');
                    startSlideInterval(); 
                });
            });
        });
    </script>
</body>
</html>
