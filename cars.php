<?php
session_start();
$loggedIn = isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AutoCarMatch - Cars Available</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <style>
        body {
            background: url('carsbackground.jpg') no-repeat center center fixed;
            background-size: cover;
            color: #fff;
        }

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
            color: #fff;
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
            display:flex;
            justify-content: center;
            align-items: center;
        }

        .hero .text {
            width: 90%;
            margin: auto;
        }

        .hero .text h4 {
            font-size: 40px;
            color: #fff;
            font-weight: 500;
            margin-bottom: 10px;
        }

        .hero .text h1 {
            font-size: 65px;
            color: #fff;
            text-transform: uppercase;
            line-height: 1;
            margin-bottom: 30px;
        }

        .hero .text h1 span {
            color: #6c757d;
            font-size: 80px;
            font-weight: bold;
        }

        .hero .text p {
            color: #fff;
            margin-bottom: 30px;
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

        section {
            padding: 20px;
        }

        .heading {
            text-align: center;
            margin-bottom: 20px;
        }

        .heading span {
            display: block;
            font-size: 24px;
            font-weight: bold;
        }

        .heading h2 {
            font-size: 30px;
            margin: 10px 0;
        }

        .heading p {
            font-size: 16px;
            color: #666;
        }

        .cars-container {
            display: flex;
            flex-wrap: wrap;
            gap: 2rem;
            margin-top: 2rem;
        }

        .cars-container .box {
            flex: 1 1 17rem;
            background-color: rgba(0, 0, 0, 0.8);
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            transition: transform 0.3s;
        }

        .cars-container .box img {
            max-width: 100%;
            height: 200px; /* Adjust this height as needed */
            object-fit: contain; /* Ensures the image covers the entire box */
            border-radius: 10px;
        }


        .cars-container .box h2 {
            margin-top: 20px;
            font-size: 25px;
            color: #fff
        }

        .cars-container .box:hover {
            transform: translateY(-10px);
        }
        
        .car-link {
            text-decoration: none; /* Remove underline */
            color: #fff; /* Set the text color for car names */
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
                            <a class="nav-link" href="aboutus.php">About Us</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="cars.php">Cars Available</a>
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

    <!-- Cars Section -->
    <section>
        <div class='heading'>
            <br>
            <br>
            <br>
            <br>
            <br>
            <span>All Cars </span>
            <h2>These are the available Proton cars now</h2>
            <p>Select a car that you like and it will lead you to its page</p>
        </div>
        <!-- Cars container -->
        <div class="cars-container container">
            <?php
            // Database connection parameters
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "autocar";

            // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Fetch cars data
            $cars_sql = "SELECT * FROM cars";
            $cars_result = $conn->query($cars_sql);

            $cars = array();

            if ($cars_result->num_rows > 0) {
                while ($row = $cars_result->fetch_assoc()) {
                    $car_id = $row['car_id'];
                    $car_name = $row['car_name'];

                    // Fetch image for current car
                    $image_sql = "SELECT image_path FROM car_images WHERE car_id = $car_id LIMIT 1";
                    $image_result = $conn->query($image_sql);

                    if ($image_result->num_rows > 0) {
                        $image_row = $image_result->fetch_assoc();
                        $image_path = $image_row['image_path']; // Path directly from database
                    } else {
                        // Default image path if no image found
                        $image_path = 'default_image.jpg'; // Replace with your default image path
                    }

                    // Store car data with image path
                    $cars[] = array(
                        'car_id' => $car_id,
                        'car_name' => $car_name,
                        'image_path' => $image_path
                    );
                }
            }

            $conn->close();
            ?>

            <?php foreach ($cars as $car): ?>
                <div class="box">
                    <a href="cardetails.php?car_id=<?php echo $car['car_id']; ?>" class="car-link">
                        <img src="<?php echo $car['image_path']; ?>" alt="<?php echo $car['car_name']; ?>">
                        <h2><?php echo $car['car_name']; ?></h2>
                    </a>
                </div>
            <?php endforeach; ?>

        </div>
    </section>
</body>
</html>
