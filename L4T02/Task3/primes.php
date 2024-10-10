<?php

// Function to check if a number is prime
function isPrime($number) {
    if ($number <= 1) {
        return false;
    }
    for ($i = 2; $i <= sqrt($number); $i++) {
        if ($number % $i === 0) {
            return false;
        }
    }
    return true;
}

// Get the first 10 prime numbers
$primes = [];
$num = 2; // Starting from 2, the first prime number
while (count($primes) < 10) {
    if (isPrime($num)) {
        $primes[] = $num;
    }
    $num++;
}

// Print the prime numbers in HTML list format
echo "<ul>";
foreach ($primes as $prime) {
    echo "<li>$prime</li>";
}
echo "</ul>";

?>
