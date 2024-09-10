<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center; /* Center content */
        }
        header {
            background-color: #002366;
            color: #ffffff;
            padding: 10px;
            text-align: center;
            border-radius: 8px 8px 0 0;
            position: relative; /* To position the home button */
        }
        .home-button {
            position: absolute;
            left: 10px;
            top: 10px;
            padding: 10px 20px;
            background-color: #007BFF;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        .home-button:hover {
            background-color: #0056b3;
        }
        h1 {
            margin: 10px 0;
        }
        footer {
            text-align: center;
            padding: 10px;
            background-color: #002366;
            color: #ffffff;
            border-radius: 0 0 8px 8px;
            margin-top: auto;
        }
        .content {
            padding: 20px;
        }
        .image-container {
            margin-top: 20px;
        }
        .image-container img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
        }
    </style>
</head>
<body>
<header>
    <a href="index.php" class="home-button">Home</a>
    <h1>About Us</h1>
</header>
<div class="container">
    <div class="content">
        <h2>Welcome to Mirai E-Commerce</h2>
        <p>Mirai E-Commerce is inspired by the Tokyo 2020 Olympic mascot, Miraitowa. Our mission is to provide high-quality, sustainable merchandise that celebrates the spirit of the Olympics. We offer a wide range of products including apparel, accessories, limited-edition collectibles, sports equipment, and home decor.</p>
        <p>Our product line includes apparel, accessories, limited-edition collectibles, sports equipment, and home decor items, all featuring our beloved Miraitowa character. Our business prioritizes high-quality products, exceptional customer satisfaction, and ethical production standards. We emphasize sustainable sourcing for our materials, ensuring that our merchandise is environmentally friendly and appealing. The Mirai platform aims to create an engaging online shopping experience with user-friendly navigation, secure payment options, and responsive customer support. By leveraging the popularity and goodwill of the Tokyo 2020 Olympic mascot, Mirai seeks to build a loyal customer base that values both the novelty of our products and the ethical values they represent.</p>
        <div class="image-container">
            <img src="images/logo2.jpg" alt="Mirai"> 
        </div>
    </div>
</div>
<footer>
    <p>&copy; 2024 Mirai E-Commerce. All rights reserved.</p>
</footer>
</body>
</html>
