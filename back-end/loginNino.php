<?php
header('Access-Control-Allow-Origin: *');
require_once 'db_function.php';
$db = new DBFunctions();
$response = array("error" => false);
if (isset($_POST['ninoId']) && isset($_POST['tutorId'])) {
    $tutorId = $_POST['tutorId'];
    $ninoId = $_POST['ninoId'];
    $relation = $db->getTutoriaTutorNino($tutorId, $ninoId);
    if ($relation != null && $relation['state'] == 'ACCEPTED') { //Aceptado?? BBDD type enum.

        $user = $db->getNinoById($ninoId);
        /*
        $response["error"] = false;
        $response["nino"]["idNino"] = $user["Id_nino"];
        $response["nino"]["idNino"] = $user["Id_nino"];
        $response["nino"]["nick"] = $user["Nick"];
        $response["nino"]["nombre"] = $user["Nombre"];
        $response["nino"]["apellidos"] = $user["Apellido"];
        $response["nino"]["fechaNacimiento"] = $user["Fecha_nacimiento"];
        $response["nino"]["fechaNacimiento"] = $user["Fecha_nacimiento"];
         */
        //echo json_encode($response);
        $response["error"] = false;
        $response["nino"] = $user;
        echo json_encode($response,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES );

    } else {
        $response["error"] = true;
        $response["error_msg"] = "No tienes acceso a ese perfil";
        echo json_encode($response);
    }
} elseif (isset($_POST['nick']) && isset($_POST['tutorId'])) {
    $tutorId = $_POST['tutorId'];
    $kid_nick = $_POST['nick'];
    if(!$db->existeNick($kid_nick)){
        $response["error"] = true;
        $response["error_msg"] = "Nick incorrecto";
        echo json_encode($response,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES );
        exit();
    }

    $ninoId = $db->getKidIdByNick($kid_nick);
    if($ninoId == null){
        $response["error"] = true;
        $response["error_msg"] = "Error inesperado";
        echo json_encode($response,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES );
        exit();
    }

    $relation = $db->getTutoriaTutorNino($tutorId, $ninoId);
    if ($relation != null && $relation['state'] == 'ACCEPTED') {
        $user = $db->getNinoById($ninoId);
        $response["error"] = false;
        $response["nino"] = $user;
        echo json_encode($response,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES );

    } else {
        $response["error"] = true;
        $response["error_msg"] = "No tienes acceso a ese perfil";
        echo json_encode($response,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES );
    }
} else {
    $response["error"] = true;
    $response["error_msg"] = "Parámetros incorrectos";
    echo json_encode($response,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES );
}
