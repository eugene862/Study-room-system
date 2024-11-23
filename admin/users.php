<?php
include('config.php'); // Include your database connection file

// Fetch all users from the database
$query = "SELECT * FROM users";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Users</title>
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
        .btn-primary{background-color: black; margin-left: 600px;}
    </style>
</head>
<body>
    <div class="container">
        <h2>USERS TABLE</h2>

        <a href="add_user.php" class="btn btn-add">Add New User</a>
        <a href="index.php" class="btn btn-primary">Back to Admin Panel</a>
        

        <?php if (isset($_GET['message'])) echo "<p class='message'>{$_GET['message']}</p>"; ?>

        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Ban Status</th>
                <th>Actions</th>
            </tr>
            <?php
            $no = 1;
            while ($user = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $user['id']; ?></td>
                    <td><?php echo $user['name']; ?></td>
                    <td><?php echo $user['email']; ?></td>
                    <td><?php echo $user['ban']; ?></td>
                    <td>
                        <a href="edit_user.php?id=<?php echo $user['id']; ?>" class="btn btn-edit">Edit</a>
                        <a href="delete_user.php?id=<?php echo $user['id']; ?>" class="btn btn-delete" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
            <?php 
        $no++;
        } ?>
        </table>
    </div>
</body>
</html>
