<?php
require_once 'db_function.php';
$db = new DBFunctions();
$response =array ("error"=>FALSE);
if(  isset($_POST['Nino'])&& isset($_POST['Tutor'])) {
	$nino =$_POST['Nino'];
	$tutor =$_POST['Tutor'];
	$user_nino=$db->getNinoById($nino);
	if($user_nino!=FALSE){
		$user_tutor=$db->getTutorById($tutor);
		if($user_tutor!=FALSE){
			if($user_nino["Id_tutor_principal"]!=$tutor){
				$tutoria=$db->getTutoriaTutorNino($tutor,$nino);
				if($tutoria!=FALSE){
					if($db->delTutoria($tutor, $nino))
					
					$response["error_msg"]="Separados correctamente";
					else
					$response["error_msg"]="Error inesperado";

					echo json_encode($response);
				}
				else{
					$response["error"]=TRUE;
					$response["error_msg"]="El nino y el tutor no estan relacionados ";
					echo json_encode($response);
				}
			}
			else{
				$response["error"]=TRUE;
				$response["error_msg"]="No puedes separar un nino de su tutor principal ";
				echo json_encode($response);
			}
		
	}
		else{
			$response["error"]=TRUE;
			$response["error_msg"]="El tutor no existe ";
			echo json_encode($response);
		}
	}
	else{
		$response["error"]=TRUE;
		$response["error_msg"]="El nino no existe ";
		echo json_encode($response);
	}

}

else{
	$response["error"]=TRUE;
	$response["error_msg"]="falta algun parametro";
	echo json_encode($response);
}

?>



