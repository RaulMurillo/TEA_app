<?php
header('Access-Control-Allow-Origin: *');
require_once 'db_function.php';
$db = new DBFunctions();
$response = array("error" => false);

if (isset($_POST['Tini']) && isset($_POST['Tfin']) && isset($_POST['Path_picto'])&& isset($_POST['Tarea'])
         && isset($_POST['Tutor'])&& isset($_POST['Nino']) && isset($_POST['Text'])&& isset($_POST['Dia'])
         && isset($_POST['Tipo'])&& isset($_POST['Enlace'])) {
    $id_dia=$_POST['Dia'];
    $tini = $_POST['Tini'];
    $tfin = $_POST['Tfin'];
    $path_picto = $_POST['Path_picto'];
    $id_tutor = $_POST['Tutor'];
    $id_nino = $_POST['Nino'];
    $text = $_POST['Text'];
    $id_tarea = $_POST['Tarea'];
    $tipo = $_POST['Tipo'];
    $enlace = $_POST['Enlace'];

    if (!$db->getNinoById($id_nino)) {
        $response["error"] = true;
        $response["error_msg"] = "El niño no existe";
        echo json_encode($response);
    } else {
        $user_tutor = $db->getTutorById($id_tutor);
        if (!$user_tutor) {
            $response["error"] = true;
            $response["error_msg"] = "El tutor no existe";
            echo json_encode($response);
        } else {
            //existe dia
           if($db->getTaskById($id_tarea)){
                if(!$db->collisionsUpdate($id_dia,$tini,$tfin,$id_tarea)){
                    $task = $db->updateTask( $tini,$tfin,$path_picto,$id_tutor,$id_nino,$text,$id_tarea,$tipo,$enlace);
                    if ($task) {
                        $response["error"] = false;
                        $response["task"] = $task;
                        echo json_encode($response);
                    }
                    else {
                        $response["error"] = true;
                        $response["error_msg"] = "Error desconocido";
                        echo json_encode($response);
                    }
                }
                else{
                    $response["error"] = true;
                    $response["error_msg"] = "Existen colisiones colisiones";
                    echo json_encode($response);

                }
            }
            else{
                $response["error"] = true;
                $response["error_msg"] = "No existe el dia";
                echo json_encode($response);}
        }
    }

} else {
    
    $response["error_msg"] = "faltan campos";
    $response["error"] = true;
    echo json_encode($response);
}
