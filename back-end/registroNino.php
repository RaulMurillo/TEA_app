<?php
require_once 'db_function.php';
$db = new DBFunctions();
$response =array ("error"=>FALSE);

if( isset($_POST['Nick'])&& isset($_POST['FechaNacimiento'])&& isset($_POST['Nombre'])&& isset($_POST['Apellido'])&& isset($_POST['Tutor'])) {
    $nick =$_POST['Nick'];
    $fecha_nacimiento =$_POST['FechaNacimiento'];
    $nombre =$_POST['Nombre'];
    $apellido =$_POST['Apellido'];
    $id_tutor=$_POST['Tutor'];

if($db->existeNick($nick))
{
	$response["error"]=TRUE;
	$response["error_msg"]="El Nick ya existe";
	echo json_encode($response);
}

else{
    $user_tutor=$db->getTutorById($id_tutor);
    if($user_tutor==FALSE){
	$response["error"]=TRUE;
	$response["error_msg"]="El tutor no existe";
	echo json_encode($response);
    }
    else{
        $user=$db->storeNino($nick,$fecha_nacimiento,$nombre,$apellido,$id_tutor);
        if($user){
            $response["error"]=FALSE;
            $response["user"]=$user;
            echo json_encode($response);
        }
        else{
            $response["error"]=TRUE;
        $response["error_msg"]="error desconocido";
        echo json_encode($response);
        }
    }
}


}

else
{
    if(isset($_POST['Tutor']))
    $response["error_msg"]="falta .$fecha_nacimiento.";
    else
    $response["error_msg"]="falta otro";
	$response["error"]=TRUE;

	echo json_encode($response);
}
?>



