<?php
include '../config/database.php';
include '../models/employeeModel.php';


$employee = new EmployeeModel($conn);



if($_SERVER["REQUEST_METHOD"] == "POST"){
    if (isset($_POST['task'])) {
        $task = $_POST['task'];
    }

    if ($task === 'insertEmployee') {

        $name = $_POST['name'];
        $email = $_POST['email'];
        $role = $_POST['role'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];
        $qualification = $_POST['qualification'];
        $uname = $_POST['uname'];
        $pass = $_POST['pass'];
        $DOB = $_POST['dob'];

        
        $response = $employee->insertEmployee($name, $email, $role, $phone, $address, $qualification, $uname, $pass, $DOB);
    
    }

}

header('Content-Type: application/json');
echo json_encode($response);

$conn->close();
?>
