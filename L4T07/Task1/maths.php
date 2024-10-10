<?php

function is_positive($number) {
    if ($number <= 0) {
        throw new Exception("Number should be positive.");
    }
}

function is_divisible($number) {
    if ($number % 5 !== 0) {
        throw new Exception("Number should be divisible by 5.");
    }
}

function enough_digits($number) {
    if (strlen((string)$number) < 4) {
        throw new Exception("Number should have at least 4 digits.");
    }
}

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $inputNumber = isset($_POST['number']) ? $_POST['number'] : null;

        // Validate and process the input
        is_positive($inputNumber);
        is_divisible($inputNumber);
        enough_digits($inputNumber);

        // If all validations pass, you can perform further operations here.
        echo "<p>Input number is valid and meets all conditions!</p>";

    } else {
        throw new Exception("Invalid request method.");
    }
} catch (Exception $e) {
    // Handle exceptions by echoing the respective error data in formatted HTML.
    echo "<p style='color: red; font-weight: bold;'>Error: " . $e->getMessage() . "</p>";
}
?>
