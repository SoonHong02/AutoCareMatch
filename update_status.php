<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // User is not logged in, redirect to login page
    header('Location: login.html');
    exit;
}

// Database connection details (same as in admin_appointments.php)
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $appointment_id = $_POST['appointment_id'];
    
    if (isset($_POST['accept'])) {
        // Update status to Accepted
        $update_status_sql = "UPDATE car_services SET status='Accepted' WHERE id=$appointment_id";
    } elseif (isset($_POST['reject'])) {
        // Update status to Rejected
        $update_status_sql = "UPDATE car_services SET status='Rejected' WHERE id=$appointment_id";
    }
    
    if ($conn->query($update_status_sql) === TRUE) {
        // Redirect back to admin_appointments.php after update
        header('Location: admin_appointments.php');
        exit;
    } else {
        echo "Error updating status: " . $conn->error;
    }
}

// Close connection
$conn->close();
?>
