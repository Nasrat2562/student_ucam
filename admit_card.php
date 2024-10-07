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
    <title>Admit Card</title>
</head>
<body>
    <h2>Admit Card</h2>
    <p>Your admit card for upcoming exams will be displayed here.</p>
</body>
</html>
