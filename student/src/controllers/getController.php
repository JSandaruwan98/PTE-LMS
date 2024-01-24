<?php
include '../models/examSpaceModel.php';
include '../config/database.php';


$examSpace = new ExamSpaceModel($conn);


if (isset($_GET['data_type'])) {
    $data_type = $_GET['data_type'];
    if ($data_type === 'questionDisplay') {

        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $perPage = isset($_GET['per_page']) ? $_GET['per_page'] : 5;
        $offset = ($page - 1) * $perPage;
        $test_id = $_GET['test_id'];
        $type = $_GET['type'];

        $data = $examSpace->questionDisplay($perPage, $offset, $test_id, $type);
        //$data = 'kamal'; 
    }elseif ($data_type === 'attendance') {
        $data = $attendance->viewAttendance();
    }


    header('Content-Type: application/json');
    echo json_encode($data);

}else {
    echo "Specify data_type parameter (batch or class)";
}


$conn->close();