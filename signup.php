<?php
session_start(); // Start session

$servername = "localhost";
$username = "root"; // Your MySQL username
$password = ""; // Your MySQL password
$dbname = "student_ucam";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle signup
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password

    // Handle image upload
    $target_dir = "uploads/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true); // Create directory if it doesn't exist
    }

    $image = $_FILES['profile_picture']['name'];
    $target_file = $target_dir . basename($image);

    if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $target_file)) {
        // Prepare and bind
        $stmt = $conn->prepare("INSERT INTO users (username, password, profile_picture) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $password, $target_file);

        if ($stmt->execute()) {
            $_SESSION['username'] = $username; // Store username in session
            $_SESSION['profile_picture'] = $target_file; // Store profile picture in session
            header("Location: navbar.php"); // Redirect to navbar page after signup
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
</head>
<body>
    <h2>Signup</h2>
    <form method="POST" action="" enctype="multipart/form-data">
        <label>Username:</label><br>
        <input type="text" name="username" required><br><br>
        <label>Password:</label><br>
        <input type="password" name="password" required><br><br>
        <label>Profile Picture:</label><br>
        <input type="file" name="profile_picture" required><br><br>
        <input type="submit" value="Signup">
    </form>
</body>
</html>


