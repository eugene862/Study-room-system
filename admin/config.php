<?php
// config.php - Database connection setup
$servername = "127.0.0.1:3307";
$username = "root";
$password = "";
$dbname = "study_room_system";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
