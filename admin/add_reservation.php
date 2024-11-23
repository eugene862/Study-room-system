<?php
include('config.php');
$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST['user_id'];
    $room_id = $_POST['room_id'];
    $reservation_date = date('Y-m-d', strtotime($_POST['reservation_date']));
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];

    // Convert to DateTime objects for easier comparison
    $start = new DateTime("$reservation_date $start_time");
    $end = new DateTime("$reservation_date $end_time");
    $max_end = clone $start;
    $max_end->modify('+2 hours');

    if ($end > $max_end) {
        $message = "Booking cannot exceed 2 hours.";
    } elseif ($start->format('H:i') < '08:00' || $end->format('H:i') > '18:00') {
        $message = "Booking must be between 8 am and 6 pm.";
    } else {
        // Check for conflicts
        $check_sql = "SELECT * FROM reservations WHERE room_id = ? AND reservation_date = ? AND (
            (start_time < ? AND end_time > ?) OR
            (start_time < ? AND end_time > ?) OR
            (start_time >= ? AND end_time <= ?)
        )";
        $stmt = $conn->prepare($check_sql);
        $stmt->bind_param("isssssss", $room_id, $reservation_date, $end_time, $start_time, $end_time, $start_time, $start_time, $end_time);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $message = "The room is already booked for the selected time slot.";
        } else {
            // Insert the reservation if no conflicts are found
            $sql = "INSERT INTO reservations (user_id, room_id, reservation_date, start_time, end_time) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iisss", $user_id, $room_id, $reservation_date, $start_time, $end_time);

            if ($stmt->execute()) {
                // Redirect to reservations page with a success message
                header("Location: reservations.php?message=Reservation added successfully!");
                exit;
            } else {
                $message = "Failed to add reservation. Please try again.";
            }
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Reservation</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; }
        .container { max-width: 600px; margin: 50px auto; padding: 30px; background-color: #fff; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); }
        h2 { text-align: center; color: #333; }
        label { display: block; margin-top: 15px; color: #555; font-weight: bold; }
        input, select, button { width: 100%; padding: 12px; margin-top: 5px; border-radius: 4px; border: 1px solid #ddd; }
        .btn-submit { background-color: #4CAF50; color: white; border: none; cursor: pointer; margin-top: 20px; }
        .btn-back { background-color: red; color: white; text-decoration: none; padding: 12px; display: inline-block; margin-top: 10px; text-align: center; width: 100%; }
        .success-message { color: green; font-weight: bold; text-align: center; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Add New Reservation</h2>
        
        <?php if ($message): ?>
            <p class="success-message"><?php echo htmlspecialchars($message); ?></p>
        <?php endif; ?>
        
        <form method="POST" action="add_reservation.php">
            <label for="user_id">User</label>
            <select id="user_id" name="user_id" required>
                <option value="">Select User</option>
                <?php
                $users = $conn->query("SELECT id, name FROM users");
                while ($user = $users->fetch_assoc()) {
                    echo "<option value='" . $user['id'] . "'>" . htmlspecialchars($user['name']) . "</option>";
                }
                ?>
            </select>

            <label for="room_id">Room</label>
            <select id="room_id" name="room_id" required>
                <option value="">Select Room</option>
                <?php
                $rooms = $conn->query("SELECT id, room_name FROM rooms WHERE availability_status = 'available'");
                while ($room = $rooms->fetch_assoc()) {
                    echo "<option value='" . $room['id'] . "'>" . htmlspecialchars($room['room_name']) . "</option>";
                }
                ?>
            </select>

            <label for="reservation_date">Reservation Date</label>
            <input type="date" id="reservation_date" name="reservation_date" required min="<?php echo date('Y-m-d'); ?>">

            <label for="start_time">Start Time</label>
            <input type="time" id="start_time" name="start_time" min="08:00" max="18:00" required>

            <label for="end_time">End Time</label>
            <input type="time" id="end_time" name="end_time" min="08:00" max="18:00" required>

            <button type="submit" class="btn-submit">Add Reservation</button>
            <a href="reservations.php" class="btn-back">Back to Reservations</a>
        </form>
    </div>
</body>
</html>
