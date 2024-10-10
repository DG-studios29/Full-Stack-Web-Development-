<style>
    .err {
        color: red;
        font-weight: bold;
    }
</style>

<?php

// Function to display errors in a consistent style
function displayError($msg){
    echo '<p class="err">'.$msg.'</p>';
}

// Check if the form is submitted (POST method)
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Parse and display full name
    $name = isset($_POST['full_name']) ? $_POST['full_name'] : '';
    if (!$name) {
        displayError("Full name not specified!");
    } else {
        echo '<h1>Job details for: '. $name . '</h1>';
    }

    // Parse and display workplace
    $workplace = isset($_POST['work_place']) ? $_POST['work_place'] : '';
    if (!$workplace) {
        displayError("Workplace not specified!");
    } else {
        echo '<p><strong>Workplace</strong>: ' . $workplace . '</p>';
    }

    // Parse and display city
    $city = isset($_POST['city']) ? $_POST['city'] : '';
    if (!$city) {
        displayError("City not specified!");
    } else {
        echo '<p><strong>City</strong>: ' . $city . '</p>';
    }

    // Parse and display hourly wage
    $wage = isset($_POST['hourly_wage']) ? $_POST['hourly_wage'] : '';
    if (!$wage) {
        displayError("Wage not specified!");
    } else {
        echo '<p><strong>Wage</strong>: ' . $wage . '</p>';
    }

    // Parse and display job start date
    $start = isset($_POST['job_start_date']) ? $_POST['job_start_date'] : '';
    if (!$start) {
        displayError("Start date not specified!");
    } else {
        echo '<p><strong>Start date</strong>: ' . $start . '</p>';
    }

} else {
    // If the form is not submitted, display a message
    echo '<p class="err">Form not submitted!</p>';
}

?>
