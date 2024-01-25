<?php

class DiscussionModel
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }
    
//===============================================================================================================================================    

    public function discussion($question_id){

        $sql = "SELECT a.mp4File,a.attempted_on, s.name FROM answering AS a, student AS s  WHERE a.question_id = $question_id AND s.student_id = a.student_id";
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
