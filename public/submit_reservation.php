<?php
// Include database configuration
include('../admin/config.php');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize form data
    $room_id = intval($_POST['room_id']);
    $reservation_date = $_POST['date'];
    $start_time = $_POST['start_time'];
    $duration = intval($_POST['duration']);
    
    // Assume the user ID is passed via session (after login)
    session_start();
    if (!isset($_SESSION['user_id'])) {
        // Redirect if the user is not logged in
        header("Location: login.php?message=Please log in first.");
        exit;
    }
    $user_id = $_SESSION['user_id'];

    // Calculate the end time based on the duration
    $end_time = date('H:i', strtotime($start_time) + $duration * 3600);

    // Validate reservation time
    if (strtotime($start_time) < strtotime('08:00') || strtotime($end_time) > strtotime('18:00')) {
        header("Location: index.php?message=Invalid time. Please select a time between 08:00 and 18:00.");
        exit;
    }

    // Check for conflicts with existing reservations
    $query = "SELECT * FROM reservations 
              WHERE room_id = ? 
              AND reservation_date = ? 
              AND (start_time < ? AND end_time > ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("isss", $room_id, $reservation_date, $end_time, $start_time);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Conflict detected
        header("Location: index.php?message=Room is already booked for the selected time.");
        exit;
    }

    // Insert the new reservation into the database
    $insertQuery = "INSERT INTO reservations (user_id, room_id, reservation_date, start_time, end_time) VALUES (?, ?, ?, ?, ?)";
    $insertStmt = $conn->prepare($insertQuery);
    $insertStmt->bind_param("iisss", $user_id, $room_id, $reservation_date, $start_time, $end_time);

    if ($insertStmt->execute()) {
        // Success message
        header("Location: reservation.php?message=Reservation successful.");
        exit;
    } else {
        // Error message
        header("Location: reservetion.php?message=Failed to make a reservation. Please try again.");
        exit;
    }
} else {
    // Redirect to the reservation page if accessed directly
    header("Location: reservation.php");
    exit;
}
?>
