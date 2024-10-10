<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Confirmation</title>
    <style>
        label {
            font-weight: bold;
        }
        .confirmation {
            margin-top: 20px;
        }
    </style>
</head>
<body>

<h1>Confirmation</h1>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $full_name = $_POST["full_name"];
    $address = $_POST["address"];
    $floors = $_POST["floors"];
    $residence_type = $_POST["residence_type"];
    $building_colour = $_POST["building_colour"];
    
    // Display confirmation details
    echo "<div class='confirmation'>";
    echo "<label>Full name:</label> $full_name <br/>";
    echo "<label>Address:</label> $address <br/>";
    echo "<label>Floors:</label> $floors <br/>";
    echo "<label>Residence type:</label> $residence_type <br/>";
    echo "<label>Building colour:</label> <div style='width: 30px; height: 30px; background-color: $building_colour;'></div> <br/>";
    echo "</div>";
} else {
    // If accessed directly, redirect to the form
    header("Location: residence-form.php");
    exit();
}
?>

</body>
</html>
