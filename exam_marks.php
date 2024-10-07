<?php
session_start(); // Start session to access session variables

// If the user is not logged in, redirect to login page
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Database connection details
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

// Prepare the SQL query to fetch the user's ID and course details
$sql = "SELECT student_id, course_code, course_title FROM exam_marks WHERE student_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $loggedInUsername);  // Bind the username to the query
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
    <title>Current Exam Marks</title>
    <style>
        /* Style for the table */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid black;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

    <h2>Current Exam Marks</h2>

    <?php if ($result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>ID Number</th>
                    <th>Course Code</th>
                    <th>Course Title</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Loop through the results and display each course
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['student_id']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['course_code']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['course_title']) . "</td>";
                    echo "<td><a href='view_exam_details.php?course_code=" . urlencode($row['course_code']) . "'>View Details</a></td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No exam results found for your courses.</p>
    <?php endif; ?>

</body>
</html>
