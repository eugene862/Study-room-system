<?php
include('config.php'); // Make sure this file includes your database connection

// Check if an ID is provided in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Prepare the delete query for the reservations table
    $query = "DELETE FROM reservations WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);

    // Execute the delete statement
    if ($stmt->execute()) {
        // Redirect to reservations page with a success message
        header('Location: reservations.php?message=Reservation deleted successfully');
        exit();
    } else {
        // Display an error message if deletion fails
        echo "Error: " . $conn->error;
    }

    // Close the statement
    $stmt->close();
} else {
    // If no ID is provided, display an error message
    echo "Invalid request. No reservation ID provided.";
}

// Close the database connection
$conn->close();
?>
