<?php
class MathematicsStudent {
    public $name;
    public $age;
    public $major;
    public $gpa;

    function __construct($name, $age, $major, $gpa) {
        $this->name = $name;
        $this->age = $age;
        $this->major = $major;
        $this->gpa = $gpa;
    }

    function displayDetails() {
        echo "<ul>";
        echo "<li>Name: $this->name</li>";
        echo "<li>Age: $this->age</li>";
        echo "<li>Major: $this->major</li>";
        echo "<li>GPA: $this->gpa</li>";
        echo "</ul>";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $age = $_POST['age'];
    $major = $_POST['major'];
    $gpa = $_POST['gpa'];

    // Create MathematicsStudent object
    $student = new MathematicsStudent($name, $age, $major, $gpa);

    // Display student details
    echo "<h3>Student Details:</h3>";
    $student->displayDetails();
}
?>
