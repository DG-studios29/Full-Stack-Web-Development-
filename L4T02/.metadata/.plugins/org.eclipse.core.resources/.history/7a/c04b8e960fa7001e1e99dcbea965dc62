<?php
// Get the username from the GET request parameter
$username = isset($_GET['username']) ? $_GET['username'] : '';

// Function to apply color to the greeting based on the length of the username
function getGreeting($username) {
    $length = strlen($username);
    if ($length < 3) {
        return "<span style='color:green;'>Hello, $username!</span>";
    } elseif ($length >= 3 && $length <= 6) {
        return "<span style='color:blue;'>What's up, $username?</span>";
    } else {
        return "<span style='color:purple;'>Top of the morning to you, $username.</span>";
    }
}

// Display the greeting
echo getGreeting($username);
?>
