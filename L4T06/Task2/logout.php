<?php
// Delete cookies by setting expiration time to the past
setcookie("fullname", "", time() - 3600);
setcookie("username", "", time() - 3600);
setcookie("dob", "", time() - 3600);
setcookie("gender", "", time() - 3600);
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
