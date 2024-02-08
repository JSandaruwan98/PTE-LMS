<?php
include '../config/database.php';
include '../models/saveAudioModel.php';
include '../models/voiceToTestModel.php';
include '../models/sentenceCompareModel.php';
include '../models/answeringModel.php';
include '../models/aiModel.php';

$save_audio = new SaveAudioModel($conn);
$voice_to_test = new VoiceToTestModel();
$sentence_compare = new SentenceCompareModel();
$answering = new AnsweringModel($conn);
$ai_model = new AIModel();


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

        $count_1 =  count($result['additional_words']);
        $count_2 =  count($result['missed_words']);

        $response = $word_set_2;

        $count = ($count_1 + $count_2)/2;

        
        $content = 0;
        if($count > 9){
            $content = 0;
        }elseif($count >= 7){
            $content = 1;
        }elseif($count = 6){
            $content = 2;
        }elseif($count >= 4){
            $content = 3;
        }elseif($count >= 2){
            $content = 4;
        }elseif($count >= 0){
            $content = 5;
        }


        $response = $answering->Insert($voice, $audioFile, $question_id, $student_id, $content, $word_set_1, $word_set_2);


    }elseif($_POST['task'] == 'ai_analysis'){
      
        $voice = $voice_to_test->voiceToTest(); //voice to test convert

        //Assigned the variables
        $audioFile = $_POST['audioFile'];
        $Solution = $_POST['Solution'];
        $question_id = $_POST['question_id'];
        $student_id = $_POST['student_id'];
        $key_words = $_POST['key_words'];

        $response = $key_words;

        if($_POST['type'] == 'Answer Short Question'){

            $Question ="Question : `".$key_words."`  and Answer: `".$voice."`  this answer is only give a correct or incorrect not any other";
            $result = $ai_model->AiComparison($Question);

            if (stripos($result, 'incorrect') !== false) {
                $value = 0; // Set $value to 1
            } elseif (stripos($result, 'correct') !== false) {
                $value = 1; // Set $value to 0 if 'incorrect' is found
            }

        }elseif($_POST['type'] == 'Describe Image' || $_POST['type'] == 'Re-tell Lecture'){

            $Question = "`".$voice."` and the key word  `".$key_words."` give only overall precentage of include the key words";
            $value = $ai_model->AiComparison($Question);
        }


        $response = $answering->Insert($voice, $audioFile, $question_id, $student_id, $value, NAN, NAN);


    }

}

header('Content-Type: application/json');
echo json_encode($response);

$conn->close();
?>
