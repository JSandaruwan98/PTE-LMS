<?php

class FetchAndDisplay
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }
    
//===============================================================================================================================================    

    public function fetchAnsweringData($question_id){

        $sql = "SELECT a.*, q.solution, s.name FROM answering AS a, student AS s, question AS q  WHERE a.question_id = $question_id AND s.student_id = a.student_id AND q.question_id = a.question_id";
        $result = $this->conn->query($sql);
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }


        return $data;

    }

//===============================================================================================================================================

    


//===============================================================================================================================================




    

}
?>
