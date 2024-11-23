<?php
include('config.php');
$message = '';

// Get reservation ID from URL parameter
$reservation_id = $_GET['id'] ?? null;

if (!$reservation_id) {
    echo "No reservation ID specified.";
    exit;
}

// Fetch the existing reservation details
$sql = "SELECT * FROM reservations WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $reservation_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Reservation not found.";
    exit;
}

$reservation = $result->fetch_assoc();

// Update the reservation if the form is submitted
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
        $check_sql = "SELECT * FROM reservations WHERE room_id = ? AND reservation_date = ? AND id != ? AND (
            (start_time < ? AND end_time > ?) OR
            (start_time < ? AND end_time > ?) OR
            (start_time >= ? AND end_time <= ?)
        )";
        $stmt = $conn->prepare($check_sql);
        $stmt->bind_param("isssssssi", $room_id, $reservation_date, $reservation_id, $end_time, $start_time, $end_time, $start_time, $start_time, $end_time);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $message = "The room is already booked for the selected time slot.";
        } else {
            // Update the reservation if no conflicts are found
            $update_sql = "UPDATE reservations SET user_id = ?, room_id = ?, reservation_date = ?, start_time = ?, end_time = ? WHERE id = ?";
            $stmt = $conn->prepare($update_sql);
            $stmt->bind_param("iisssi", $user_id, $room_id, $reservation_date, $start_time, $end_time, $reservation_id);

            if ($stmt->execute()) {
                header("Location: reservations.php?message=Reservation updated successfully!");
                exit;
            } else {
                $message = "Failed to update reservation. Please try again.";
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
    <title>Edit Reservation</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; }
        .container { max-width: 600px; margin: 50px auto; padding: 30px; background-color: #fff; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); }
        h2 { text-align: center; color: #333; }
        label { display: block; margin-top: 15px; color: #555; font-weight: bold; }
        input, select, button { width: 100%; padding: 12px; margin-top: 5px; border-radius: 4px; border: 1px solid #ddd; }
        .btn-submit { background-color: #4CAF50; color: white; border: none; cursor: pointer; margin-top: 20px; }
        .btn-back { background-color: #555; color: white; text-decoration: none; padding: 12px; display: inline-block; margin-top: 10px; text-align: center; width: 100%; }
        .success-message { color: green; font-weight: bold; text-align: center; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Edit Reservation</h2>
        
        <?php if ($message): ?>
            <p class="success-message"><?php echo htmlspecialchars($message); ?></p>
        <?php endif; ?>
        
        <form method="POST" action="edit_reservation.php?id=<?php echo $reservation_id; ?>">
            <label for="user_id">User</label>
            <select id="user_id" name="user_id" required>
                <option value="">Select User</option>
                <?php
                $users = $conn->query("SELECT id, name FROM users");
                while ($user = $users->fetch_assoc()) {
                    $selected = ($user['id'] == $reservation['user_id']) ? 'selected' : '';
                    echo "<option value='" . $user['id'] . "' $selected>" . htmlspecialchars($user['name']) . "</option>";
                }
                ?>
            </select>

            <label for="room_id">Room</label>
            <select id="room_id" name="room_id" required>
                <option value="">Select Room</option>
                <?php
                $rooms = $conn->query("SELECT id, room_name FROM rooms WHERE availability_status = 'available'");
                while ($room = $rooms->fetch_assoc()) {
                    $selected = ($room['id'] == $reservation['room_id']) ? 'selected' : '';
                    echo "<option value='" . $room['id'] . "' $selected>" . htmlspecialchars($room['room_name']) . "</option>";
                }
                ?>
            </select>

            <label for="reservation_date">Reservation Date</label>
            <input type="date" id="reservation_date" name="reservation_date" value="<?php echo $reservation['reservation_date']; ?>" required min="<?php echo date('Y-m-d'); ?>">

            <label for="start_time">Start Time</label>
            <input type="time" id="start_time" name="start_time" value="<?php echo $reservation['start_time']; ?>" min="08:00" max="18:00" required>

            <label for="end_time">End Time</label>
            <input type="time" id="end_time" name="end_time" value="<?php echo $reservation['end_time']; ?>" min="08:00" max="18:00" required>

            <button type="submit" class="btn-submit">Update Reservation</button>
            <a href="reservations.php" class="btn-back">Back to Reservations</a>
        </form>
    </div>
</body>
</html>
