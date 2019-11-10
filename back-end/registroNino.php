<?php
require_once 'db_function.php';
$db = new DBFunctions();
$response = array("error" => false);

$fecha_nacimiento = null;
if (isset($_POST['FechaNacimiento'])) {
    $fecha_nacimiento = $_POST['FechaNacimiento'];
}

if (isset($_POST['Nick']) && isset($_POST['Nombre']) && isset($_POST['Apellido']) && isset($_POST['Tutor'])) {
    $nick = $_POST['Nick'];
    //$fecha_nacimiento = $_POST['FechaNacimiento'];
    $nombre = $_POST['Nombre'];
    $apellido = $_POST['Apellido'];
    $id_tutor = $_POST['Tutor'];

    if ($db->existeNick($nick)) {
        $response["error"] = true;
        $response["error_msg"] = "El Nick ya existe";
        echo json_encode($response);
    } else {
        $user_tutor = $db->getTutorById($id_tutor);
        if ($user_tutor == false) {
            $response["error"] = true;
            $response["error_msg"] = "El tutor no existe";
            echo json_encode($response);
        } else {
            $user = $db->storeNino($nick, $nombre, $apellido, $id_tutor, $fecha_nacimiento);
            if ($user) {
                $response["error"] = false;
                $response["user"] = $user;
                echo json_encode($response);
            } else {
                $response["error"] = true;
                $response["error_msg"] = "error desconocido";
                echo json_encode($response);
            }
        }
    }

} else {
    if (isset($_POST['Tutor'])) {
        $response["error_msg"] = "falta .$fecha_nacimiento.";
    } else {
        $response["error_msg"] = "falta otro";
    }

    $response["error"] = true;

    echo json_encode($response);
}
