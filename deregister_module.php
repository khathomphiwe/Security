<?php

include_once('config.php');

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Check if module ID is provided
if (!isset($_GET['id'])) {
    echo "Module ID is missing.";
    exit();
}

// Get module ID from query parameter
$moduleId = $_GET['id'];
$username = $_SESSION['username'];
$userId = getUserId($username, $conn);

// Deregister the user from the module
$query = "DELETE FROM enrolled_modules WHERE student_id = ? AND module_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $userId, $moduleId);
if ($stmt->execute()) {
    echo "Deregistered from the module successfully";
} else {
    echo "Error deregistering from the module: " . $stmt->error;
}


$conn->close();

// Helper function to get the user's ID from the username
function getUserId($username, $conn) {
    $query = "SELECT id FROM users WHERE username = '$username'";
    $result = $conn->query($query);
    $row = $result->fetch_assoc();
    return $row['id'];
}

// Redirect back to home.php after 3 seconds
header("Refresh: 3; URL=home.php");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Deregistering Module</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <h2>Deregistering Module</h2>
    <p>You will be redirected to the home page in 3 seconds.</p>
</body>
</html>
