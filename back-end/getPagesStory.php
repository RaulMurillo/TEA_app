<?php
header('Access-Control-Allow-Origin: *');
require_once 'db_function.php';
$db = new DBFunctions();
$response =array ("error"=> FALSE);
/*
PUEDE DEVOLVER TODAS LAS PAGINAS DE UN JUEGO PASANDOLE EL ID DE ESE JUEGO
O 
UNA PAGINA PASANDOLE EL ID DE PAGINA
*/
if(isset($_POST['id_cuento']))
{
    $id_cuento = $_POST['id_cuento'];
    $pages = $db->getPages($id_cuento);
    if($pages)
    {
    	$aux=array();
    	foreach ($pages as $page)
    	{
    		array_push($aux,$page[0]); //obtenemos las paginas de dicho cuento
    	}
	  	
        http_response_code(200);
        $response["error"] = false;
        $response["stories"] = $aux;
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
else if (isset($_POST['id_pagina']))
{
    $id_pagina = $_POST['id_pagina'];
    $page = $db->getPage($id_pagina);
    if($page)
    {
        http_response_code(200);
        $response["error"] = false;
        $response["page"] = $page;
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
