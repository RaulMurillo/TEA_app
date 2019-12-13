<?php
header('Access-Control-Allow-Origin: *');
require_once 'db_function.php';
$db = new DBFunctions();
$response =array ("error"=>FALSE);
if(  isset($_POST['id_nino'])&& isset($_POST['id_tutor'])) {
	$nino =$_POST['id_nino'];
	$tutor =$_POST['id_tutor'];
	$user_nino=$db->getNinoById($nino);
	if($user_nino!=FALSE){
		$user_tutor=$db->getTutorById($tutor);
		if($user_tutor!=FALSE){
			if($user_nino["id_main_tutor"]==$tutor){
			
					if($db->delKid($nino))
						$response["msg"]="Eliminado correctamente";
					else{
						http_response_code(400);
						$response["error"]=TRUE;
						$response["error_msg"]="Error inesperado";
					}
					echo json_encode($response,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES ); 
			}
			else{
				http_response_code(400);
				$response["error"]=TRUE;
				$response["error_msg"]="Solo puede eliminarlo su tutor principal ";
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
		$response["error_msg"]="El nino no existe ";
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



