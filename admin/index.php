<?php
include 'config.php'; // Include your database connection

session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php'); // Redirect to login if the user is not logged in
    exit();
}

// Fetch counts for rooms, reservations, users, and unread feedback
$room_count = $conn->query("SELECT COUNT(*) FROM rooms")->fetch_row()[0];
$reservation_count = $conn->query("SELECT COUNT(*) FROM reservations")->fetch_row()[0];
$user_count = $conn->query("SELECT COUNT(*) FROM users")->fetch_row()[0];
$unread_feedback_query = "SELECT COUNT(*) AS unread_count FROM feedback WHERE status = 'unread'";
$unread_feedback_result = $conn->query($unread_feedback_query);
$unread_feedback_row = $unread_feedback_result->fetch_assoc();
$unread_feedback_count = $unread_feedback_row['unread_count'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Library Study Room System - Admin Panel</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
    <div class="sidebar-title">Library Study Room System</div>
    <a href="?page=dashboard" class="sidebar-item">
        <i class="fas fa-tachometer-alt"></i><span>Dashboard</span>
    </a>
    <a href="rooms.php" class="sidebar-item">
        <i class="fas fa-door-open"></i><span>Rooms</span><span class="badge"><?php echo $room_count; ?></span>
    </a>
    <a href="reservations.php" class="sidebar-item">
        <i class="fas fa-calendar-check"></i><span>Reservations</span><span class="badge"><?php echo $reservation_count; ?></span>
    </a>
    <a href="users.php" class="sidebar-item">
        <i class="fas fa-users"></i><span>Users</span><span class="badge"><?php echo $user_count; ?></span>
    </a>
    <a href="feedback.php" class="sidebar-item">
        <i class="fas fa-comments"></i>
        <span>Feedback</span>
        <span class="badge"><?php echo $unread_feedback_count > 0 ? $unread_feedback_count : '0'; ?></span>
    </a>
    <!-- Reports Link -->
    <a href="reports.php" class="sidebar-item">
        <i class="fas fa-chart-line"></i><span>Reports</span>
    </a>
    <!-- Logout Link -->
    <a href="logout.php" class="sidebar-item">
        <i class="fas fa-sign-out-alt"></i><span>Logout</span>
    </a>
</div>
<!-- Main Content -->
<div class="content">
    <?php
    $page = $_GET['page'] ?? 'dashboard';
    if ($page === 'dashboard') {
        echo "
        <div class='main-content'>
            <h1>Dashboard</h1>
            <div class='dashboard-wrapper'>
                <div class='dashboard-card'>
                    <h3>Rooms</h3>
                    <p>Total: $room_count</p>
                    <a href='rooms.php' class='btn'>View Rooms</a>
                </div>
                <div class='dashboard-card'>
                    <h3>Reservations</h3>
                    <p>Total: $reservation_count</p>
                    <a href='reservations.php' class='btn'>View Reservations</a>
                </div>
                <div class='dashboard-card'>
                    <h3>Users</h3>
                    <p>Total: $user_count</p>
                    <a href='users.php' class='btn'>View Users</a>
                </div>
                <div class='dashboard-card'>
                    <h3>Feedback</h3>
                    <p>Total Unread: $unread_feedback_count</p>
                    <a href='feedback.php' class='btn'>View Feedback</a>
                </div>
            </div>
        </div>";
    }
    ?>
</div>

</body>
</html>

