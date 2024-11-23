<?php
// Include database connection
include('config.php');

// Fetch user data based on ID
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM users WHERE id = $id";
    $result = $conn->query($query);

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        $name = $user['name'];
        $email = $user['email'];
        $ban = $user['ban'];
    } else {
        echo "User not found.";
        exit();
    }
}

// Update user data on form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $ban = $_POST['ban'];

    $updateQuery = "UPDATE users SET name = '$name', email = '$email', ban = '$ban' WHERE id = $id";
    if ($conn->query($updateQuery) === TRUE) {
        header("Location: users.php?message=User%20updated%20successfully");
        exit();
    } else {
        echo "Error updating user: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit User</title>
    <style>
        /* Form container styling */
        .form-container {
            width: 50%;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: #f9f9f9;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        /* Form field styling */
        .form-field {
            display: flex;
            flex-direction: column;
            margin-bottom: 20px;
        }
        label {
            font-weight: bold;
            margin-bottom: 5px;
        }
        input[type="text"], select {
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        /* Button styling */
        .btn {
            padding: 12px;
            font-size: 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .btn-submit {
            background-color: #28a745;
            color: white;
        }
        .btn-back {
            background-color: #007bff;
            color: white;
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Edit User</h2>
        <form action="" method="POST">
            <div class="form-field">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" required>
            </div>
            <div class="form-field">
                <label for="email">Email</label>
                <input type="text" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
            </div>
            <div class="form-field">
                <label for="ban">Ban Status</label>
                <select id="ban" name="ban">
                    <option value="no" <?php if ($ban == 'no') echo 'selected'; ?>>No</option>
                    <option value="yes" <?php if ($ban == 'yes') echo 'selected'; ?>>Yes</option>
                </select>
            </div>
            <div>
                <button type="button" class="btn btn-back" onclick="window.history.back();">Back</button>
                <button type="submit" class="btn btn-submit">Update User</button>
            </div>
        </form>
    </div>
</body>
</html>
