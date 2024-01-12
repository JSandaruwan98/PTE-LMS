<?php
include '../models/employeeModel.php';
include '../config/database.php';
include '../models/attendanceModel.php';
include '../models/batchModel.php';
include '../models/studentModel.php';
include '../models/classModel.php';

$class = new ClassModel($conn);
$employee = new EmployeeModel($conn);
$attendance = new Attendance($conn);
$batch = new BatchModel($conn);
$student = new StudentModel($conn);

if (isset($_GET['data_type'])) {
    $data_type = $_GET['data_type'];

    if ($data_type === 'viewEmployee') {
        $data = $employee->viewEmployee();
    }elseif ($data_type === 'attendance') {
        $data = $attendance->viewAttendance();
    }elseif ($data_type === 'viewMarkAttendance') {
        $data = $attendance->viewMarkAttendance();
    }elseif ($data_type === 'getBatch') {
        $data = $batch->getBatch();
    }elseif ($data_type === 'getStudentId') {
        $data = $student->getStudentId();
    }elseif ($data_type === 'viewStudent') {
        $data = $student->viewStudent();
    }elseif ($data_type === 'viewBatch') {
        $data = $batch->viewBatch();
    }elseif ($data_type === 'getClass') {
        $data = $class->getClass();
    } 


    header('Content-Type: application/json');
    echo json_encode($data);

}else {
    echo "Specify data_type parameter (batch or class)";
}


$conn->close();