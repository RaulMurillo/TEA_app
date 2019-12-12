<?php
header('Access-Control-Allow-Origin: *');
require_once 'db_function.php';
$db = new DBFunctions();
$response =array ("error"=>FALSE);
if(  isset($_POST['Task'])) {
	$task =$_POST['Task'];
	$tarea=$db->getTaskById($task);
	if($tarea!=FALSE){
		if($db->delTask($task))		
			$response["msg"]="Eliminada correctamente";
		else{
		http_response_code(400);
		$response["error"]=TRUE;
		$response["error_msg"]="Error inesperado";}
		echo json_encode($response,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES );
	}
	
	else{
		http_response_code(400);
		$response["error"]=TRUE;
		$response["error_msg"]="La tarea no existe ";
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



