<?php
require_once 'db_function.php';
$db = new DBFunctions();
$response =array ("error"=>FALSE);
if(isset($_POST['Nino'])) {
	$nino =$_POST['Nino'];
	$user_nino=$db->getTutorById($nino);
	if($user_nino!=FALSE){
		$grupos=$db->getGroupsNino($nino);
		$response["Grupos"]=$grupos;
		echo json_encode($response);
	}

	else{
		$response["error"]=TRUE;
		$response["error_msg"]="No existe el nino";
		echo json_encode($response);
	}
}
else{
	$response["error"]=TRUE;
	$response["error_msg"]="falta algun parametro";
	echo json_encode($response);
}

?>



