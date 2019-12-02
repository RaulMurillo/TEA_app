<?php
header('Access-Control-Allow-Origin: *');
require_once 'db_function.php';
$db = new DBFunctions();
$response =array ("error"=> FALSE);

if(  isset($_POST['id_kid']) && isset($_POST['id_tutor'])) {
    $id_kid = $_POST['id_kid'];
    $id_tutor = $_POST['id_tutor'];
    $estado = "PENDING";
    //comprobamos que exista el niño
	$user_nino = $db->getNinoById($id_kid);
    if($user_nino != FALSE){
        $user_tutor = $db->getTutorById($id_tutor);
		if($user_tutor != FALSE){
            $tutoria = $db->getTutoriaTutorNino($id_tutor,$id_kid);
            if($tutoria == FALSE){
                $tutoria = $db->createTutoria($id_tutor,$id_kid,$estado);
                $response["error"] = FALSE;
                $response["tutoria"] = $tutoria;
			    echo json_encode($response);
            }
            else{
                $response["error"] = TRUE;
			    $response["error_msg"] = "Ya existe una relacion de tutor entre este tutor y niño";
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
