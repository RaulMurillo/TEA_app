<?php
header('Access-Control-Allow-Origin: *');
require_once 'db_function.php';
$db = new DBFunctions();
$response = array("error" => false);

if (isset($_POST['Tutor']) && isset($_POST['Nombre_grupo'])) {

    $tutor = $_POST['Tutor'];
    $group = $_POST['Nombre_grupo'];

    if(	$db->getGroupbyName($group)==FALSE){
        if(	$db->getTutorById($tutor)!=FALSE){
            $grupo=$db->createGroup($group, $tutor);
            if($grupo!=false){
                $response["msg"]="Creada correctamente";
                $response["grupo"] = $grupo;
                echo json_encode($response,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES );  
            }
            else{
            http_response_code(400);
            $response["error"] = TRUE;
            $response["error_msg"]="Error inesperado";
            echo json_encode($response,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES );  
            }
            
	}
	else{
        http_response_code(400);
		$response["error"]=TRUE;
		$response["error_msg"]="El tutor no existe ";
		echo json_encode($response,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES );
	}
}
	else{
        http_response_code(400);
		$response["error"]=TRUE;
		$response["error_msg"]="El nombre no esta disponible ";
		echo json_encode($response,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES );
	}

} else {
    
    $response["error_msg"] = "faltan campos";
    http_response_code(400);
    $response["error"] = true;
    echo json_encode($response);
}
