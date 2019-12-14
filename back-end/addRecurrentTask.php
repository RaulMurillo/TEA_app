<?php
header('Access-Control-Allow-Origin: *');
require_once 'db_function.php';
require_once 'validation/AddRecurrentTaskValidador.php';

$db = new DBFunctions();

$validador = new AddRecurrentTaskValidador();

if (!$validador->validar($_POST)) {
    $response["error_msg"] = "faltan campos";
    http_response_code(400);
    $response["error"] = true;
    echo json_encode($response,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
    die;
}

// Obtener campos
$id_dia = $_POST['Dia'];
$tini = $_POST['Tini'];
$tfin = $_POST['Tfin'];
$path_picto = $_POST['Path_picto'];
$id_tutor = $_POST['Tutor'];
$id_nino = $_POST['Nino'];
$text = $_POST['Text'];
$tipo = $_POST['Tipo'];
$enlace = $_POST['Enlace'];
$periodo = $_POST['Periodo'];

// Comprobar la existencia del niño
if (!$db->getNinoById($id_nino)) {
    http_response_code(400);
    $response = [
        "error" => true,
        "error_msg" => "El niño no existe",
    ];
    echo json_encode($response,JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES );
    die;
}

// Comprobar la existencia del tutor
$user_tutor = $db->getTutorById($id_tutor);
if (!$user_tutor) {
    http_response_code(400);
    $response = [
        "error" => true,
        "error_msg" => "El tutor no existe",
    ];
    echo json_encode($response,JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    die;
}

// Comprobar la existencia de colisiones
if ($db->comprobarColisionesTareaRecurrente($id_nino, $id_dia, $tini, $tfin)) {
    http_response_code(400);
    $response = [
        "error" => true,
        "error_msg" => "Existen colisiones con otras tareas recurrentes",
    ];
    echo json_encode($response,JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES );
    die;
}

$task = $db->storeRecurrentTask(
    $tini, $tfin, $path_picto, $id_tutor, $id_nino, $text, $id_dia, $tipo, $enlace, $periodo
);

if (!$task) {
    http_response_code(400);
    $response = [
        "error" => true,
        "error_msg" => "Error desconocido",
    ];
    echo json_encode($response,JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    die;
}

$response["error"] = false;
$response["task"] = $task;
echo json_encode($response,JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES );
