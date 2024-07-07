<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "autocar";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullName = $_POST['fullName'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    if (empty($fullName) || empty($email) || empty($password) || empty($confirmPassword)) {
        echo "All fields are required.";
    } elseif ($password !== $confirmPassword) {
        echo "Passwords do not match.";
    } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Check if the email already exists in the database
        $checkEmailQuery = "SELECT * FROM users WHERE email = '$email'";
        $checkResult = $conn->query($checkEmailQuery);

        if ($checkResult->num_rows > 0) {
            echo "Email already exists. Please use a different email address.";
        } else {
            // Insert the new user into the database
            $sql = "INSERT INTO users (full_name, email, password) VALUES ('$fullName', '$email', '$hashedPassword')";

            if ($conn->query($sql) === TRUE) {
                echo "Registration successful. Proceed to <a href='login.html'>Login</a>.";
                // Redirect to login.html after displaying the message
                header("Location: login.html");
                exit();
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    }
}

$conn->close();
?>
