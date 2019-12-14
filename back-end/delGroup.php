<?php
header('Access-Control-Allow-Origin: *');
require_once 'db_function.php';
$db = new DBFunctions();
$response =array ("error"=>FALSE);
if(  isset($_POST['id_group']) && isset($_POST['Tutor'])) {
	$group =$_POST['id_group'];
	$id_tutor =$_POST['Tutor'];
	$user_tutor = $db->getTutorById($id_tutor);
	if($user_tutor != FALSE){
		$aux=$db->getGroup($group);
		if(	$aux!=FALSE && $aux["id_tutor"] ==$id_tutor ){

			if($db->delGroup($group))		
				$response["msg"]="Eliminada correctamente";
			else{
			$response["error_msg"]="Error inesperado";
			http_response_code(400);
				$response["error"] = TRUE;
				}
				echo json_encode($response,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES );
		
	}
		else{
			http_response_code(400);
			$response["error"]=TRUE;
			$response["error_msg"]="El grupo no existe o el tutor no es el propietario";
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
	$response["error_msg"]="falta algun parametro";
	echo json_encode($response,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES );
}

?>



