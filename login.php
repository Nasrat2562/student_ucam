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

// Handle login
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $inputUsername = $_POST['username'];
    $inputPassword = $_POST['password'];

    // Check if user exists
    $stmt = $conn->prepare("SELECT password, profile_picture FROM users WHERE username = ?");
    $stmt->bind_param("s", $inputUsername);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($hashed_password, $profile_picture);
        $stmt->fetch();

        // Verify the password
        if (password_verify($inputPassword, $hashed_password)) {
            // Save user information in session variables
            $_SESSION['username'] = $inputUsername;
            $_SESSION['profile_picture'] = $profile_picture;

            // Redirect to the navbar.php page
            header("Location: navbar.php");
            exit();
        } else {
            echo "Incorrect password.";
        }
    } else {
        echo "Username not found.";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <form method="POST" action="">
        <label>Username:</label><br>
        <input type="text" name="username" required><br><br>
        <label>Password:</label><br>
        <input type="password" name="password" required><br><br>
        <input type="submit" value="Login">
    </form>
    <br>
    <a href="signup.php">Don't have an account? Sign up here</a>
</body>
</html>





