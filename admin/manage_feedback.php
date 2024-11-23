<?php
include('config.php');

// Handle the "mark as read" functionality
if (isset($_GET['mark_read'])) {
    $id = $_GET['mark_read'];
    
    // Update the feedback status to 'read'
    $stmt = $conn->prepare("UPDATE feedback SET status = 'read' WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "<p class='message success'>Feedback marked as read successfully.</p>";
    } else {
        echo "<p class='message error'>Error updating feedback: " . $conn->error . "</p>";
    }
    $stmt->close();
}

// Fetch all feedback from the database
$result = $conn->query("SELECT * FROM feedback ORDER BY created_at DESC");

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Manage User Feedback</title>
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 20px;
        background-color: #f7f7f7;
    }
    h2 {
        color: #333;
    }
    .feedback-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        background-color: #fff;
    }
    .feedback-table th, .feedback-table td {
        padding: 15px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }
    .feedback-table th {
        background-color: #4CAF50;
        color: white;
        text-transform: uppercase;
    }
    .feedback-table tr:nth-child(even) {
        background-color: #f2f2f2;
    }
    .feedback-table tr:hover {
        background-color: #e9f5e9;
    }
    .feedback-table td a {
        color: #4CAF50;
        text-decoration: none;
        font-weight: bold;
    }
    .feedback-table td a:hover {
        color: #388E3C;
    }
    .message {
        font-weight: bold;
        margin-bottom: 10px;
    }
    .message.success {
        color: green;
    }
    .message.error {
        color: red;
    }
    .mark-as-read-btn {
        background-color: #4CAF50;
        color: white;
        border: none;
        padding: 8px 12px;
        border-radius: 4px;
        cursor: pointer;
    }
    .mark-as-read-btn:hover {
        background-color: #388E3C;
    }
    .btn-primary {
        background-color: black;
        color: white;
        padding: 10px 15px;
        text-decoration: none;
        border-radius: 4px;
        margin-top: 20px;
        display: inline-block;
    }
    .btn-primary:hover {
        background-color: #444;
    }
</style>
</head>
<body>

<h2>Manage User Feedback</h2>

<?php
// Displaying feedback in a table
echo "<table class='feedback-table'>";
echo "<tr><th>User Name</th><th>Email</th><th>Message</th><th>Status</th><th>Actions</th></tr>";

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['user_name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
        echo "<td>" . htmlspecialchars($row['message']) . "</td>";
        echo "<td>" . ucfirst($row['status']) . "</td>";
        echo "<td>";
        
        // Show "Mark as Read" button if the feedback is unread
        if ($row['status'] == 'unread') {
            echo "<a href='manage_feedback.php?mark_read=" . $row['id'] . "'><button class='mark-as-read-btn'>Mark as Read</button></a>";
        } else {
            echo "Read";
        }

        echo "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='5'>No feedback found.</td></tr>";
}

echo "</table>";

$conn->close();
?>

<!-- Back button to return to previous page -->
<a href="index.php" class="btn-primary">Back to Admin</a>

</body>
</html>
