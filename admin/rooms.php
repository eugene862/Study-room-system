<?php
include('config.php'); // Include your database connection

// Fetch rooms from the database
$query = "SELECT * FROM rooms";
$result = $conn->query($query);

// Check for messages (e.g., success messages for CRUD operations)
$message = isset($_GET['message']) ? $_GET['message'] : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Rooms</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; }
        .container { width: 80%; margin: auto; padding: 20px; }
        .message { color: green; margin-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 10px; text-align: left; border: 1px solid #ddd; }
        th { background-color: #f2f2f2; }
        .btn { padding: 8px 12px; margin: 5px; text-decoration: none; border-radius: 5px; color: white; }
        .btn-add { background-color: #4CAF50;}
        .btn-edit { background-color: #2196F3; }
        .btn-delete { background-color: #f44336; }
        .btn-primary { background-color: black; margin-left: 500px; }
    </style>
</head>
<body>
    <h2>Manage Rooms</h2>
    <?php if ($message): ?>
        <p class="success"><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>
    <a href="add_room.php" class="btn btn-add">Add New Room</a>
    <a href="index.php" class="btn btn-primary">Back to Admin Panel</a>

    <table>
        <tr>
            <th>ID</th>
            <th>Room Name</th>
            <th>Capacity</th>
            <th>Availability Status</th>
            <th>Actions</th>
        </tr>
        <?php 
        $no = 1;
        while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $no; ?></td>
                <td><?php echo htmlspecialchars($row['room_name']); ?></td>
                <td><?php echo $row['capacity']; ?></td>
                <td><?php echo $row['availability_status']; ?></td>
                <td>
                    <a href="edit_room.php?id=<?php echo $row['id']; ?>" class="btn btn-edit">Edit</a>
                    <a href="delete_room.php?id=<?php echo $row['id']; ?>" class="btn btn-delete" onclick="return confirm('Are you sure you want to delete this room?')">Delete</a>
                </td>
            </tr>
        <?php 
          $no++ ;
    endwhile;
      
        ?>
    </table>
</body>
</html>
