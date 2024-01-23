<?php

class ExamSpaceModel
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

//===============================================================================================================================================    

    public function questionDisplay($perPage, $offset, $test_id) {
            
        try{

            // Fetch data from the database with pagination
            $sql = "SELECT type, question, solution, imageFile, question_id, mp4File, key_words FROM question WHERE test_id = $test_id LIMIT $offset, $perPage";
            $sqlCount = "SELECT COUNT(*) AS Count FROM question WHERE test_id = $test_id";
            $result = $this->conn->query($sql);
            $count = $this->conn->query($sqlCount)->fetch_assoc();

            $data = array();

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $data[] = array(
                        'type' => $row['type'],
                        'question' => $row['question'],
                        'solution' => $row['solution'],
                        'imageFile' => $row['imageFile'],
                        'question_id' => $row['question_id'],
                        'key_words' => $row['key_words'],
                        'audio' => $row['mp4File'],
                    );
                }
            }

            
        $response = [
            'data' => $data,
            'totalItems' => $count
        ];

        }catch(Exception $e){
            // Handle database connection or query errors here
            $response['success'] = false;
            $response['message'] = "Error: " . $e->getMessage();
        }

        

        return  $response;
    }

//===============================================================================================================================================

   


//===============================================================================================================================================




    

}
?>
