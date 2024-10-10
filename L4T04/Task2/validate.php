<?php
// Function to sanitize user input
function sanitizeInput($input)
{
    return htmlspecialchars(stripslashes(trim($input)));
}

// Function to validate gender
function validateGender($gender)
{
    $validGenders = array("male", "female", "other");
    return in_array($gender, $validGenders);
}

// Initialize variables for form fields
$email = $username = $password = $dob = $gender = $address = "";
$errorMsg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate email
    $email = sanitizeInput($_POST['email']);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errorMsg .= "Invalid email address<br>";
    }

    // Sanitize and validate username
    $username = sanitizeInput($_POST['username']);
    if (!preg_match("/^[A-Za-z0-9]{6,10}$/", $username)) {
        $errorMsg .= "Invalid username (6-10 characters; alphanumeric only)<br>";
    }

    // Password is exempt from repopulation

    // Sanitize and validate date of birth
    $dob = sanitizeInput($_POST['dob']);
    $dob_components = explode('-', $dob);
    $year = $dob_components[0];
    if ($year < 1900 || $year > 2019) {
        $errorMsg .= "Invalid year of birth<br>";
    }

    // Validate gender using the function
    $gender = sanitizeInput($_POST['gender']);
    if (!validateGender($gender)) {
        $errorMsg .= "Invalid gender<br>";
    }

    // Sanitize and validate address
    $address = sanitizeInput($_POST['address']);
    if (empty($address)) {
        $errorMsg .= "Invalid address<br>";
    }
}

// Display the form with repopulation and error messages
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration Form</title>
</head>
<body>
    <h2>User Registration Form</h2>
    
    <?php
    // Display error message if any
    if (!empty($errorMsg)) {
        echo "<p style='color: red;'>$errorMsg</p>";
    }
    ?>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="email">Email:</label>
        <input type="email" name="email" value="<?php echo $email; ?>" required>

        <label for="username">Username (6-10 characters, alphanumeric only):</label>
        <input type="text" name="username" value="<?php echo $username; ?>" pattern="[A-Za-z0-9]{6,10}" required>

        <label for="password">Password (at least one lowercase, one uppercase, and one number):</label>
        <input type="password" name="password" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$" required>

        <label for="dob">Date of Birth (after 1900 and before 2020):</label>
        <input type="date" name="dob" value="<?php echo $dob; ?>" required>

        <label for="gender">Gender:</label>
        <select name="gender" required>
            <option value="male" <?php echo ($gender === 'male') ? 'selected' : ''; ?>>Male</option>
            <option value="female" <?php echo ($gender === 'female') ? 'selected' : ''; ?>>Female</option>
            <option value="other" <?php echo ($gender === 'other') ? 'selected' : ''; ?>>Other</option>
        </select>

        <label for="address">Address (multiple lines):</label>
        <textarea name="address" rows="4" required><?php echo $address; ?></textarea>

        <button type="submit">Submit</button>
    </form>
</body>
</html>
