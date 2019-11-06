<?php
require_once 'db_function.php';
$db = new DBFunctions();
$response = array("error" => false);
//if (isset($_POST['user_pass']) && isset($_POST['email']) && isset($_POST['ninoId'])) {
if (isset($_POST['contrasena']) && isset($_POST['email'])) {

    $email = $_POST['email'];
    $pass = $_POST['contrasena'];
    // TO-DO: Similar as following
    /**
     * $user = $db->getNinoEmailPass($email, $pass);
     * if ($user != false) {   // Should it be !=null ??
     *     $response["error"] = false; // This is default, maybe unnecessary
     *     $response["user"]["Usuario"] = $user["Usuario"];
     *     $response["user"]["email"] = $user["email"];
     *     $response["user"]["telefono"] = $user["telefono"];
     *     echo json_encode($response);
     * } else {
     *     $response["error"] = true;
     *     $response["error_msg"] = "email o contrasena incorrectos";
     *     echo json_encode($response);
     * }
     */
} else {
    $response["error"] = true;
    $response["error_msg"] = "Son necesarios email y contrasena";
    echo json_encode($response);
}
