<?php

class AnsweringModel
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }
    
//===============================================================================================================================================    

    public function Insert($voice, $audioFile, $question_id, $student_id, $content, $word_set_1, $word_set_2){

        try{
            $word_set_1 = mysqli_real_escape_string($this->conn, $word_set_1);
            $word_set_2 = mysqli_real_escape_string($this->conn, $word_set_2);

            $sql = "INSERT INTO answering (question_id, student_id, mp4File, userAnswer, content, additional_words, missed_words) 
                VALUES ($question_id, $student_id, '$audioFile', '$voice', '$content', '$word_set_1', '$word_set_2')";

    

            if ($this->conn->query($sql) === TRUE) {
                $response['success'] = true;
                $response['message'] = "data updated successfully!";
            } else {
                $response['success'] = false;
                $response['message'] = "data updataion failed. Please try again.";
            }
            
        }catch (Exception $e) {
            // Handle database connection or query errors here
            $response['success'] = false;
            $response['message'] = "Error: " . $e->getMessage();
        }

        return $response;

    }

//===============================================================================================================================================

   


//===============================================================================================================================================




    

}
?>
