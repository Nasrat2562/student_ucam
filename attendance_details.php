<?php
session_start(); // Start session to access session variables

// If the user is not logged in, redirect to login page
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Check if the session parameter is present in the URL
if (!isset($_GET['session'])) {
    echo "No session selected.";
    exit();
}

$selectedSession = $_GET['session'];

// Database connection
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

// Retrieve the logged-in user's username from the session
$loggedInUsername = $_SESSION['username'];

// Prepare the SQL query to fetch attendance summary for the selected session
$sql = "SELECT course_code, course_title, attendance_percentage 
        FROM attendance 
        WHERE username = ? AND academic_session = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $loggedInUsername, $selectedSession); // Bind username and session
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
    <title>Attendance Details</title>
</head>
<body>
    <h2>Attendance Details for Session: <?php echo htmlspecialchars($selectedSession); ?></h2>

    <?php
    if ($result->num_rows > 0) {
        echo "<table border='1'>
            <tr>
                <th>Course Code</th>
                <th>Course Title</th>
                <th>Attendance (%)</th>
            </tr>";

        // Loop through the results and display each row
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                <td>" . htmlspecialchars($row['course_code']) . "</td>
                <td>" . htmlspecialchars($row['course_title']) . "</td>
                <td>" . htmlspecialchars($row['attendance_percentage']) . "</td>
            </tr>";
        }

        echo "</table>";
    } else {
        echo "<p>No attendance data available for the selected session.</p>";
    }
    ?>

</body>
</html>
