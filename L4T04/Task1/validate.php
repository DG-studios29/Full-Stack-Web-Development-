<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validation for email
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    if (!$email) {
        die("Invalid email address");
    }

    // Validation for username
    $username = filter_input(INPUT_POST, 'username', FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[A-Za-z0-9]{6,10}$/")));
    if (!$username) {
        die("Invalid username");
    }

    // Validation for password
    $password = filter_input(INPUT_POST, 'password', FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/")));
    if (!$password) {
        die("Invalid password");
    }

    // Validation for date of birth (individual components)
    $dob = $_POST['dob'];
    $dob_components = explode('-', $dob);
    $year = $dob_components[0];

    if ($year < 1900 || $year > 2019) {
        die("Invalid year of birth");
    }

    // Validation for gender
    $valid_genders = array("male", "female", "other");
    $gender = $_POST['gender'];

    if (!in_array($gender, $valid_genders)) {
        die("Invalid gender");
    }

    // Validation for address
    $address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_STRING);
    if (!$address) {
        die("Invalid address");
    }

    // If all validations pass, you can process the data or redirect to a success page
    echo "Form submitted successfully!";
} else {
    die("Invalid request method");
}
?>
