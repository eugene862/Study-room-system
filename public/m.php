<?php
// Include database configuration
include('../admin/config.php');

// Fetch the date from the user input (or default to today)
$date = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');

// Fetch room availability from 8 AM to 6 PM
$startHour = 8;
$endHour = 18;

// Initialize the availability array
$availability = [];

// Fetch reservations for the selected date and future dates
$query = "SELECT room_id, start_time, end_time FROM reservations WHERE DATE(start_time) >= ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $date);
$stmt->execute();
$result = $stmt->get_result();

// Populate the availability array with booked hours for each room
while ($row = $result->fetch_assoc()) {
    $roomId = $row['room_id'];
    $startTime = (int)date('H', strtotime($row['start_time']));
    $endTime = (int)date('H', strtotime($row['end_time']));
    
    // Mark the reserved hours as unavailable
    for ($hour = $startTime; $hour < $endTime; $hour++) {
        $availability[$roomId][$hour] = true;  // true means booked
    }
}

// Function to check if a room is available for a specific hour
function isRoomAvailable($room, $hour, $availability) {
    return isset($availability[$room][$hour]) ? 'Booked' : 'Available';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Room Reservation System</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* General Styles */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }
        nav {
            background-color: black;
            color: white;
            padding: 15px;
            text-align: center;
        }
        nav ul {
            list-style: none;
            margin: 0;
            padding: 0;
        }
        nav ul li {
            display: inline;
            margin-right: 20px;
        }
        nav ul li a {
            color: white;
            text-decoration: none;
            font-weight: bold;
        }

        /* Main Container */
        .main-container {
            display: flex;
            justify-content: space-between;
            padding: 20px;
            background: black;
        }

        /* Date Filter Section */
        .date-filter {
            flex: 1;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background: rgb(34,193,195);
            background: linear-gradient(0deg, rgba(34,193,195,1) 0%, rgba(63,71,67,1) 100%);
        }
        .date-filter h2 {
            margin-bottom: 15px;
            color: white;
        }
        .date-filter form {
            display: flex;
            flex-direction: column;
        }
        .date-filter label {
            margin-bottom: 8px;
            color: white;
        }
        .date-filter input[type="date"] {
            padding: 10px;
            font-size: 14px;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-bottom: 10px;
        }
        .date-filter button {
            background-color: black;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }
        .date-filter button:hover {
            background-color: white;
            color: black;
        }

        /* Reservation Form Section */
        .reservation-form {
            flex: 1;
            background-color: blue;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background: rgb(34,193,195);
            background: linear-gradient(0deg, rgba(34,193,195,1) 0%, rgba(63,71,67,1) 100%);
        }
        .reservation-form h2 {
            margin-bottom: 20px;
            color: white;
        }
        .reservation-form form {
            display: flex;
            flex-direction: column;
        }
        .reservation-form label {
            color: white;
            margin-bottom: 8px;
        }
        .reservation-form select,
        .reservation-form input[type="date"],
        .reservation-form input[type="time"] {
            padding: 10px;
            font-size: 14px;
            border: 1px solid yellow;
            border-radius: 4px;
            margin-bottom: 15px;
        }
        .reservation-form button {
            background-color: black;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .reservation-form button:hover {
            background-color: blue;
        }

        /* Availability Section */
        .availability {
            flex: 2;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background: rgb(34,193,195);
            background: linear-gradient(0deg, rgba(34,193,195,1) 0%, rgba(63,71,67,1) 100%);
        }
        .availability h2 {
            color: white;
            margin-bottom: 20px;
        }
        .availability table {
            width: 100%;
            border-collapse: collapse;
        }
        .availability table th,
        .availability table td {
            padding: 12px;
            text-align: center;
        }
        .availability table th {
            background-color: black;
            color: white;
        }
        .availability table td {
            background-color: #f9f9f9;
            font-weight: bold;
        }
        .availability table td[data-status="Booked"] {
            background-color: red;
            color: white;
        }
        .availability table td[data-status="Available"] {
            background-color: green;
            color: white;
        }

        /* Success Message */
        .success-message {
            color: green;
            font-weight: bold;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <nav>
        <h1>Library Room Reservation System</h1>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="about.php">About Us</a></li>
            <li><a href="contact.php">Contacts</a></li>
            <li><a href="admin.php">Admin</a></li>
        </ul>
    </nav>

    <!-- Main Container -->
    <div class="main-container">
        <!-- Date Filter -->
        <section class="date-filter">
            <h2>Select Date for Room Availability</h2>
            <form method="GET" action="">
                <label for="date">Choose Date:</label>
                <input type="date" name="date" value="<?php echo $date; ?>" min="<?php echo date('Y-m-d'); ?>" required>
                <button type="submit">Check Availability</button>
            </form>
        </section>

        <!-- Reservation Form -->
        <section class="reservation-form">
            <h2>Reserve a Room</h2>
            <?php if (isset($_GET['message'])): ?>
                <p class="success-message"><?php echo $_GET['message']; ?></p>
            <?php endif; ?>

            <form action="submit_reservation.php" method="POST">
                <label for="room_id">Room:</label>
                <select name="room_id" required>
                    <?php for ($room = 1; $room <= 10; $room++): ?>
                        <option value="<?php echo $room; ?>">Room <?php echo $room; ?></option>
                    <?php endfor; ?>
                </select>

                <label for="date">Date:</label>
                <input type="date" name="date" value="<?php echo $date; ?>" required>

                <label for="start_time">Start Time:</label>
                <input type="time" name="start_time" min="08:00" max="18:00" required>

                <label for="duration">Duration (1 or 2 hours):</label>
                <select name="duration" required>
                    <option value="1">1 hour</option>
                    <option value="2">2 hours</option>
                </select>

                <button type="submit">Submit Reservation</button>
            </form>
        </section>

        <!-- Availability -->
        <section class="availability">
            <h2>Room Availability for <?php echo $date; ?></h2>
            <table>
                <thead>
                    <tr>
                        <th>Room</th>
                        <?php for ($hour = $startHour; $hour < $endHour; $hour++): ?>
                            <th><?php echo $hour; ?>:00</th>
                        <?php endfor; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php for ($room = 1; $room <= 10; $room++): ?>
                        <tr>
                            <td>Room <?php echo $room; ?></td>
                            <?php for ($hour = $startHour; $hour < $endHour; $hour++): ?>
                                <td data-status="<?php echo isRoomAvailable($room, $hour, $availability); ?>">
                                    <?php echo isRoomAvailable($room, $hour, $availability); ?>
                                </td>
                            <?php endfor; ?>
                        </tr>
                    <?php endfor; ?>
                </tbody>
            </table>
        </section>
    </div>
</body>
</html>
