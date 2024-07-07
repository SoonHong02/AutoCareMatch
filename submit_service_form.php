<?php
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

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate input data
    $carMakeModel = htmlspecialchars($_POST['carMakeModel']);
    $serviceType = htmlspecialchars($_POST['serviceType']);
    $serviceDate = htmlspecialchars($_POST['serviceDate']);
    $additionalNotes = htmlspecialchars($_POST['notes']);
    $agreeTerms = isset($_POST['agreeTerms']) ? 1 : 0;
    $sessionId = htmlspecialchars($_POST['session_id']); // Fetch session ID
    $userId = isset($_POST['user_id']) ? htmlspecialchars($_POST['user_id']) : null; // Fetch user ID
    $fullName = isset($_POST['full_name']) ? htmlspecialchars($_POST['full_name']) : null; // Fetch full name
    $email = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : null; // Fetch email
    $password = isset($_POST['password']) ? htmlspecialchars($_POST['password']) : null; // Fetch password
    $status = 'Pending'; // or any other initial status you prefer

    // Validate service date
    $currentDateTime = new DateTime();
    $inputDateTime = new DateTime($serviceDate);

    if ($inputDateTime <= $currentDateTime) {
        // Date is not in the future
        echo "<script>
                alert('Service date must be in the future.');
                window.location.href = 'CarService.php';
              </script>";
        exit; // Prevent further execution
    }

    // Prepare SQL statement
    $sql = "INSERT INTO car_services (car_make_model, service_type, service_date, additional_notes, agree_terms, session_id, user_id, full_name, email, password, status) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssisissss", $carMakeModel, $serviceType, $serviceDate, $additionalNotes, $agreeTerms, $sessionId, $userId, $fullName, $email, $password, $status);

    // Execute SQL statement
    if ($stmt->execute()) {
        // Insertion successful
        echo "<script>
                alert('Service form submitted successfully.');
                window.location.href='appointments.php';
              </script>";
    } else {
        // Insertion failed
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close statement
    $stmt->close();
}

// Close connection
$conn->close();
?>
