<?php

abstract class UniversityStudent {
    // Attributes
    protected $firstName;
    protected $lastName;
    protected $studentId;
    protected $age;

    // Constructor
    public function __construct($firstName, $lastName, $studentId, $age) {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->studentId = $studentId;
        $this->age = $age;
    }

    // Getter methods
    public function getFirstName() {
        return $this->firstName;
    }

    public function getLastName() {
        return $this->lastName;
    }

    public function getStudentId() {
        return $this->studentId;
    }

    public function getAge() {
        return $this->age;
    }

    // Abstract method
    abstract public function getAvgGrade();
}

class MathematicsStudent extends UniversityStudent {
    // Additional attributes
    protected $major;
    protected $avgGrade;

    // Constructor
    public function __construct($firstName, $lastName, $studentId, $age, $major, $avgGrade) {
        parent::__construct($firstName, $lastName, $studentId, $age);
        $this->major = $major;
        $this->avgGrade = $avgGrade;
    }

    // Getter and setter methods
    public function getMajor() {
        return $this->major;
    }

    public function getAvgGrade() {
        return $this->avgGrade;
    }

    public function setAvgGrade($avgGrade) {
        $this->avgGrade = $avgGrade;
    }
}

// Example usage
$mathStudent = new MathematicsStudent("John", "Doe", "12345", 20, "Mathematics", 85.5);

echo "Student Information:\n";
echo "Name: " . $mathStudent->getFirstName() . " " . $mathStudent->getLastName() . "\n";
echo "Student ID: " . $mathStudent->getStudentId() . "\n";
echo "Age: " . $mathStudent->getAge() . "\n";
echo "Major: " . $mathStudent->getMajor() . "\n";
echo "Average Grade: " . $mathStudent->getAvgGrade() . "\n";

?>
