<?php
// Include the database configuration file
include('../admin/config.php');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data
    $roomId = $_POST['room_id'];      // Selected room ID
    $userId = 1;                      // Assuming the user is logged in, replace with actual user ID
    $date = $_POST['date'];           // Selected date
    $startTime = $_POST['start_time']; // Start time selected by the user
    $duration = (int)$_POST['duration']; // Duration selected by the user (1 or 2 hours)

    // Ensure the date is in the correct format (YYYY-MM-DD)
    $reservationDate = date("Y-m-d", strtotime($date)); // Convert the date to 'YYYY-MM-DD'

    // Calculate the end time based on the duration
    $endTime = date("H:i", strtotime($startTime) + ($duration * 3600)); // Add duration to start time

    // Prepare the SQL query to insert the reservation into the database
    $query = "INSERT INTO reservations (user_id, room_id, reservation_date, start_time, end_time)
              VALUES (?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iisss", $userId, $roomId, $reservationDate, $startTime, $endTime);
    
    // Execute the query and check if the reservation is successfully added
    if ($stmt->execute()) {
        // Redirect back to the reservation page with a success message
        header("Location: index.php?date=" . $reservationDate . "&message=Reservation successful.");
        exit();
    } else {
        // Show an error message if the query fails
        echo "Error: " . $conn->error;
    }
}
?>
