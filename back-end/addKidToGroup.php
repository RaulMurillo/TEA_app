<?php
require_once 'db_function.php';
$db = new DBFunctions();
$response =array ("error"=> FALSE);

if(  isset($_POST['id_kid']) && isset($_POST['id_tutor']) && isset($_POST['id_group'])) {
    $id_kid = $_POST['id_kid'];
    $id_tutor = $_POST['id_tutor'];
    $id_group = $_POST['id_group'];
    //comprobamos que exista el niño
	$user_nino = $db->getNinoById($id_kid);
    if($user_nino != FALSE){
        $user_tutor = $db->getTutorById($id_tutor);
		if($user_tutor != FALSE){
            $aux=$db->getGroup($id_group);
			if($aux && $aux["id_tutor"] == $id_tutor ){
            $relation = $db->getTutoriaTutorNino($id_tutor, $id_kid);
            if ($relation != null && $relation['state'] == 'ACCEPTED'){
                $tutoria = $db->getGroupKidGrupo($id_kid,$id_group);
                if($tutoria == FALSE){
                    $pertenencia = $db->unionGrupo($id_kid,$id_group);
                    $response["error"] = FALSE;
                    $response["tutoria"] = $pertenencia;
                    echo json_encode($response);
                }
                else{
                    $response["error"] = TRUE;
                    $response["error_msg"] = "Ya se encuentra en el grupo";
                    echo json_encode($response);
                }
            }
            else{
                $response["error"] = TRUE;
                $response["error_msg"] = "El tutor no tiene relacion de tutoria aceptada con el niño ";
                echo json_encode($response);
            }
        }
        else{
            $response["error"]=TRUE;
                $response["error_msg"]="No existe el grupo o el tutor no es el propietario";
                echo json_encode($response);

        }
        }
        else{
            $response["error"] = TRUE;
			$response["error_msg"] = "El tutor no existe ";
			echo json_encode($response);
        }
    }
    else{
        $response["error"] = TRUE;
        $response["error_msg"] = "El nino no existe ";
        echo json_encode($response);
    }
}
else{
     $response["error"] = TRUE;
     $response["error_msg"] = "variable erroneas";
     echo json_encode($response);
}