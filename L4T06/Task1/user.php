<?php
session_start();

function isValidGender($gender) {
    $allowedGenders = ['Male', 'Female', 'Other']; // Add more genders as needed
    return in_array($gender, $allowedGenders);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and set user data in session
    $fullname = $_POST['fullname'];
    $username = $_POST['username'];
    $dob = $_POST['dob'];
    $gender = isset($_POST['gender']) ? $_POST['gender'] : '';

    if (isValidGender($gender)) {
        $_SESSION['fullname'] = $fullname;
        $_SESSION['username'] = $username;
        $_SESSION['dob'] = $dob;
        $_SESSION['gender'] = $gender;
    } else {
        echo "Invalid gender selection.";
        // Handle invalid gender (e.g., redirect back to the form)
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
</head>
<body>
    <h1>Welcome, <?php echo $_SESSION['fullname']; ?>!</h1>
    <p>Your details:</p>
    <ul>
        <li><strong>Full Name:</strong> <?php echo $_SESSION['fullname']; ?></li>
        <li><strong>Username:</strong> <?php echo $_SESSION['username']; ?></li>
        <li><strong>Date of Birth:</strong> <?php echo $_SESSION['dob']; ?></li>
        <li><strong>Gender:</strong> <?php echo $_SESSION['gender']; ?></li>
    </ul>
    <form action="logout.php" method="post">
        <input type="submit" value="Logout">
    </form>
</body>
</html>
