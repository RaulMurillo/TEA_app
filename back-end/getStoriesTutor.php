<?php
header('Access-Control-Allow-Origin: *');
require_once 'db_function.php';
$db = new DBFunctions();
$response =array ("error"=> FALSE);
if(isset($_POST['id_tutor']))
{
    $id_tutor = $_POST['id_tutor'];
    $stories = $db->getStoryByidTutor($id_tutor);
    if($stories)
    {
    	$aux=array();
    	foreach ($stories as $story)
    	{
            $au["id_cuento"]=$story[0];
            $au["nombre"]=$story[2];
    		array_push($aux,$au); 
    	}
	  	
        http_response_code(200);
        $response["error"] = false;
        $response["pages"] = $aux;
        echo json_encode($response,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES );
    }
    else
    {
        http_response_code(400);
        $response["error"] = true;
        $response["error_msg"] = "No existe el cuento";
        echo json_encode($response,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES );
    }
}
else
{
    http_response_code(400);
    $response["error"] = true;
    $response["error_msg"] = "Parametros Incorrectos";
    echo json_encode($response,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES );
}
