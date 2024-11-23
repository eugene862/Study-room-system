<?php
include('config.php');

$id = $_GET['id'];
$query = "DELETE FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header('Location: users.php?message=User deleted successfully');
} else {
    echo "Error: " . $conn->error;
}