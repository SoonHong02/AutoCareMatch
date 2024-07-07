<?php
session_start();

// Initialize $loggedIn variable
$loggedIn = isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true;

// Check if user is logged in
if (!$loggedIn) {
    // User is not logged in, redirect to login page
    header('Location: login.html');
    exit;
}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AutoCarMatch - Car Service and Checkup</title>
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
            background: url(./carservicebackground.jpg) no-repeat center;
            background-size: cover;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }
        
        .hero .text {
            max-width: 500px;
            padding: 20px;
            background-color: rgba(0, 0, 0, 0.5);
            border-radius: 10px;
            color: #fff;
        }
        
        .hero .text h4 {
            font-size: 28px;
            font-weight: 500;
            margin-bottom: 10px;
        }
        
        .hero .text h1 {
            font-size: 42px;
            text-transform: uppercase;
            margin-bottom: 30px;
        }
        
        .hero .text h1 span {
            color: #6c757d;
            font-size: 50px;
            font-weight: bold;
        }
        
        .hero .text p {
            margin-bottom: 30px;
        }

        .hero .text .form-control {
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
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
        
        @media (max-width: 576px) { /* Extra small devices (phones) */
            .welcome-mobile {
                display: none; /* Hide welcome message on small devices */
            }
        }
        
    </style>
</head>
<body>
    <!-- Navbar -->
        <nav class="navbar navbar-expand-lg fixed-top">
            <div class="container">
                <a class="navbar-brand me-auto" href="homepage.php"><img src="./pngwing.com.png" alt="Proton Logo" style="height: 60px;"></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Menu</h5>
                        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body" style="background-color: #000;"> <!-- Set background color here -->
                        <ul class="navbar-nav justify-content-center flex-grow-1 pe-3">
                            <li class="nav-item">
                                <a class="nav-link" href="homepage.php">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="aboutus.php">About Us</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="cars.php">Cars Available</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="CarService.php">Car Services / Checkup</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="appointments.php">My Appointments</a>
                            </li><br>
                        </ul>
                        <a href="logout.php" class="login-button">Logout</a> <!-- Move logout link here -->
                    </div>
                </div>
                <span class="navbar-text text-white me-3">Welcome, <?php echo htmlspecialchars($_SESSION['full_name']); ?>!</span>
            </div>
        </nav>
        <!-- End Navbar -->
    
    <!-- Hero Section -->
    <div class="hero">
        <div class="text">
            <br><br><br>
            <h1>Book Your Car Service <span>Today</span></h1>
            <form action="submit_service_form.php" method="POST">
                <div class="mb-3">
                    <label for="carMakeModel" class="form-label">Car Make & Model</label>
                    <input type="text" class="form-control" id="carMakeModel" name="carMakeModel" required>
                </div>
                <div class="mb-3">
                    <label for="serviceType" class="form-label">Service Type</label>
                    <select class="form-control" id="serviceType" name="serviceType" required>
                        <option value="">Select Service Type</option>
                        <option value="OilChange">Oil Change</option>
                        <option value="Inspection">Inspection</option>
                        <option value="Maintenance">Maintenance</option>
                        <!-- Add more options as needed -->
                    </select>
                </div>
                <div class="mb-3">
                    <label for="serviceDate" class="form-label">Preferred Date & Time</label>
                    <input type="datetime-local" class="form-control" id="serviceDate" name="serviceDate" required>
                </div>
                <div class="mb-3">
                    <label for="notes" class="form-label">Additional Notes</label>
                    <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
                </div>
                <div class="form-check mb-3">
                    <input type="checkbox" class="form-check-input" id="agreeTerms" name="agreeTerms" required>
                    <label class="form-check-label" for="agreeTerms">I agree to the terms and conditions.</label>
                </div>
                <!-- Hidden fields for session details -->
                <input type="hidden" name="session_id" value="<?php echo htmlspecialchars(session_id()); ?>">
                <input type="hidden" name="user_id" value="<?php echo isset($_SESSION['user_id']) ? htmlspecialchars($_SESSION['user_id']) : ''; ?>">
                <input type="hidden" name="full_name" value="<?php echo isset($_SESSION['full_name']) ? htmlspecialchars($_SESSION['full_name']) : ''; ?>">
                <input type="hidden" name="email" value="<?php echo isset($_SESSION['email']) ? htmlspecialchars($_SESSION['email']) : ''; ?>">
                <input type="hidden" name="password" value="<?php echo isset($_SESSION['password']) ? htmlspecialchars($_SESSION['password']) : ''; ?>">
                <input type="hidden" name="status" value="Pending">
                
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
    <!-- End Hero Section -->

</body>
</html>
