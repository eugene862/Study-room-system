<?php
include('config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $room_name = $_POST['room_name'];
    $capacity = $_POST['capacity'];
    $availability_status = $_POST['availability_status'];

    $query = "INSERT INTO rooms (room_name, capacity, availability_status) VALUES ('$room_name', '$capacity', '$availability_status')";
    if ($conn->query($query)) {
        header("Location: rooms.php?message=Room added successfully");
        exit();
    } else {
        $error = "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Room</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f7f7f7;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 30px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        h2 {
            text-align: center;
            color: #333;
            font-size: 24px;
        }
        label {
            font-size: 16px;
            margin-bottom: 8px;
            display: block;
            color: #333;
        }
        input, select, button {
            font-size: 16px;
            padding: 12px;
            width: 100%;
            margin-bottom: 20px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        input[type="number"], input[type="text"] {
            width: 100%;
            box-sizing: border-box;
        }
        .btn-submit {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .btn-submit:hover {
            background-color: #45a049;
        }
        .btn-back {
            background-color: #999;
            color: white;
            text-decoration: none;
            text-align: center;
            padding: 12px;
            display: inline-block;
            border-radius: 5px;
            margin-top: 10px;
        }
        .btn-back:hover {
            background-color: #888;
        }
        .error {
            color: red;
            font-size: 14px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Add New Room</h2>
        <?php if (isset($error)): ?>
            <p class="error"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
        
        <form method="POST" action="add_room.php">
            <label for="room_name">Room Name:</label>
            <input type="text" id="room_name" name="room_name" required>

            <label for="capacity">Capacity:</label>
            <input type="number" id="capacity" name="capacity" required>

            <label for="availability_status">Availability Status:</label>
            <select name="availability_status" required>
                <option value="available">Available</option>
                <option value="booked">Booked</option>
            </select>

            <button type="submit" class="btn-submit">Add Room</button>
        </form>

        <a href="rooms.php" class="btn-back">Back to Rooms</a>
    </div>
</body>
</html>
