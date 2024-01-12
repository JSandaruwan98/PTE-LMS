<?php
include '../models/employeeModel.php';
include '../config/database.php';

$employee = new EmployeeModel($conn);

if (isset($_GET['data_type'])) {
    $data_type = $_GET['data_type'];

    if ($data_type === 'viewEmployee') {
        $data = $employee->viewEmployee();
    } 


    header('Content-Type: application/json');
    echo json_encode($data);

}else {
    echo "Specify data_type parameter (batch or class)";
}


$conn->close();