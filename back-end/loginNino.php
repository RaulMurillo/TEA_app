<?php
require_once 'db_function.php';
$db = new DBFunctions();
$response = array("error" => false);
if (isset($_POST['ninoId']) && isset($_POST['tutorId'])) {
    $tutorId = $_POST['tutorId'];
    $ninoId = $_POST['ninoId'];
    $relation = $db->getTutoriaTutorNino($tutorId, $ninoId);
    if ($relation != null && $relation['Estado_solicitud'] == 'Aceptado') { //Aceptado?? BBDD type enum.

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
        echo json_encode($response);

    } else {
        $response["error"] = true;
        $response["error_msg"] = "email o contrasena incorrectos";
        echo json_encode($response);
    }
} else {
    $response["error"] = true;
    $response["error_msg"] = "Son necesarios email y contrasena";
    echo json_encode($response);
}
