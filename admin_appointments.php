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

// Fetch all appointments
$sql = "SELECT * FROM car_services";
$result = $conn->query($sql);

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
    <title>AutoCarMatch - Admin Appointments</title>
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
        /* Ensure styles for .navbar and .hero-section are included */
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
            background: url(./adminappointment.jpg);
            background-position: center;
            background-size: cover;
            display:flex;
            justify-content: center;
            align-items: center;
            position: relative;
        }

        .hero .text {
            width: 80%; /* Adjust width as per your design */
            margin: auto; /* Center align horizontally */
            color: #fff;
            text-align: center;
            padding: 20px;
            border-radius: 10px;
        }


        .hero .text h4 {
            font-size: 40px;
            font-weight: 500;
            margin-bottom: 10px;
        }
        
        .hero .text h1 {
            font-size: 65px;
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
            margin-bottom: 30px;
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
                            <a class="nav-link" href="admincar.html">Admin Add Car</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="admin_appointments.php">Admin Appointments</a>
                        </li>
                    </ul>
                </div>
            </div>
            <a href="logout.php" class="login-button">Logout</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>
    <!-- End Navbar -->
    
    <!-- Admin Appointments Section -->
    <div class="hero">
        <div class="text">
            <h1>Admin Appointments</h1>
            <?php if ($result->num_rows > 0) { ?>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>User's Name</th>
                                <th>Car Make & Model</th>
                                <th>Service Type</th>
                                <th>Service Date</th>
                                <th>Status</th>
                                <th>Additional Notes</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $result->fetch_assoc()) { ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['full_name']); ?></td>
                                    <td><?php echo htmlspecialchars($row['car_make_model']); ?></td>
                                    <td><?php echo htmlspecialchars($row['service_type']); ?></td>
                                    <td><?php echo htmlspecialchars($row['service_date']); ?></td>
                                    <td <?php echo getStatusColor($row['status']); ?>><?php echo htmlspecialchars($row['status']); ?></td>
                                    <td><?php echo htmlspecialchars($row['additional_notes']); ?></td>
                                    <td>
                                        <?php if ($row['status'] == 'Pending') { ?>
                                            <form action="update_status.php" method="post">
                                                <input type="hidden" name="appointment_id" value="<?php echo $row['id']; ?>">
                                                <button type="submit" name="accept" class="btn btn-success">Accept</button>
                                                <button type="submit" name="reject" class="btn btn-danger">Reject</button>
                                            </form>
                                        <?php } ?>
                                    </td>
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
    <!-- End Admin Appointments Section -->

</body>
</html>
