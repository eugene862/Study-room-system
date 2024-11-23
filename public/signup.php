<?php
session_start();
require '../admin/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];

    // Check if the email already exists
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Email already exists
        echo "<script>alert('This email is already registered. Please try another email or log in.');</script>";
    } else {
        // Insert new user into the database with 'ban' set to 'yes'
        $stmt = $conn->prepare("INSERT INTO users (name, email, ban) VALUES (?, ?, 'yes')");
        $stmt->bind_param("ss", $name, $email);

        if ($stmt->execute()) {
            // Update session and redirect to reservation page
            $_SESSION['loggedin'] = true;
            $_SESSION['user'] = $name;
            echo "<script>alert('Signup successful! Redirecting to reservation page...');</script>";
            echo "<script>window.location.href='reservation.php';</script>";
            exit;
        } else {
            echo "<script>alert('Signup failed. Please try again.');</script>";
        }
    }
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #6a0dad;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }
        .form-container {
            background: #fff;
            color: #000;
            border-radius: 8px;
            width: 400px;
            padding: 20px 30px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .form-container h2 {
            font-weight: bold;
            margin-bottom: 20px;
            text-align: center;
        }
        .form-group label {
            font-weight: bold;
        }
        .btn-primary {
            background-color: #6a0dad;
            border: none;
            padding: 10px;
            width: 100%;
            border-radius: 4px;
            color: #fff;
        }
        .btn-primary:hover {
            background-color: #500b73;
        }
        .link {
            text-align: center;
            margin-top: 10px;
        }
        .link a {
            color: #6a0dad;
            text-decoration: none;
        }
        .link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Signup</h2>
        <form method="post" action="">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Signup</button>
            <div class="link">
                <p>Already have an account? <a href="login.php">Login</a></p>
            </div>
        </form>
    </div>
</body>
</html>
