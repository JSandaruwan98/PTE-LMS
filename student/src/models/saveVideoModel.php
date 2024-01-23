<?php

class SaveVideoModel
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

//===============================================================================================================================================    

    public function save_audio($audio){

        $audioFile = '../../../admin/audio/audio-' . date('YmdHis') . '.wav';

        move_uploaded_file($audio, $audioFile);

        $uploadDirectory1 = '.';
        $audioFile1 = $uploadDirectory1 . 'recording.wav';
        
        copy($audioFile, $audioFile1);
        

        $response['message'] = "success";
        $response['audioFile1'] = $audioFile;
        $response['audioFile2'] = $audioFile1;

        
        
        return $response;
    }

//===============================================================================================================================================

   


//===============================================================================================================================================




    

}
?>
