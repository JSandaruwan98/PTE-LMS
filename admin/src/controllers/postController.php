<?php
include '../config/database.php';
include '../models/employeeModel.php';
include '../models/checkboxModel.php';
include '../models/attendanceModel.php';
include '../models/studentModel.php';
include '../models/batchModel.php';


$employee = new EmployeeModel($conn);
$checkbox = new Checkbox($conn); 
$attendance = new Attendance($conn);
$student = new StudentModel($conn);
$batch = new BatchModel($conn);



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
    
    }elseif ($task === 'checkbox') {
        $featureEnabled = ($_POST['featureEnabled'] === 'true') ? 1 : 0; // Convert to 1 or 0
        $id = $_POST['id'];
        $table = $_POST['table'];
        $idName = $_POST['idname'];

        $response = $checkbox->checkboc($table, $featureEnabled, $idName, $id);

    }elseif ($task === 'markAttendance') {

        $attendanceDate = $_POST['attendanceDate'];
        $personId = $_POST['personId'];
        $personIdName = $_POST['$personIdName'];

        $response = $attendance->markAttendance($attendanceDate, $personId, $personIdName);

    }elseif ($task === 'removeAttendance') {

        $attendanceId = $_POST['attendanceId'];
        
        $response = $attendance->removeAttendance($attendanceId);

    }elseif ($task === 'insertStudent') {

        $studentid = $_POST['studentid'];
        $name = $_POST['name'];
        $phone = $_POST['phone'];
        $program = $_POST['program'];
        $batchid = $_POST['batchid'];
        $starton = $_POST['starton'];
         

        $response = $student->insertStudent($studentid, $name, $phone, $program, $batchid, $starton);
    }elseif ($task === 'insertBatch') {

        $program = $_POST['program'];
        $class = $_POST['class'];
        $batchname = $_POST['batchname'];
        $timefrom = $_POST['timefrom'];
        $timeto = $_POST['timeto'];

        $response = $batch->insertBatch($program, $class, $batchname, $timefrom, $timeto);
    
    } 

}

header('Content-Type: application/json');
echo json_encode($response);

$conn->close();
?>
