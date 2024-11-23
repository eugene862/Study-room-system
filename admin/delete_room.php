<?php
include('config.php');

$id = $_GET['id'];
$query = "DELETE FROM rooms WHERE id = $id";
if ($conn->query($query)) {
    header("Location: rooms.php?message=Room deleted successfully");
    exit();
} else {
    echo "Error: " . $conn->error;
}
?>
