<?php
include 'config.php'; // Include your database connection

// Fetch total reservations for each report
$report_type = isset($_GET['report']) ? $_GET['report'] : '';

function getPeakTimesFrequency($conn) {
    // Fetch peak time frequency (assume times are stored in 1-hour intervals)
    $query = "
        SELECT HOUR(start_time) AS hour, COUNT(id) AS reservation_count
        FROM reservations
        GROUP BY HOUR(start_time)";
    $result = $conn->query($query);

    $total_query = "SELECT COUNT(*) AS total FROM reservations";
    $total_result = $conn->query($total_query);
    $total_row = $total_result->fetch_assoc();
    $total_reservations = $total_row['total'];

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $hour = $row['hour'];
        $percentage = $total_reservations > 0 ? ($row['reservation_count'] / $total_reservations) * 100 : 0;
        $data[] = ['hour' => $hour, 'count' => $row['reservation_count'], 'percentage' => $percentage];
    }
    return $data;
}

function getRoomFrequency($conn) {
    $query = "
        SELECT rm.id AS room_id, rm.room_name, COUNT(r.id) AS reservation_count
        FROM rooms rm
        LEFT JOIN reservations r ON rm.id = r.room_id
        GROUP BY rm.id, rm.room_name";
    $result = $conn->query($query);

    $total_query = "SELECT COUNT(*) AS total FROM reservations";
    $total_result = $conn->query($total_query);
    $total_row = $total_result->fetch_assoc();
    $total_reservations = $total_row['total'];

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $percentage = $total_reservations > 0 ? ($row['reservation_count'] / $total_reservations) * 100 : 0;
        $data[] = ['room_name' => $row['room_name'], 'count' => $row['reservation_count'], 'percentage' => $percentage];
    }
    return $data;
}

// Determine which report to show
if ($report_type === 'peak-times') {
    $report_data = getPeakTimesFrequency($conn);
} elseif ($report_type === 'rooms') {
    $report_data = getRoomFrequency($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reports Dashboard</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
        }
        .content {
            margin: 20px auto;
            width: 80%;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        h1, h2 {
            text-align: center;
            color: #333;
        }
        .back-button {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }
        .buttons {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin: 20px 0;
        }
        .button {
            background-color: #007BFF;
            color: #fff;
            padding: 10px 20px;
            text-align: center;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            text-decoration: none;
        }
        .button:hover {
            background-color: #0056b3;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table th, table td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }
        table th {
            background-color: #007BFF;
            color: #fff;
        }
        table tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        table tr:hover {
            background-color: #f1f1f1;
        }
    </style>
</head>
<body>

<div class="content">
    <h1>Reports Dashboard</h1>

    <!-- Back to Admin Panel Button -->
    <div class="back-button">
    <a href="index.php" class="btn btn-primary">Back to Admin Panel</a>
    </div>

    <!-- Report Type Buttons -->
    <div class="buttons">
        <a href="reports.php?report=peak-times" class="button">Peak Times</a>
        <a href="reports.php?report=rooms" class="button">Rooms Frequency</a>
    </div>

    <!-- Reports -->
    <?php if ($report_type === 'peak-times' && !empty($report_data)): ?>
        <h2>Peak Times Frequency</h2>
        <table>
            <thead>
                <tr>
                    <th>Hour</th>
                    <th>Reservation Count</th>
                    <th>Percentage</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($report_data as $row): ?>
                    <tr>
                        <td><?php echo $row['hour'] . ':00 - ' . ($row['hour'] + 1) . ':00'; ?></td>
                        <td><?php echo $row['count']; ?></td>
                        <td><?php echo number_format($row['percentage'], 2); ?>%</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php elseif ($report_type === 'rooms' && !empty($report_data)): ?>
        <h2>Room Reservation Frequency</h2>
        <table>
            <thead>
                <tr>
                    <th>Room Name</th>
                    <th>Reservation Count</th>
                    <th>Percentage</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($report_data as $row): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['room_name']); ?></td>
                        <td><?php echo $row['count']; ?></td>
                        <td><?php echo number_format($row['percentage'], 2); ?>%</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Please select a report to view the data.</p>
    <?php endif; ?>
</div>

</body>
</html>
