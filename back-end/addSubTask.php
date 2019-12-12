<?php
header('Access-Control-Allow-Origin: *');
require_once 'db_function.php';
$db = new DBFunctions();
$response = array("error" => false);

if (isset($_POST['id_task']) && isset($_POST['text'])&& isset($_POST['path'])&& 
isset($_POST['id_tutor'])&& isset($_POST['orden'])) {
    $task=$_POST['id_task'];
    $texto=$_POST['text'];
    $path=$_POST['path'];
    $tutor = $_POST['id_tutor'];
    $ord = $_POST['orden'];

        $user_tutor = $db->getTutorById($tutor);
        if (!$user_tutor) {
            http_response_code(400);
            $response["error"] = true;
            $response["error_msg"] = "El tutor no existe";
            echo json_encode($response,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES );
        } else {
            $tarea= $db->getTaskById($task);
            if($tarea && $tarea["id_tutor"] == $tutor){
                $subtask=$db->storeSubTask($task,$texto,$path,$ord);
                if ($task) {
                    $response["error"] = false;
                    $response["subtask"] = $subtask;
                    echo json_encode($response,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES );
                }  
            }
            else {
                $response["error_msg"] = "La tarea no existe o el tutor no es el dueño de la tarea";
                http_response_code(400);
                $response["error"] = true;
                echo json_encode($response,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES );
            }
            
        }
    

} else {
    
    $response["error_msg"] = "faltan campos";
    http_response_code(400);
    $response["error"] = true;
    echo json_encode($response,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES );
}
