<?php
header('Access-Control-Allow-Origin: *');
require_once 'db_function.php';
$db = new DBFunctions();
$response = array("error" => false);

if (isset($_POST['date']) && isset($_POST['id_nino']) ) {
    $dia=$_POST['date'];
    $id_nino=$_POST['id_nino'];
    if (!$db->getNinoById($id_nino)) {
        $response["error"] = true;
        $response["error_msg"] = "El niño no existe";
        echo json_encode($response);
    } else {
        $tareas=$db->getTaskDateKid($dia,$id_nino);
        $response["Grupos"]=$tareas;
        echo json_encode($response);
    }


} else {
    
    $response["error_msg"] = "faltan campos";
    $response["error"] = true;
    echo json_encode($response);
}
