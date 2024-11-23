<?php
include('config.php');

// Optional date filter setup (using prepared statements for security)
$filter_date = isset($_GET['filter_date']) ? $_GET['filter_date'] : '';

// Prepare the base query with optional date filtering and sorting by date
$query = "SELECT reservations.id, users.name AS user_name, rooms.room_name, 
                 reservations.reservation_date, 
                 DATE_FORMAT(reservations.start_time, '%h:%i %p') AS start_time, 
                 DATE_FORMAT(reservations.end_time, '%h:%i %p') AS end_time, 
                 TIMESTAMPDIFF(HOUR, reservations.start_time, reservations.end_time) AS duration
          FROM reservations
          JOIN users ON reservations.user_id = users.id
          JOIN rooms ON reservations.room_id = rooms.id";

// Add date filter if it exists
if (!empty($filter_date)) {
    $query .= " WHERE reservations.reservation_date = ?";
}

// Sort by reservation_date and start_time (ascending order)
$query .= " ORDER BY reservations.reservation_date ASC, reservations.start_time ASC";

// Prepare and execute the query
$stmt = $conn->prepare($query);

// Bind parameter if there's a date filter
if (!empty($filter_date)) {
    $stmt->bind_param("s", $filter_date); // 's' for string (date format)
}

// Execute the query
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Reservations</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; }
        .container { width: 80%; margin: auto; padding: 20px; }
        .message { color: green; margin-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 10px; text-align: left; border: 1px solid #ddd; }
        th { background-color: #f2f2f2; }
        .btn { padding: 8px 12px; margin: 5px; text-decoration: none; border-radius: 5px; color: white; }
        .btn-add { background-color: #4CAF50; }
        .btn-edit { background-color: #2196F3; }
        .btn-delete { background-color: #f44336; }
        .btn-primary { background-color: black; margin-left: 500px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Reservations</h2>
        <a href="add_reservation.php" class="btn btn-add">Add New Reservation</a>
        <a href="index.php" class="btn btn-primary">Back to Admin Panel</a>

        <?php if (isset($_GET['message'])): ?>
            <p class="message"><?php echo htmlspecialchars($_GET['message']); ?></p>
        <?php endif; ?>

        <!-- Date Filter -->
        <form method="get" action="">
            <label for="filter_date">Filter by Date:</label>
            <input type="date" id="filter_date" name="filter_date" value="<?php echo htmlspecialchars($filter_date); ?>">
            <button type="submit" class="btn btn-primary">Filter</button>
        </form>

        <!-- Reservations Table -->
        <table class="table">
            <tr>
                <th>ID</th>
                <th>User Name</th>
                <th>Room Name</th>
                <th>Reservation Date</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th>Duration (hours)</th>
                <th>Actions</th>
            </tr>
            <?php 
            $no = 1;
            while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $no; ?></td>
                    <td><?php echo htmlspecialchars($row['user_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['room_name']); ?></td>
                    <!-- Check if the reservation_date is valid -->
                    <td>
                        <?php
                        $reservation_date = $row['reservation_date'];
                        // Check if the date is valid (not 0001-11-30)
                        if ($reservation_date !== '0001-11-30') {
                            echo htmlspecialchars(date('m-d-Y', strtotime($reservation_date)));
                        } else {
                            echo "Invalid Date"; // Handle invalid date format
                        }
                        ?>
                    </td>
                    <td><?php echo htmlspecialchars($row['start_time']); ?></td>
                    <td><?php echo htmlspecialchars($row['end_time']); ?></td>
                    <td><?php echo htmlspecialchars($row['duration']); ?></td>
                    <td>
                        <a href="edit_reservation.php?id=<?php echo htmlspecialchars($row['id']); ?>" class="btn btn-edit">Edit</a>
                        <a href="delete_reservation.php?id=<?php echo htmlspecialchars($row['id']); ?>" class="btn btn-delete" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
            <?php 
        $no++ ;
        endwhile; ?>
        </table>
    </div>
</body>
</html>                     