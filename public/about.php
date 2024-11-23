<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - TUK Library Room Reservation System</title>
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
        .about-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            background: rgb(34,193,195);
            background: linear-gradient(0deg, rgba(34,193,195,1) 0%, rgba(63,71,67,1) 100%);
            color: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .about-container h1 {
            font-size: 2.5em;
            margin-bottom: 20px;
        }
        .about-container p {
            font-size: 1.2em;
            line-height: 1.6;
            margin-bottom: 20px;
        }
        .contact-info {
            font-size: 1em;
            margin-top: 20px;
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
            <li><a href="contact.php">Contacts</a></li>
            <li><a href="../admin/login.php">Admin</a></li>
        </ul>
    </nav>

    <!-- About Section -->
    <div class="about-container">
        <h1>About Us</h1>
        <p>Welcome to TUK Library Room Reservation System. This system is designed to provide an efficient and user-friendly environment for reserving study rooms in the library.</p>
        <p>With real-time availability updates and a seamless reservation process, we strive to enhance your learning experience and ensure that your time in the library is productive and enjoyable.</p>
        <p>Our goal is to support academic success and provide a smooth and hassle-free reservation system tailored to your needs.</p>
        
        <div class="contact-info">
            <h2>Contact Us</h2>
            <p>Email: boboeujo@gmail.com</p>
            <p>Phone: 0748449956</p>
            
        </div>
    </div>
<footer>
    <P> TRY US OUT</P>
</footer>
   
</body>
</html>
