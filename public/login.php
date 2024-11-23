<?php
session_start();
include '../admin/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];

    // Fetch user record from the database
    $stmt = $conn->prepare("SELECT id, name FROM users WHERE email = ? AND name = ?");
    $stmt->bind_param("ss", $email, $name);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Store user details in the session
        $_SESSION['loggedin'] = true;
        $_SESSION['user_id'] = $user['id']; // Store user ID
        $_SESSION['user_name'] = $user['name']; // Optionally store name

        // Redirect to reservation page
        header("Location: reservation.php");
        exit;
    } else {
        echo "<script>alert('Invalid credentials.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            display: flex;
            justify-content: space-between;
            width: 80%;
        }
        .form-container {
            background: #fff;
            color: #000;
            border-radius: 8px;
            width: 45%;
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
            background-color: #007bff;
            border: none;
            padding: 10px;
            width: 100%;
            border-radius: 4px;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .link {
            text-align: center;
            margin-top: 10px;
        }
        .link a {
            color: #007bff;
            text-decoration: none;
        }
        .link a:hover {
            text-decoration: underline;
        }
        .rules-container {
            width: 45%;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .rules-container h3 {
            font-weight: bold;
            margin-bottom: 20px;
        }
        .rules-container ul {
            list-style-type: disc;
            padding-left: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Left Side: Login Form -->
        <div class="form-container">
            <h2>Login</h2>
            <form method="post" action="">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Login</button>
                <div class="link">
                    <p>Don't have an account? <a href="signup.php">Signup</a></p>
                </div>
            </form>
        </div>

        <!-- Right Side: Rules -->
        <div class="rules-container">
            <h3>Library Rules</h3>
            <ul>
                <li>Reserve rooms in advance.</li>
                <li>Maximum reservation time: 2 hours per day.</li>
                <li>Maintain silence in study rooms.</li>
                <li>Keep your room clean and tidy.</li>
                <li>Report any issues to the admin immediately.</li>
            </ul>
        </div>
    </div>
</body>
</html>
