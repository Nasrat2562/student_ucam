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

// Prepare the SQL query to fetch the user details from the database
$sql = "SELECT id, name, program, batch, cga FROM course_history WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $loggedInUsername);  // Bind the username to the query
$stmt->execute();
$result = $stmt->get_result();

// Check if user data was found
if ($result->num_rows > 0) {
    // Fetch the user data
    $row = $result->fetch_assoc();
    $id = $row['id'];
    $name = $row['name'];
    $program = $row['program'];
    $batch = $row['batch'];
    $cga = $row['cga'];
} else {
    echo "No user found with the provided username.";
    exit();
}

// Fetch the user's course history
$courseSql = "SELECT academic_session, course_code, course_title, credit, grade, grade_point FROM course_history WHERE username = ?";
$courseStmt = $conn->prepare($courseSql);
$courseStmt->bind_param("s", $loggedInUsername);  // Bind the username to the query
$courseStmt->execute();
$courseResult = $courseStmt->get_result();

// Close the connection after fetching
$courseStmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course History</title>
    <style>
        /* Style the navbar to be horizontal */
        nav {
            background-color: #f8f9fa;
            padding: 10px;
        }
        ul {
            list-style-type: none; /* Remove bullet points */
            margin: 0; /* Remove default margin */
            padding: 0; /* Remove default padding */
            overflow: hidden; /* Ensure container is cleared */
        }
        li {
            float: left; /* Align the list items horizontally */
            padding: 0 15px; /* Add spacing between items */
            border-right: 1px solid #ccc; /* Optional: add a separator */
        }
        li:last-child {
            border-right: none; /* Remove separator from the last item */
        }

        /* Style the course table */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
        th, td {
            text-align: left;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav>
        <ul>
            <li>ID: <?php echo $id; ?></li>
            <li>Name: <?php echo $name; ?></li>
            <li>Program: <?php echo $program; ?></li>
            <li>Batch: <?php echo $batch; ?></li>
            <li>CGA: <?php echo $cga; ?></li>
        </ul>
    </nav>

    <h2>Course History</h2>

    <!-- Course History Table -->
    <table>
        <thead>
            <tr>
                <th>SL</th>
                <th>Academic Session</th>
                <th>Course Code</th>
                <th>Course Title</th>
                <th>Credit</th>
                <th>Grade</th>
                <th>Grade Point</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($courseResult->num_rows > 0) {
                $serialNumber = 1;  // Initialize serial number
                // Fetch each row from the result
                while ($courseRow = $courseResult->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $serialNumber++ . "</td>";
                    echo "<td>" . $courseRow['academic_session'] . "</td>";
                    echo "<td>" . $courseRow['course_code'] . "</td>";
                    echo "<td>" . $courseRow['course_title'] . "</td>";
                    echo "<td>" . $courseRow['credit'] . "</td>";
                    echo "<td>" . $courseRow['grade'] . "</td>";
                    echo "<td>" . $courseRow['grade_point'] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No course history available.</td></tr>";
            }
            ?>
        </tbody>
    </table>

</body>
</html>



