<!DOCTYPE html>
<?php
session_start();
$loggedIn = isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true;
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - AutoCarMatch</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <style>
        .navbar {
            background-color: #000;
            height: 80px;
            padding: 0.5rem;
        }
        .navbar-brand {
            font-weight: 500;
            color: #fff;
            font-size: 35px;
            transition: 0.3s color;
        }
        .login-button {
            background-color: #fff;
            color: #000;
            font-size: 17px;
            padding: 8px 20px;
            border-radius: 50px;
            text-decoration: none;
            transition: 0.3s background-color;
        }
        .login-button:hover {
            background-color: #ccc;
        }
        .navbar-toggler {
            border: none;
            font-size: 1.25rem;
        }
        .navbar-toggler:focus, .btn-close:focus {
            box-shadow: none;
            outline: none;
        }
        .nav-link {
            color: #fff;
            font-weight: 700;
            position: relative;
        }
        .navbar-nav .nav-link.active, .navbar-nav .nav-link.show {
            color: #fff;
        }
        .nav-link:hover, .nav-link.active {
            color: #fff;
        }
        .offcanvas-end {
            background-color: #000; /* Set the background color to black */
        }
        .offcanvas-title {
            color: #fff;
        }
        @media (min-width: 991px) {
            .nav-link::before {
                content: "";
                position: absolute;
                bottom: 0;
                left: 50%;
                transform: translateX(-50%);
                width: 0;
                height: 2px;
                background-color: #fff;
                visibility: hidden;
                transition: 0.3s ease-in-out;
            }
            .nav-link:hover::before, .nav-link.active::before {
                width: 100%;
                visibility: visible;
            }
        }
        .hero-section {
            background: url('lambo.jpg') no-repeat center;
            background-size: cover;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            text-align: center;
        }
        .hero-content {
            max-width: 600px;
            color: #fff;
            background-color: rgba(0, 0, 0, 0.6); /* Slightly transparent black background */
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.5); /* Shadow for depth */
        }
        .register-button {
            background-color: #fff;
            color: #000;
            font-size: 17px;
            padding: 8px 20px;
            border-radius: 50px;
            text-decoration: none;
            transition: 0.3s background-color;
        }
        .about-us-section {
            background: url('aboutusbackground.jpg') no-repeat center;
            background-size: cover;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            text-align: center;
            padding-top: 100px; /* Add padding to prevent the header from blocking the top part */
        }
        .about-us-container {
            max-width: 1000px;
            color: #fff;
            background-color: rgba(0, 0, 0, 0.6); /* Slightly transparent black background */
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.5); /* Shadow for depth */
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand me-auto" href="homepage.php"><img src="./pngwing.com.png" alt="Proton Logo" style="height: 60px;"></a>
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Menu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav justify-content-center flex-grow-1 pe-3">
                        <li class="nav-item">
                            <a class="nav-link" href="homepage.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="aboutus.php">About Us</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="cars.php">Cars Available</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="CarService.php">Car Services / Checkup</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="appointments.php">My Appointments</a>
                        </li>
                    </ul>
                </div>
            </div>
            <?php if ($loggedIn): ?>
                <span class="navbar-text text-white me-3">Welcome, <?php echo htmlspecialchars($_SESSION['full_name']); ?>!</span>
                <a href="logout.php" class="login-button">Logout</a>
            <?php else: ?>
                <a href="login.html" class="login-button">Login</a>
            <?php endif; ?>
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>
    <!-- End Navbar -->

    <!-- About Us Section -->
    <section class="about-us-section d-flex align-items-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10 col-md-12">
                    <div class="about-us-container">
                        <h2 class="text-center mb-4">About Us</h2>
                        <p class="lead">AutoCarMatch is dedicated to revolutionizing the way people buy cars. Our platform empowers users to make informed decisions by providing transparent, comprehensive information about every vehicle in our inventory.</p>
                        <p>Founded in 2011, AutoCarMatch has quickly emerged as a leader in the automotive industry. Our team consists of passionate car enthusiasts and industry experts who are committed to simplifying the car buying process for our customers.</p>
                        <p>Join the AutoCarMatch community today and experience the future of car buying. Your dream car is just a few clicks away!</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End About Us Section -->

</body>
</html>
