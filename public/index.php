<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Study Room Reservation System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background-color: white; 
            color: black; 
        }
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #333;
            color: white;
            padding: 1em;
        }
        .navbar ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
            display: flex;
            gap: 1em;
        }
        .navbar ul li a {
            color: white;
            text-decoration: none;
        }
        .hero-section {
            position: relative;
            text-align: center;
            color: white;
        }
        .hero-image {
            width: 100%;
            height: 300px;
            object-fit: cover;
        }
        .hero-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: rgba(0, 0, 0, 0.6);
            padding: 1em 2em;
            border-radius: 5px;
            text-align: center;
        }
        .hero-text h1 {
            font-size: 2em;
            margin: 0;
        }
        .hero-text p {
            margin: 0.5em 0 0;
            font-size: 1.2em;
        }
        .main-section {
            display: flex;
            justify-content: space-between;
            gap: 0; /* Eliminate space between action boxes */
            flex-wrap: wrap;
            margin-top: 0; /* Ensure the main section is attached to the hero section */
        }
        .action-box {
            flex: 0 1 48%;
            max-height: 350px;
            text-align: center;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 5px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            position: relative;
            cursor: pointer;
        }
        .action-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .action-box .text-overlay {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            font-size: 1.5em;
            text-align: center;
            background-color: rgba(0, 0, 0, 0.6);
            padding: 1em;
            border-radius: 5px;
        }
        .action-box button {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #333;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
        }
        .action-box button:hover {
            background-color: #555;
        }
        footer {
            background-color: #333;
            text-align: center;
            padding: 1em 0;
            margin-top: auto;
        }
        footer h3, footer p {
            color: white;
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar">
        <h2>Library Study Room Reservation System</h2>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="about.php">About Us</a></li>
            <li><a href="contacts.php">Contacts</a></li>
            <li><a href="../admin/login.php">Admin</a></li>
        </ul>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <img src="../images/home.jpg" alt="Library Hero Image" class="hero-image">
        <div class="hero-text">
            <h1>Library Study Room Reservation System</h1>
            <p>Welcome to Technical Kenya University study room where we offer a very user-friendly interface to reserve rooms and give your honest feedback. Hope you enjoy.</p>
        </div>
    </section>

    <!-- Main Section -->
    <section class="main-section">
        <!-- Reservation Section -->
        <a href="login.php" class="action-box">
            <img src="../images/reservation.jpg" alt="Reserve a Room">
            <div class="text-overlay">
                <h2>Do you want to reserve a room?</h2>
                <button>Reserve Now</button>
            </div>
        </a>

        <!-- Feedback Section -->
        <a href="feedback.php" class="action-box">
            <img src="../images/feedback.jpg" alt="Give Feedback">
            <div class="text-overlay">
                <h2>Give us your feedback</h2>
                <button>Submit Feedback</button>
            </div>
        </a>
    </section>

    <!-- Footer -->
    <footer>
        <h3>Contact Details</h3>
        <p>Phone: 0748449956</p>
        <p>Email: eujobobo@gmail.com</p>
    </footer>
</body>
</html>
