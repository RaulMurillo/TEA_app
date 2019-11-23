<?php
require_once 'db_function.php';
$db = new DBFunctions();
$response =array ("error"=>FALSE);
if(  isset($_POST['Task'])) {
	$task =$_POST['Task'];
	$tarea=$db->getTaskById($task);
	if($tarea!=FALSE){
		if($db->delTask($task))		
			$response["error_msg"]="Eliminada correctamente";
		else
		$response["error_msg"]="Error inesperado";
			echo json_encode($response);
	}
	
	else{
		$response["error"]=TRUE;
		$response["error_msg"]="La tarea no existe ";
		echo json_encode($response);
	}
}

else{
	$response["error"]=TRUE;
	$response["error_msg"]="falta algun parametro";
	echo json_encode($response);
}

?>



