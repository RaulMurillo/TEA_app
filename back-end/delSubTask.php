<?php
header('Access-Control-Allow-Origin: *');
require_once 'db_function.php';
$db = new DBFunctions();
$response =array ("error"=>FALSE);
if(  isset($_POST['id_subtask'])) {
	$subtask =$_POST['id_subtask'];
	if($db->getSubTaskbyId($subtask)){
		if($db->delSubTask($subtask))		
			$response["msg"]="Eliminada correctamente";
		else{
			http_response_code(400);
		$response["error_msg"]="Error inesperado";}
		echo json_encode($response,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES );
	}
	
	else{
		http_response_code(400);
		$response["error"]=TRUE;
		$response["error_msg"]="La subtarea no existe ";
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



