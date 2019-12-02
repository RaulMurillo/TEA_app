<?php
header('Access-Control-Allow-Origin: *');
require_once 'db_function.php';
$db = new DBFunctions();
$response =array ("error"=>FALSE);
if(  isset($_POST['Nombre_grupo']) && isset($_POST['Tutor'])) {
    $group =$_POST['Nombre_grupo'];
    $tutor =$_POST['Tutor'];
    $grupo=$db->getGroupbyName($group);
	if(	$db->getGroup($grupo["id_group"])!=FALSE){	
		if($grupo["id_tutor"]==$tutor){
            $kids=$db->getGroupKids($grupo["id_group"]);
            if($grupo)		
                $response["kids"]=$kids;
            else{
            $response["error_msg"]="Error inesperado";
            $response["error"]=TRUE;
            }
            echo json_encode($response);
	}
	else{
		$response["error"]=TRUE;
		$response["error_msg"]="El tutor no es el dueño del grupo ";
		echo json_encode($response);
	}
}
	else{
		$response["error"]=TRUE;
		$response["error_msg"]="El grupo no existe ";
		echo json_encode($response);
	}

}

else{
	$response["error"]=TRUE;
	$response["error_msg"]="falta algun parametro";
	echo json_encode($response);
}

?>



