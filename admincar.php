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

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Prepare variables for form data
    $carName = $_POST['car_name'] ?? '';
    $price = $_POST['price'] ?? '';
    $engine = $_POST['engine'] ?? '';
    $power = $_POST['power'] ?? '';
    $fuelEfficiency = $_POST['fuel_efficiency'] ?? '';
    $transmission = $_POST['transmission'] ?? '';

    // Prepare SQL statement to insert car details into the database
    $stmt = $conn->prepare("INSERT INTO cars (car_name, price, engine, power, fuel_efficiency, transmission) VALUES (?, ?, ?, ?, ?, ?)");

    // Check if statement preparation succeeded
    if ($stmt === false) {
        die('Error: ' . $conn->error);
    }

    // Bind parameters to the prepared statement
    $stmt->bind_param("ssssss", $carName, $price, $engine, $power, $fuelEfficiency, $transmission);

    // Execute the prepared statement
    $stmtExecuted = $stmt->execute();

    // Check if execution succeeded
    if ($stmtExecuted === false) {
        die('Error executing statement: ' . $stmt->error);
    }

    // Get the inserted car ID
    $carId = $stmt->insert_id;

    // Handle image uploads
    $targetDir = "uploads/";
    $imagePaths = [];

    // Loop through each uploaded file
    for ($i = 0; $i < count($_FILES["car_images"]["name"]); $i++) {
        $fileName = basename($_FILES["car_images"]["name"][$i]);
        $targetFilePath = $targetDir . $fileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

        // Check if file is a valid image
        $allowTypes = array('jpg', 'jpeg', 'png', 'gif');
        if (in_array(strtolower($fileType), $allowTypes)) {
            // Upload file to server
            if (move_uploaded_file($_FILES["car_images"]["tmp_name"][$i], $targetFilePath)) {
                $imagePaths[] = $targetFilePath;
            } else {
                die('Error uploading file: ' . $_FILES["car_images"]["error"][$i]);
            }
        } else {
            die('Invalid file type: ' . $_FILES["car_images"]["name"][$i]);
        }
    }

    // Insert image paths into the database
    foreach ($imagePaths as $path) {
        $stmtImage = $conn->prepare("INSERT INTO car_images (car_id, image_path) VALUES (?, ?)");

        // Check if statement preparation succeeded
        if ($stmtImage === false) {
            die('Error preparing image statement: ' . $conn->error);
        }

        // Bind parameters to the image statement
        $stmtImage->bind_param("is", $carId, $path);

        // Execute the image statement
        $stmtImageExecuted = $stmtImage->execute();

        // Check if execution succeeded
        if ($stmtImageExecuted === false) {
            die('Error executing image statement: ' . $stmtImage->error);
        }

        // Close image statement
        $stmtImage->close();
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();

    // Redirect to a success page or display a success message
    echo "<script>
            alert('Car details added successfully!');
            window.location.href='admincar.html';
          </script>";
}
?>
