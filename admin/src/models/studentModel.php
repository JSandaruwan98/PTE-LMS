<?php

class StudentModel
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function insertStudent($name, $email, $course)
    {
        $stmt = $this->conn->prepare("INSERT INTO students (name, email, course) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $course);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }



    public function viewStudent($name, $email, $course)
    {
        $stmt = $this->conn->prepare("INSERT INTO students (name, email, course) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $course);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
?>
