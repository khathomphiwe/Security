<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$database = "security";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get user input
$email = $_POST['email'];
$username = $_POST['username'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$campus = $_POST['campus'];

// Prepare and execute SQL query
$stmt = $conn->prepare("INSERT INTO users (email, username, password, campus) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $email, $username, $password, $campus);

if ($stmt->execute()) {
    // Close the prepared statement
    $stmt->close();
    $conn->close();

    // Redirect to index page with a success message
    echo "<script>alert('Sign up successful'); window.location.href = 'index.php';</script>";
    exit();
} else {
    // Check for specific MySQL error codes
    if ($conn->errno == 1062) {
        // Duplicate entry error
        if (strpos($conn->error, 'username')) {
            echo "<script>alert('Username already exists. Please choose a different one.'); window.location.href = 'signup.php';</script>";
        } elseif (strpos($conn->error, 'email')) {
            echo "<script>alert('Email address already exists. Please use a different one.'); window.location.href = 'signup.php';</script>";
        }
    } else {
        // Other errors
        echo "Error: " . $stmt->error;
    }
    // Close the prepared statement
    $stmt->close();
    $conn->close();
}
?>
