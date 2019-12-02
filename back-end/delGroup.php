<?php
require_once 'db_function.php';
$db = new DBFunctions();
$response =array ("error"=>FALSE);
if(  isset($_POST['Id_group']) && isset($_POST['Tutor'])) {
	$group =$_POST['Id_group'];
	$id_tutor =$_POST['Tutor'];
	$user_tutor = $db->getTutorById($id_tutor);
	if($user_tutor != FALSE){
		$aux=$db->getGroup($group);
		if(	$aux!=FALSE && $aux["id_tutor"] ==$id_tutor ){
			$grupo=$db->getGroupKids($group);
			if($grupo==false || count($grupo)== 0){
			if($db->delGroup($group))		
				$response["error_msg"]="Eliminada correctamente";
			else{
			$response["error_msg"]="Error inesperado";
				
				$response["error"] = TRUE;
				}
				echo json_encode($response);
		}
		else{
			$response["error"]=TRUE;
			$response["error_msg"]="El grupo no esta vacio ";
			$response["grupo"]=$grupo;
			echo json_encode($response);
		}
	}
		else{
			$response["error"]=TRUE;
			$response["error_msg"]="El grupo no existe o el tutor no es el propietario";
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
	$response["error_msg"]="falta algun parametro";
	echo json_encode($response);
}

?>


