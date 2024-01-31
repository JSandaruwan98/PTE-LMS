<?php
include '../config/database.php';
include '../models/saveAudioModel.php';
include '../models/voiceToTestModel.php';
include '../models/sentenceCompareModel.php';
include '../models/answeringModel.php';

$save_audio = new SaveAudioModel($conn);
$voice_to_test = new VoiceToTestModel();
$sentence_compare = new SentenceCompareModel();
$answering = new AnsweringModel($conn);


if($_SERVER["REQUEST_METHOD"] == "POST"){
    if (isset($_POST['task'])) {
        $task = $_POST['task'];
    }

    if($_POST['task'] == 'save_audio'){
        $audio = $_FILES['audio']['tmp_name'];

        $response = $save_audio->save_audio($audio);
        //$response = $audio;

    }elseif($_POST['task'] == 'normal_comparison'){
            
        $voice = $voice_to_test->voiceToTest(); //voice to test convert

        //Assigned the variables
        $audioFile = $_POST['audioFile'];
        $Solution = $_POST['Solution'];
        $question_id = $_POST['question_id'];
        $student_id = $_POST['student_id'];

        $result = $sentence_compare->compareSentences($Solution, $voice);

        

        $serialized_additional_words = serialize($result['additional_words']);
        $serialized_missed_words = serialize($result['missed_words']);

        $word_set_1 = implode(', ', $result['additional_words']);
        $word_set_2 = implode(', ', $result['missed_words']);

        $count =  count($result['additional_words']);

        $response = $word_set_2;

        
        $content = 0;
        if($count > 5){
            $content = 0;
        }elseif($count > 4){
            $content = 1;
        }elseif($count > 3){
            $content = 2;
        }elseif($count > 1){
            $content = 3;
        }elseif($count > 0){
            $content = 4;
        }elseif($count > -1){
            $content = 5;
        }


        $response = $answering->Insert($voice, $audioFile, $question_id, $student_id, $content, $word_set_1, $word_set_2);


    }

}

header('Content-Type: application/json');
echo json_encode($response);

$conn->close();
?>
