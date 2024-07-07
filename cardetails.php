<?php
session_start();
$loggedIn = isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true;
?>
<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "autocar";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get car id from URL
$car_id = isset($_GET['car_id']) ? $_GET['car_id'] : die('ERROR: Car ID not found.');

// Prepare and execute SQL statement to fetch car details
$sql = "SELECT cars.*, car_images.image_path FROM cars LEFT JOIN car_images ON cars.car_id = car_images.car_id WHERE cars.car_id = ?";
$stmt = $conn->prepare($sql);

// Check if prepare was successful
if ($stmt === false) {
    die("Error preparing the statement: " . $conn->error);
}

$stmt->bind_param('i', $car_id);
$stmt->execute();
$result = $stmt->get_result();

// Check if car details were found
if ($result->num_rows > 0) {
    $car = $result->fetch_assoc();
    $car_name = $car['car_name'];
    $price = 'RM ' . $car['price'];
    $engine = $car['engine'];
    $power = $car['power'];
    $fuel_efficiency = $car['fuel_efficiency'];
    $transmission = $car['transmission'];
    $image_path = isset($car['image_path']) ? $car['image_path'] : 'uploads/default_image.jpg';
} else {
    die('ERROR: Car details not found.');
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <style>
        body {
            background: url('cardetailsbackground.jpg') no-repeat center center fixed;
            background-size: cover;
            color: #fff;
        }
        .navbar {
            background-color: #000;
            height: 80px;
            border-radius: 16px;
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
            background-color: #000;
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
        .hero-section .text {
            width: 90%;
            max-width: 500px;
            margin: auto;
            background-color: rgba(0, 0, 0, 0.5); /* Adjust opacity as needed */
            padding: 20px; /* Add padding to improve readability */
            border-radius: 10px; /* Optional: Add rounded corners */
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
        .car-details-container {
            display: flex;
            flex-wrap: wrap;
            gap: 2rem;
            margin-top: 2rem;
        }
        .car-details-container .box {
            flex: 1 1 17rem;
            background-color: rgba(0, 0, 0, 0.8);
            padding: 10px;
            border-radius: 10px;
            text-align: center;
            transition: transform 0.3s;
            overflow: hidden; /* Ensure the box clips overflow */
            position: relative;
        }
        .car-details-container .box img {
            width: 100%; /* Ensure the image fills the box width */
            height: 200px; /* Set a fixed height for consistency */
            object-fit: cover; /* Cover ensures the image fills the box without distortion */
            border-radius: 10px;
        }
        .car-details-container .box h2 {
            margin-top: 20px;
            font-size: 25px;
        }
        .car-details-container .box p {
            font-size: 16px;
            color: #ccc;
            margin-top: 10px;
        }
        .car-details-container .box:hover {
            transform: translateY(-10px);
        }
        .buttons {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 20px;
        }
        .buttons .btn {
            background-color: transparent;
            color: #fff;
            font-size: 17px;
            padding: 8px 20px;
            border-radius: 30px;
            text-transform: uppercase;
            transition: 0.3s;
            border: 2px solid #fff;
        }
        .buttons .btn:hover {
            background-color: #000;
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
    <section class="hero-section">
        <div class="text">
            <h4>Welcome to AutoCareMatch</h4>
            <h1>Find Your <span>Dream</span> Car</h1>
            <p>Explore our wide range of cars with comprehensive details and images.</p>
            <a href="cars.php" class="btn">Explore Now</a>
        </div>
    </section>

    <!-- Car Details Section -->
    <section class="car-details">
        <div class="heading">
            <span>Car Details</span>
            <h2><?php echo htmlspecialchars($car_name); ?></h2>
            <p>Get all the information about your selected car.</p>
        </div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-4">
                    <div class="box">
                        <img src="<?php echo htmlspecialchars($image_path); ?>" alt="Car Image" class="img-fluid">
                        <h2><?php echo htmlspecialchars($car_name); ?></h2>
                        <p>Price: <?php echo htmlspecialchars($price); ?></p>
                        <p>Engine: <?php echo htmlspecialchars($engine); ?></p>
                        <p>Power: <?php echo htmlspecialchars($power); ?></p>
                        <p>Fuel Efficiency: <?php echo htmlspecialchars($fuel_efficiency); ?></p>
                        <p>Transmission: <?php echo htmlspecialchars($transmission); ?></p>
                    </div>
                </div>
            </div>
            <div class="buttons">
                <a href="cars.php" class="btn">Back to Listing</a>
                <a href="https://www.proton.com/assets/pdf/proton-x50-brochure-2024.pdf" class="btn">Brochure</a>
                <a href="https://proton3skl.com/wp-content/uploads/2024/03/X50-PRICELIST-2024.pdf" class="btn">Pricelist</a>
            </div>
        </div>
    </section>

</body>
</html>
