<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Library Room Reservation System</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: black; /* Changed to black */
            color: white; /* Ensure text is visible on the black background */
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
        .contact-container {
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
        .contact-container h1 {
            font-size: 2.5em;
            margin-bottom: 20px;
        }
        .contact-container p {
            font-size: 1.2em;
            line-height: 1.6;
            margin-bottom: 20px;
        }
        .contact-info {
            margin-top: 20px;
        }
        .contact-info p {
            font-size: 1.2em;
            margin: 10px 0;
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
            <li><a href="contact.php">Contacts</a></li>
            <li><a href="../admin/login.php">Admin</a></li>
        </ul>
    </nav>

    <!-- Contact Section -->
    <div class="contact-container">
        <h1>Contact Us</h1>
        <p>If you have any questions, feedback, or issues, feel free to reach out to us using the information below. We're here to assist you!</p>

        <!-- Contact Information -->
        <div class="contact-info">
            <p><strong>Email:</strong> boboeujo@gmail.com</p>
            <p><strong>Phone:</strong> 0748449956</p>
            
        </div>
    </div>
</body>
</html>
