<?php
header('Access-Control-Allow-Origin: *');
require_once 'db_function.php';
$db = new DBFunctions();
$response =array ("error"=>FALSE);
if(  isset($_POST['id_subtask'])) {
	$subtask =$_POST['id_subtask'];
	if($db->getSubTaskbyId($subtask)){
		if($db->delSubTask($subtask))		
			$response["error_msg"]="Eliminada correctamente";
		else
		$response["error_msg"]="Error inesperado";
			echo json_encode($response);
	}
	
	else{
		$response["error"]=TRUE;
		$response["error_msg"]="La subtarea no existe ";
		echo json_encode($response);
	}
}

else{
	$response["error"]=TRUE;
	$response["error_msg"]="falta algun parametro";
	echo json_encode($response);
}

?>



