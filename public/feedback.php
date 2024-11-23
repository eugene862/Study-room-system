<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback - Library Room Reservation System</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }
        nav {
            background-color: black;
            color: white;
            padding: 15px;
            text-align: center;
        }
        nav ul {
            list-style: none;
            margin: 0;
            padding: 0;
        }
        nav ul li {
            display: inline;
            margin-right: 20px;
        }
        nav ul li a {
            color: white;
            text-decoration: none;
            font-weight: bold;
        }
        .feedback-container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background: rgb(34,193,195);
            background: linear-gradient(0deg, rgba(34,193,195,1) 0%, rgba(63,71,67,1) 100%);
            color: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .feedback-container h1 {
            font-size: 2.5em;
            margin-bottom: 20px;
        }
        .feedback-container p {
            font-size: 1.2em;
            line-height: 1.6;
            margin-bottom: 20px;
        }
        .feedback-form {
            text-align: left;
            margin-top: 20px;
        }
        .feedback-form label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }
        .feedback-form input, .feedback-form textarea {
            width: 100%;
            padding: 10px;
            font-size: 1em;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .feedback-form button {
            background-color: black;
            color: white;
            padding: 10px 15px;
            font-size: 1em;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .feedback-form button:hover {
            background-color: white;
            color: black;
        }
        footer {
            background-color: black;
            color: white;
            text-align: center;
            padding: 10px 0;
            margin-top: 20px;
        }
        footer p {
            margin: 0;
            font-size: 0.9em;
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <nav>
        <h1>Library Room Reservation System</h1>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="about.php">About Us</a></li>
            <li><a href="feedback.php">Feedback</a></li>
            <li><a href="../admin/login.php">Admin</a></li>
        </ul>
    </nav>

    <!-- Feedback Section -->
    <div class="feedback-container">
        <h1>Share Your Feedback</h1>
        <p>We value your feedback and strive to improve our Library Room Reservation System. Please share your thoughts, suggestions, or any issues you've encountered using the form below.</p>

        <!-- Feedback Form -->
        <form class="feedback-form" action="submit_feedback.php" method="POST">
            <label for="name">Your Name:</label>
            <input type="text" id="name" name="name" placeholder="Enter your name" required>

            <label for="email">Your Email:</label>
            <input type="email" id="email" name="email" placeholder="Enter your email" required>

            <label for="message">Your Feedback:</label>
            <textarea id="message" name="message" rows="5" placeholder="Write your feedback here" required></textarea>

            <button type="submit">Submit Feedback</button>
        </form>
    </div>

    <!-- Footer -->
    <footer>
        <p>© 2024 Library Room Reservation System. All rights reserved.</p>
    </footer>
</body>
</html>
