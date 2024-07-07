<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // User is not logged in, redirect to login page
    header('Location: login.html');
    exit;
}

// Database connection details
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

// Fetch appointments for the logged-in user
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM car_services WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Close statement
$stmt->close();

// Close connection
$conn->close();

function getStatusColor($status) {
    switch ($status) {
        case 'Pending':
            return 'style="color: yellow;"';
            break;
        case 'Accepted':
            return 'style="color: green;"';
            break;
        case 'Rejected':
            return 'style="color: red;"';
            break;
        default:
            return ''; // Handle other statuses or no style needed
            break;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>AutoCarMatch - My Appointments</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

        <style>
            body {
                padding-top: 80px; /* Adjust for fixed navbar height */
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

            .hero {
                width: 100%;
                height: 100vh;
                background: url('./carservicebackground.jpg') no-repeat center;
                background-size: cover;
                display: flex;
                justify-content: center;
                align-items: center;
                text-align: center;
                padding: 40px 0;
            }

            .hero .text {
                width: 90%;
                max-width: 800px;
                background-color: rgba(0, 0, 0, 0.7);
                padding: 20px;
                border-radius: 10px;
                color: #fff;
            }

            .hero .text h1 {
                font-size: 36px;
                margin-bottom: 20px;
            }

            .hero .text table {
                width: 100%;
                margin-bottom: 20px;
                background-color: rgba(255, 255, 255, 0.1);
                border-radius: 10px;
            }

            .hero .text table th,
            .hero .text table td {
                padding: 10px;
                text-align: center;
                vertical-align: middle;
            }

            .hero .text table th {
                background-color: rgba(0, 0, 0, 0.5);
                color: #fff;
            }

            .hero .text table tbody tr:nth-child(even) {
                background-color: rgba(255, 255, 255, 0.1);
            }

            .hero .text table tbody tr:nth-child(odd) {
                background-color: rgba(255, 255, 255, 0.2);
            }

            .hero .text table tbody tr:hover {
                background-color: rgba(255, 255, 255, 0.3);
            }

            @media (max-width: 768px) {
                .hero {
                    background-position: top; /* Adjust background position for smaller screens */
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
                                <a class="nav-link" href="CarService.php">Car Services / Checkup</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="appointments.php">My Appointments</a>
                            </li><br>
                        </ul>
                        <a href="logout.php" class="login-button">Logout</a> <!-- Move logout link here -->
                    </div>
                </div>
                <span class="navbar-text text-white me-3">Welcome, <?php echo htmlspecialchars($_SESSION['full_name']); ?>!</span>
            </div>
        </nav>
        <!-- End Navbar -->


        <!-- Appointment List Section -->
        <div class="hero">
            <div class="text">
                <h1>My Appointments</h1>
                <?php if ($result->num_rows > 0) { ?>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Car Make & Model</th>
                                    <th>Service Type</th>
                                    <th>Service Date</th>
                                    <th>Status</th>
                                    <th>Additional Notes</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = $result->fetch_assoc()) { ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($row['car_make_model']); ?></td>
                                        <td><?php echo htmlspecialchars($row['service_type']); ?></td>
                                        <td><?php echo htmlspecialchars($row['service_date']); ?></td>
                                        <td <?php echo getStatusColor($row['status']); ?>><?php echo htmlspecialchars($row['status']); ?></td>
                                        <td><?php echo htmlspecialchars($row['additional_notes']); ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                <?php } else { ?>
                    <p>No appointments found.</p>
                <?php } ?>
            </div>
        </div>
        <!-- End Appointment List Section -->

    </body>
</html>
