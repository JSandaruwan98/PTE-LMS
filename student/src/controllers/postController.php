<?php
include '../config/database.php';
include '../models/saveVideoModel.php';

$save_audio = new SaveVideoModel($conn);


if($_SERVER["REQUEST_METHOD"] == "POST"){
    if (isset($_POST['task'])) {
        $task = $_POST['task'];
    }

    if($_POST['task'] == 'save_audio'){
        $audio = $_FILES['audio']['tmp_name'];

        $response = $save_audio->save_audio($audio);
        //$response = $audio;

    }elseif ($task === 'checkbox') {
        $featureEnabled = ($_POST['featureEnabled'] === 'true') ? 1 : 0; // Convert to 1 or 0
        $id = $_POST['id'];
        $table = $_POST['table'];
        $idName = $_POST['idname'];

        $response = $checkbox->checkboc($table, $featureEnabled, $idName, $id);

    }

}

header('Content-Type: application/json');
echo json_encode($response);

$conn->close();
?>
