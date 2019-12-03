<?php
header('Access-Control-Allow-Origin: *');
require_once 'db_function.php';
$db = new DBFunctions();
$response =array ("error"=>FALSE);
if( isset($_POST['Tutor'])) {
    $tutor =$_POST['Tutor'];
	$user_tutor=$db->getTutorById($tutor);
	if($user_tutor!=FALSE){
            $kids=$db->getTutorKids($tutor);	
            $response["kids"]=$kids;
            echo json_encode($response);
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



