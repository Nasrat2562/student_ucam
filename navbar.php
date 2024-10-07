<?php
session_start(); // Start session to access session variables

// If the user is not logged in, redirect to login page
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>University Portal</title>
    <link rel="stylesheet" href="style.css"> <!-- Add your CSS file here -->
    <style>
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #007bff; /* Set navbar color to blue */
            padding: 10px;
        }
        .navbar .logo {
            color: #fff;
            font-size: 24px;
        }
        .navbar .profile {
            display: flex;
            align-items: center;
        }
        .navbar .profile img {
            border-radius: 50%;
            width: 40px;
            height: 40px;
            margin-right: 10px;
        }
        .navbar .profile button {
            padding: 5px 10px;
            background-color: #f44336;
            color: white;
            border: none;
            cursor: pointer;
        }
        .navbar .profile a {
            padding: 5px 10px;
            color: white;
            text-decoration: none;
        }
        /* Add style for navigation links */
        .nav-links {
            display: flex;
            justify-content: space-around;
            width: 70%;
            color: white;
        }
        .nav-links a {
            color: blue;
            padding: 10px;
            text-decoration: none;
            font-size: 18px;
        }
        .nav-links a:hover {
            background-color: #0056b3;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <nav>
        <div class="navbar">
            <!-- University Name -->
            <div class="logo">
                <h2>BUP</h2>
            </div>

            <!-- Profile Information and Logout Button -->
            <div class="profile">
                <?php
                if (isset($_SESSION['username']) && isset($_SESSION['profile_picture'])) {
                    echo '<img src="' . htmlspecialchars($_SESSION['profile_picture']) . '" alt="Profile Picture">';
                    echo '<p><strong>' . htmlspecialchars($_SESSION['username']) . '</strong></p>';
                    echo '<form action="logout.php" method="POST" style="display:inline;"><button type="submit">Logout</button></form>';
                }
                ?>
            </div>
        </div>
    </nav>
    <nav>
<div class="nvbar">
<div class="nav-links">
                <a href="profile.php">Profile</a>
                <a href="course_history.php">Course History</a>
                <a href="attendance_summary.php">Attendance Summary</a>
                <a href="exam_marks.php">Current Exam Marks</a>
                <a href="bill_payment.php">Bill & Payment History</a>
                <a href="coursekit.php">Student Coursekit</a>
                <a href="admit_card.php">Admit Card</a>
                <a href="mid_evaluation.php">Mid Evaluation</a>
            </div>
       </div>
    </nav>
</body>
</html>



