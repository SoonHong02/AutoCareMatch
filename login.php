<?php
session_start();

// Database connection settings
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

// Process login form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format.";
    } else {
        // Check if email exists in admin table
        $sql_admin = "SELECT * FROM admin WHERE admin_email = ?";
        $stmt_admin = $conn->prepare($sql_admin);
        $stmt_admin->bind_param("s", $email);
        $stmt_admin->execute();
        $result_admin = $stmt_admin->get_result();

        // Check if email exists in users table if not found in admin
        if ($result_admin->num_rows == 0) {
            $sql_users = "SELECT * FROM users WHERE email = ?";
            $stmt_users = $conn->prepare($sql_users);
            $stmt_users->bind_param("s", $email);
            $stmt_users->execute();
            $result_users = $stmt_users->get_result();

            if ($result_users->num_rows == 1) {
                // User found in users table, verify password
                $row_users = $result_users->fetch_assoc();
                $hashedPassword = $row_users['password']; // Replace with your actual column name for password

                if (password_verify($password, $hashedPassword)) {
                    // Password is correct, set session variables for regular user
                    $_SESSION['loggedin'] = true;
                    $_SESSION['email'] = $email;
                    $_SESSION['full_name'] = $row_users['full_name']; // Replace with your actual column name for full name
                    $_SESSION['user_id'] = $row_users['id']; // Use 'id' from your database

                    // Redirect user to homepage.php or another page
                    header("Location: homepage.php");
                    exit();
                } else {
                    // Invalid password
                    echo "Invalid email or password.";
                }
            } else {
                // Email not found in users table
                echo "Invalid email or password.";
            }

            // Close statement
            $stmt_users->close();
        } else {
            // Admin found in admin table, verify password
            $row_admin = $result_admin->fetch_assoc();
            $hashedPassword = $row_admin['admin_password']; // Replace with your actual column name for password

            if (password_verify($password, $hashedPassword)) {
                // Password is correct, set session variables for admin
                $_SESSION['loggedin'] = true;
                $_SESSION['email'] = $email;
                $_SESSION['full_name'] = $row_admin['admin_name']; // Replace with your actual column name for full name

                // Redirect admin to admin_dashboard.php
                header("Location: admin_appointments.php");
                exit();
            } else {
                // Invalid password
                echo "Invalid email or password.";
            }
        }

        // Close statements
        $stmt_admin->close();
    }
}

// Close connection
$conn->close();
?>
