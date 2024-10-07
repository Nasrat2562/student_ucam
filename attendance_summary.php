<?php
session_start(); // Start session to access session variables

// If the user is not logged in, redirect to login page
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Assuming you are fetching available academic sessions from the database
$host = 'localhost';  // Update with your database host
$dbname = 'student_ucam';  // Update with your database name
$username = 'root';  // Update with your database username
$password = '';  // Update with your database password

// Create a connection to the database
$conn = new mysqli($host, $username, $password, $dbname);

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all available sessions for the user (e.g., based on student or course)
$loggedInUsername = $_SESSION['username'];
$sql = "SELECT DISTINCT academic_session FROM course_history WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $loggedInUsername);
$stmt->execute();
$result = $stmt->get_result();

// Close the connection after fetching
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Summary</title>
</head>
<body>
    <h2>Attendance Summary</h2>

    <!-- Form to select academic session -->
    <form action="attendance_details.php" method="GET">
        <label for="session">Select Academic Session:</label>
        <select name="session" id="session" required>
            <option value="">-- Select Session --</option>
            <?php
            if ($result->num_rows > 0) {
                // Loop through the results and add each session as an option in the dropdown
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['academic_session'] . "'>" . $row['academic_session'] . "</option>";
                }
            } else {
                echo "<option value=''>No sessions available</option>";
            }
            ?>
        </select>
        <br><br>
        <input type="submit" value="View Attendance">
    </form>
</body>
</html>

