<?php
include('config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $ban = $_POST['ban'];

    $query = "INSERT INTO users (name, email, ban) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sss", $name, $email, $ban);

    if ($stmt->execute()) {
        header('Location: users.php?message=User added successfully');
    } else {
        echo "Error: " . $conn->error;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add New User</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; display: flex; justify-content: center; align-items: center; height: 100vh; }
        .container { width: 400px; padding: 20px; background-color: #fff; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); border-radius: 8px; }
        label { display: block; margin-top: 10px; }
        input, select { width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ddd; border-radius: 5px; }
        .btn { width: 100%; padding: 10px; background-color: #4CAF50; border: none; color: white; font-size: 16px; border-radius: 5px; cursor: pointer; margin-top: 15px; }
        .btn:hover { background-color: #45a049; }
        .back-link { display: block; text-align: center; margin-top: 10px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Add New User</h2>
        <form method="POST">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="ban">Ban Status:</label>
            <select id="ban" name="ban">
                <option value="no">No</option>
                <option value="yes">Yes</option>
            </select>

            <button type="submit" class="btn">Add User</button>
        </form>
        <a href="users.php" class="back-link">Back to User Management</a>
    </div>
</body>
</html>
