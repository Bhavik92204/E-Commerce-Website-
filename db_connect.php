<?php
// db_connect.php

$hostname = "localhost"; 
$username = "quizoni1_admin"; 
$password = "adminpass123!"; 
$database = "quizoni1_miraiProject"; 

// Create connection
$conn = new mysqli($hostname, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
