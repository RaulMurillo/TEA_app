<?php
require_once 'db_function.php';
$db = new DBFunctions();
$response = array("error" => FALSE);
if (isset($_POST['contrasena']) && isset($_POST['email'])) {

    $email = $_POST['email'];
    $contra = $_POST['Contrasena'];
    $user = $db->getTutorEmailPass($email, $contra);
    if ($user != FALSE) {
        $response["error"] = FALSE;
        $response["user"]["Usuario"] = $user["Usuario"];
        $response["user"]["email"] = $user["email"];
        $response["user"]["telefono"] = $user["telefono"];
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