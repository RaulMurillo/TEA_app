<?php
header('Access-Control-Allow-Origin: *');
require_once 'db_function.php';
$db = new DBFunctions();
$response = array("error" => false);
if (isset($_POST['ninoId']) && isset($_POST['tutorId'])) {
    $ninoId = $_POST['ninoId'];
    $tutorId = $_POST['tutorId'];
    $istutor = $db->getTutoriaTutorNino($tutorId, $ninoId);
    if($istutor != null && $istutor['Estado_solicitud'] == 'ACCEPTED') {
        $nino = $db->getNinoById($ninoId);
        $response["error"] = false;
        $response["nino"] = $nino;
        echo json_encode($response);
    }
    else{
        $response["error"] = true;
        $response["error_msg"] = "Es necesario ser el tutor del nino para ver su perfil";
        echo json_encode($response);

    }
} else {
    $response["error"] = true;
    $response["error_msg"] = "Es necesario el id del Nino y del tutor";
    echo json_encode($response);
}