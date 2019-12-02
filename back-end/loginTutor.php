<?php
header('Access-Control-Allow-Origin: *');
require_once 'db_function.php';

$db = new DBFunctions();
$response = array("error" => FALSE);

if (isset($_POST['password']) && isset($_POST['email'])) {
    $email = $_POST['email'];
    $contra = $_POST['password'];
    $user = $db->getTutorEmailPass($email, $contra);
    if ($user != FALSE) {
        
    
        
        $response["error"] = FALSE;
        $response["tutor"]["id_tutor"] = $user["id_tutor"];
        $response["tutor"]["email"] = $user["email"];
        $response["tutor"]["nombre"] = $user["nombre"];
        $response["tutor"]["apellido"] = $user["apellido"];
        $response["tutor"]["fechaNacimiento"] = $user["birth_date"];
        //$response["tutor"]["tipoTutor"] = $user["Tipo_tutor"];
        echo json_encode($response);
       
    } else {
        $response["error"] = TRUE;
        $response["error_msg"] = "usuario o contrasena incorrectos";
        echo json_encode($response);
    }

} else {
    $response["error"] = TRUE;
    $response["error_msg"] = "falta algun parametro";
    echo json_encode($response);
}
?>
