<?php
require_once 'db_function.php';
$db = new db_functions();
$response =array ("error"=>FALSE);
if(  isset($_POST['nino'])&& isset($_POST['tutor'])) 
{


	$nino =$_POST['Nino'];
	$tutor =$_POST['Tutor'];
	$Usuarionino=$db->getNinopId($nino);
	if($Usuarionino!=false){
		$Usuariotutor=$db->getTutorId($tutor);
		if($Usuariotutor!=false){
			if($Usuarionino["TutorPrincipal"]!=$tutor){
				$tutoria=$db->getTutoriaTutorNino($tutor,$nino);
				if($tutoria!=false){
					delTutoriaTutorNino($tutor,$nino);
					$response["error_msg"]="Separados correctamente";
					echo json_encode($response);}
				else{$response["error"]=TRUE;
				$response["error_msg"]="El nino y el tutor no estan relacionados ";
				echo json_encode($response);
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

else
{
$response["error"]=TRUE;
$response["error_msg"]="falta algun parametro";
echo json_encode($response);
}
?>



