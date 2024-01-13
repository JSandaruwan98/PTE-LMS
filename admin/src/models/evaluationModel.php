<?php

class EvaluationModel
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

//===============================================================================================================================================    

    public function pendingEvaluation() {
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;

        $itemsPerPage = 10; // Number of items to display per page
        $offset = ($page - 1) * $itemsPerPage;

        $sql = "SELECT DISTINCT assigned_on, e.student_id, st.name AS student_name, e.attempted_on, te.name AS test_name  
                FROM testass AS ta, evaluation as e, assignstudent as assst, student as st, test as te 
                WHERE ta.test_id = e.test_id AND assst.student_id = e.student_id AND assst.batch_id = ta.batch_id AND te.test_id = e.test_id AND st.student_id = e.student_id 
                LIMIT $offset, $itemsPerPage";
        $result = $this->conn->query($sql);
        $data = array();
        $i=1;
        while ($row = $result->fetch_assoc()) {
            $row['serial_number'] = ($page - 1) * $itemsPerPage + $i;
            $data[] = $row;
            $i++;
        }

        $totalItemsQuery = "SELECT COUNT(*) AS total FROM `evaluation`";
        $totalItemsResult = mysqli_query($this->conn, $totalItemsQuery);
        $totalItems = mysqli_fetch_assoc($totalItemsResult)['total'];


        $response = [
            'data' => $data,
            'totalItems' => $totalItems
        ];

        return $response;
    }
    
//===============================================================================================================================================

    public function evaluationHistory() {
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;

        $itemsPerPage = 10; // Number of items to display per page
        $offset = ($page - 1) * $itemsPerPage;

        $sql = "SELECT DISTINCT s.student_id, s.name AS student_name, e.attempted_on AS attempted_on, t.name AS test_name, ta.assigned_on AS assigned_on, e.evaluation_on AS evaluation_on
                FROM evaluation AS e
                JOIN student AS s ON s.student_id = e.student_id
                JOIN test AS t ON t.test_id = e.test_id
                JOIN assignstudent AS sa ON sa.student_id = e.student_id
                JOIN testass AS ta ON ta.batch_id = sa.batch_id
                WHERE e.evaluation_on IS NOT NULL
                LIMIT $offset, $itemsPerPage";
        $result = $this->conn->query($sql);
        $data = array();
        $i=1;
        while ($row = $result->fetch_assoc()) {
            $row['serial_number'] = ($page - 1) * $itemsPerPage + $i;
            $data[] = $row;
            $i++;
        }

        $totalItemsQuery = "SELECT COUNT(*) AS total 
                            FROM `evaluation` AS e 
                            WHERE e.evaluation_on IS NOT NULL";
        $totalItemsResult = mysqli_query($this->conn, $totalItemsQuery);
        $totalItems = mysqli_fetch_assoc($totalItemsResult)['total'];


        $response = [
            'data' => $data,
            'totalItems' => $totalItems
        ];

        return $response;
    }
    
    //===============================================================================================================================================

    public function evaluationSheet() {
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $studentId = $_GET['student_id'];

        $itemsPerPage = 10; // Number of items to display per page
        $offset = ($page - 1) * $itemsPerPage;

        $sql = "SELECT q.imageFile, q.type, a.content, a.pronunciation, a.student_id, a.oral_fluency, a.totalScore,q.mp4File as Q_audio, a.mp4File as S_audio, a.userAnswer, q.question, q.solution, a.additional_words, a.missed_words FROM answering AS a, question AS q WHERE q.question_id = a.question_id AND a.student_id = $studentId";
        $result = $this->conn->query($sql);
        $data = array();
        $word_set_1 = array();
        //$word_set_2 = array();

        $i=1;
        while ($row = $result->fetch_assoc()) {
            $row['serial_number'] = ($page - 1) * $itemsPerPage + $i;
            $data[] = $row;
            $i++;
        }

        $totalItemsQuery = "SELECT COUNT(*) as total FROM answering AS a, question AS q WHERE q.question_id = a.question_id AND a.student_id = $studentId";
        $totalItemsResult = mysqli_query($this->conn, $totalItemsQuery);
        $totalItems = mysqli_fetch_assoc($totalItemsResult)['total'];

        
        //$additional_words = array_values($word_set_1);
        //$missed_words = array_values(unserialize($word_set_2));

        $response = [
            'data' => $data,
            'totalItems' => $totalItems,
            //'additional_words1' => $additional_words,
            //'missed_words' => $missed_words
        ];

        return $response;
        $page=0;
    }
    
}
?>
