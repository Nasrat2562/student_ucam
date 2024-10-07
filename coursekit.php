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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Coursekit</title>
</head>
<body>
    <h2>Student Coursekit</h2>
    <p>Your course materials and resources will be available here.</p>
</body>
</html>
