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
    <title>AutoCarMatch</title>
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
        
        .offcanvas-end {
            background-color: #000; /* Set the background color to black */
        }
        
        .offcanvas-title {
            color: #fff
        }
        
        .hero-section {
            width: 100%;
            height: 100vh;
            background: url('lambo.jpg') no-repeat center;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .hero {
            width: 100%;
            height: 100vh;
            background: url(./homepagecar.jpg);
            background-position: center;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        
        .hero .text {
            width: 90%;
            margin: auto;
            text-align: center;
        }
        
        .hero .text h4 {
            font-size: 40px;
            color: #fff;
            font-weight: 500;
            margin-bottom: 10px;
        }
        
        .hero .text h1 {
            font-size: 50px;
            color: #fff;
            text-transform: uppercase;
            line-height: 1;
            margin-bottom: 20px;
        }
        
        .hero .text h1 span {
            color: #6c757d;
            font-size: 60px;
            font-weight: bold;
        }
        
        .hero .text p {
            color: #fff;
            margin-bottom: 20px;
        }

        .hero .text .btn {
            background-color: transparent;
            color: #fff;
            font-size: 17px;
            padding: 8px 20px;
            border-radius: 30px;
            text-transform: uppercase;
            transition: 0.3s;
            border: 2px solid #fff;
        }
        
        .hero .text .btn:hover {
            background-color: #000;
        }

        @media (max-width: 768px) {
            .hero .text h4 {
                font-size: 24px;
            }

            .hero .text h1 {
                font-size: 32px;
            }

            .hero .text h1 span {
                font-size: 40px;
            }

            .hero .text p {
                font-size: 16px;
            }
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
                            <a class="nav-link active" aria-current="page" href="homepage.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="aboutus.php">About Us</a>
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
    
    <!-- Hero Section -->
    <div class="hero">
        <div class="text">
            <h4>Powerful, Fun and</h4>
            <h1>Fierce to <br><span>Drive</span></h1>
            <p>Real Poise, Real Power, Real Performance</p>
            <a href="register.html" class="btn"> Register Now!</a>
        </div>
    </div>
    <!-- End Hero Section -->
    
</body>
</html>
