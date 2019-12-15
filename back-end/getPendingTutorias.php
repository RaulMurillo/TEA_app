<?php
header('Access-Control-Allow-Origin: *');
require_once 'db_function.php';
$db = new DBFunctions();
$response =array ("error"=>FALSE);
if(  isset($_POST['id_tutor'])) 
{
    $idTutor = $_POST['id_tutor'];
    //se le enviaran todas las tutorias pendientes en las que el tutor sea el tutor main
    $tutorias=$db->getTutorias($idTutor);
    if($tutorias)
    {
        $response["error"] = false;
        $response["turorias"] = $tutorias;
        echo json_encode($response,JSON_UNESCAPED_UNICODE);
    }
    else{
        http_response_code(400);
        $response["error"] = true;
        $response["error_msg"] = "No tienes niños en estado pendiente a tu cargo o no existes";
        echo json_encode($response,JSON_UNESCAPED_UNICODE);
    }
}
else
{
    http_response_code(400);
    $response["error"] = true;
    $response["error_msg"] = "Parametros incorrectos";
    echo json_encode($response,JSON_UNESCAPED_UNICODE);
}