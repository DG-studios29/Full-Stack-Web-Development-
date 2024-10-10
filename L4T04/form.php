<?php

function make_form($email=null, $age=null){
    echo '<h2>Please fill in the following details:</h2>';

    echo '<form action="form.php" method="post">';
    echo '<label for="email">Email address: </label>';
    if ($email === null)
        echo '<input type="text" id="email" name="email" required>';
    else
        echo '<input type="text" id="email" name="email" required value="'.$email.'">';
    echo '<br/><br/>';

    echo '<label for="age">Age: </label>';
    if ($age === null)
        echo '<input type="number" id="age" name="age" required>';
    else
        echo '<input type="number" id="age" name="age" required value="'.$age.'">';
    echo '<br/><br/>';

    echo '<button type="submit">Submit</button>';
    echo '</form>';
}


    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        $email = $_POST['email'];
        $age = (int) $_POST['age'];

        if (strlen($email) < 2){
            echo '<p>Email is too short!</p>';
            make_form($email, $age);
        }else if ($age < 1){
            echo '<p>You are too young!</p>';
            make_form($email, $age);
        }else{
            echo '<h1>Thank you for submitting your information.</h1>';
        }
    } else {
        make_form();
    }
?>