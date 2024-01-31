<?php
include '../models/examSpaceModel.php';
include '../config/database.php';
include '../models/fetchAndDisplayModel.php';


$examSpace = new ExamSpaceModel($conn);
$fetchAndDisplay = new FetchAndDisplay($conn);


if (isset($_GET['data_type'])) {
    $data_type = $_GET['data_type'];
    if ($data_type === 'questionDisplay') {

        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $perPage = isset($_GET['per_page']) ? $_GET['per_page'] : 5;
        $offset = ($page - 1) * $perPage;
        $test_id = $_GET['test_id'];
        $type = $_GET['type'];

        $data = $examSpace->questionDisplay($perPage, $offset, $test_id, $type);

    }elseif ($data_type === 'fetchAndDisplay') {

        $question_id = $_GET['question_id'];

        if(isset($_GET['answer_id'])){
            $answer_id = $_GET['answer_id'];
            $data = $fetchAndDisplay->fetchAnsweringEachData($question_id, $answer_id);
        }else{
            $data = $fetchAndDisplay->fetchAnsweringData($question_id);
        }

        

    }


    header('Content-Type: application/json');
    echo json_encode($data);

}else {
    echo "Specify data_type parameter (batch or class)";
}


$conn->close();