<?php

require_once 'db_function.php';

$db = new DBFunctions();
$response = array("error" => FALSE);

if (isset($_POST['contrasena']) && isset($_POST['email'])) {
    $email = $_POST['email'];
    $contra = $_POST['contrasena'];
    $user = $db->getTutorEmailPass($email, $contra);
    if ($user != FALSE) {
        
    
        
        $response["error"] = FALSE;
        $response["tutor"]["idTutor"] = $user["Id_tutor"];
        $response["tutor"]["email"] = $user["Email"];
        $response["tutor"]["nombre"] = $user["Nombre"];
        $response["tutor"]["apellidos"] = $user["Apellidos"];
        $response["tutor"]["fechaNacimiento"] = $user["Fecha_nacimiento"];
        $response["tutor"]["tipoTutor"] = $user["Tipo_tutor"];
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