<?php
header('Access-Control-Allow-Origin: *');
require_once 'db_function.php';
$db = new DBFunctions();
$response =array ("error"=> FALSE);

if(  isset($_POST['nick']) && isset($_POST['id_tutor'])) {
    $kid = $_POST['nick'];
    $id_tutor = $_POST['id_tutor'];
    $estado = "PENDING";
    //comprobamos que exista el niño
	$user_nino = $db->getNinoByNick($kid);
    if($user_nino != FALSE){
        $user_tutor = $db->getTutorById($id_tutor);
		if($user_tutor != FALSE){
            $tutoria = $db->getTutoriaTutorNino($id_tutor,$user_nino["id_kid"]);
            if($tutoria == FALSE){
                $tutoria = $db->createTutoria($id_tutor,$user_nino["id_kid"],$estado);
                $response["error"] = FALSE;
                $response["tutoria"] = $tutoria;
			    echo json_encode($response,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES );
            }
            else{
                http_response_code(400);
                $response["error"] = TRUE;
			    $response["error_msg"] = "Ya existe una relacion de tutor entre este tutor y niño";
			    echo json_encode($response,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES );
            }
        }
        else{
            http_response_code(400);
            $response["error"] = TRUE;
			$response["error_msg"] = "El tutor no existe ";
			echo json_encode($response,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES );
        }
    }
    else{
        http_response_code(400);
        $response["error"] = TRUE;
        $response["error_msg"] = "El nino no existe ";
        echo json_encode($response,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES );
    }
}
else{
     http_response_code(400);
     $response["error"] = TRUE;
     $response["error_msg"] = "variable erroneas";
     echo json_encode($response,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES );
}
