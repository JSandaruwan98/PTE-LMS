<?php

class SaveAudioModel
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

//===============================================================================================================================================    

    public function save_audio($audio){

        $uploadDirectory = '../../';
        $audioFile = '../admin/audio/audio-' . date('YmdHis') . '.wav';
        $filename = $uploadDirectory . $audioFile;

        move_uploaded_file($audio, $filename);

        $uploadDirectory1 = '.';
        $audioFile1 = $uploadDirectory1 . 'recording.wav';
        
        copy($filename, $audioFile1);
        

        $response['message'] = "success";
        $response['audioFile1'] = $audioFile;
        $response['audioFile2'] = $audioFile1;

        
        
        return $response;
    }

//===============================================================================================================================================

   


//===============================================================================================================================================




    

}
?>
