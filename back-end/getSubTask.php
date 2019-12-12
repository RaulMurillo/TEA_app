<?php
header('Access-Control-Allow-Origin: *');
require_once 'db_function.php';
$db = new DBFunctions();
$response = array("error" => false);

if (isset($_POST['id_task'])) {
    $tarea=$_POST['id_task'];
    $Otarea= $db->getTaskById($tarea);
    if (!$Otarea) {
        $response["error"] = true;
        $response["error_msg"] = "La tarea no existe";
        echo json_encode($response);
    } else {
        $subtareas=$db->getSubTask($tarea);
        $response["subtareas"]=$subtareas;
        echo json_encode($response);
    }


} else {
    
    $response["error_msg"] = "faltan campos";
    $response["error"] = true;
    echo json_encode($response);
}
