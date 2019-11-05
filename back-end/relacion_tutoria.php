<?php
require_once 'db_function.php';
$db = new db_functions();
$response =array ("error"=>FALSE);
if(  isset($_POST['nino'])&& isset($_POST['tutor'])) 
{


	$nino =$_POST['nino'];
	$tutor =$_POST['tutor'];
	$Usuarionino=$db->getninoporID($nino);
	if($Usuarionino!=false){
		$Usuariotutor=$db->gettutorporID($tutor);
		if($Usuariotutor!=false){
			if($Usuarionino[tutorprincipal]!=$tutor){
				$tutoria=$db->gettutoriaportutorynino($tutor,$nino);
				if($tutoria!=false){
					eliminartutoriaportutorynino($tutor,$nino);
					$response["error_msg"]="separados correctamente";
					echo json_encode($response);}
				else{$response["error"]=TRUE;
				$response["error_msg"]="el nino y el tutor no estan relacionados ";
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
		$response["error_msg"]="el tutor no existe ";
		echo json_encode($response);
		}
	}
	else{
	$response["error"]=TRUE;
	$response["error_msg"]="el nino no existe ";
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



