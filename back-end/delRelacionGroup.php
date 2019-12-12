<?php
header('Access-Control-Allow-Origin: *');
require_once 'db_function.php';
$db = new DBFunctions();
$response =array ("error"=>FALSE);
if(  isset($_POST['Nino'])&& isset($_POST['Tutor']) && isset($_POST['Grupo'])) {
	$id_kid =$_POST['Nino'];
	$id_group =$_POST['Grupo'];
	$tutor =$_POST['Tutor'];
	$user_nino=$db->getNinoById($id_kid);
	if($user_nino!=FALSE){
		$user_tutor=$db->getTutorById($tutor);
		if($user_tutor!=FALSE){
			$aux=$db->getGroup($id_group);
			if($aux && $aux["id_tutor"] == $tutor ){

				if($db->getGroupKidGrupo($id_kid,$id_group)){

					if($db->delKidGroup($id_group,$id_kid))
					
					$response["msg"]="Separados correctamente";
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
					$response["error_msg"]="No pertenece al grupo ";
					echo json_encode($response,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES );
				}
			}
			else{
				http_response_code(400);
				$response["error"]=TRUE;
					$response["error_msg"]="No existe el grupo o el tutor no es el propietario";
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



