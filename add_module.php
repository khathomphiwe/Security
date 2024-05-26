<?php
include_once('config.php');

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Add the module if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $moduleCode = $_POST['module_code'];
    $username = $_SESSION['username'];
    $userId = getUserId($username, $conn);

    // Check if the module exists
    $query = "SELECT id FROM modules WHERE code = '$moduleCode'";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $moduleId = $row['id'];

        // Check if the user is already enrolled in the module
        $query = "SELECT * FROM enrolled_modules WHERE student_id = '$userId' AND module_id = '$moduleId'";
        $result = $conn->query($query);
        if ($result->num_rows > 0) {
            echo "You are already enrolled in this module";
        } else {
            // Enroll the user in the module
            $query = "INSERT INTO enrolled_modules (student_id, module_id) VALUES ('$userId', '$moduleId')";
            if ($conn->query($query) === TRUE) {
                echo "Module added successfully";
            } else {
                echo "Error adding module: " . $conn->error;
            }
        }
    } else {
        echo "Module not found";
    }
}

// Fetch list of modules from the database
$moduleQuery = "SELECT id, code FROM modules";
$moduleResult = $conn->query($moduleQuery);

$conn->close();

// Helper function to get the user's ID from the username
function getUserId($username, $conn) {
    $query = "SELECT id FROM users WHERE username = '$username'";
    $result = $conn->query($query);
    $row = $result->fetch_assoc();
    return $row['id'];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Module</title>
    <link rel="stylesheet" type="text/css" href="styles.css">

    <style>
        /* styles.css */

body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f2f2f2;
}

.container {
    max-width: 400px;
    margin: 50px auto;
    padding: 20px;
    background-color: #fff;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

h2 {
    text-align: center;
    margin-bottom: 20px;
}

form {
    display: flex;
    flex-direction: column;
}

label {
    margin-bottom: 10px;
}

select, button {
    padding: 10px;
    margin-bottom: 20px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

button {
    background-color: #007bff;
    color: #fff;
    cursor: pointer;
}

button:hover {
    background-color: #0056b3;
}

a {
    display: block;
    text-align: center;
    text-decoration: none;
    color: #007bff;
}

a:hover {
    color: #0056b3;
}

    </style>

</head>
<body>
    <h2>Add Module</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <label for="module_code">Select Module:</label>
        <select name="module_code" required>
            <?php
            // Populate dropdown options with module codes
            while ($moduleRow = $moduleResult->fetch_assoc()) {
                echo "<option value='" . $moduleRow['code'] . "'>" . $moduleRow['code'] . "</option>";
            }
            ?>
        </select>

        <button type="submit">Add Module</button>
    </form>
    <a href="home.php">Back to Home</a>
</body>
</html>
