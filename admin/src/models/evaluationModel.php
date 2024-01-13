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

    public function ticketCheck($ticketId, $comment, $status, $rating) {
            
        $sql = "UPDATE ticket SET comments = '$comment', status = '$status', rating = '$rating'  WHERE ticket_no = $ticketId";
        if ($this->conn->query($sql) === TRUE) {
            $response['success'] = true;
            $response['message'] = "data updated successfully!";
        } else {
            $response['success'] = false;
            $response['message'] = "data updataion failed. Please try again.";
        }
        return $response;
        
    }
    

}
?>
