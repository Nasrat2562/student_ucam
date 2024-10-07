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
    <title>Mid Evaluation</title>
</head>
<body>
    <h2>Mid Evaluation</h2>
    <p>Your mid-term evaluation results will be shown here.</p>
</body>
</html>
