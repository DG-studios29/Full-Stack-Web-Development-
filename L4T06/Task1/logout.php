<?php
session_start();

// Unset all session variables
session_unset();

// Destroy the session
session_destroy();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout</title>
</head>
<body>
    <h1>You have been successfully logged out</h1>
    <a href="home.html">Back to Home</a>
</body>
</html>
