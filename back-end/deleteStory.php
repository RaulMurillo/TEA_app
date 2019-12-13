<?php
header('Access-Control-Allow-Origin: *');
require_once 'db_function.php';
$db = new DBFunctions();
$response =array ("error"=> FALSE);
if(  isset($_POST['id_tutor']) && isset($_POST['id_cuento']))
{
    $id_tutor = $_POST['id_tutor'];
    $id_cuento = $_POST['id_cuento'];
    //comprobamos que ese cuento exista para el tutor
    if($db->getStoryByid($id_tutor,$id_cuento))
    {
        $res = $db->deleteStory($id_tutor,$id_cuento);
        if($res)
        {
            http_response_code(200);
            $response["error"] = false;
            $response["msg"] = "Cuento borrado ";
            echo json_encode($response,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES );
        }
        else
        {
            http_response_code(400);
            $response["error"] = true;
            $response["error_msg"] = "Fallo al eliminar";
            echo json_encode($response,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES );
        }
    }
    else
    {
        http_response_code(400);
        $response["error"] = true;
        $response["error_msg"] = "Tutor y cuento no vinculados";
        echo json_encode($response,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES );
    }
}
else
{
    http_response_code(400);
    $response["error"] = true;
    $response["error_msg"] = "Parametros incorrectos";
    echo json_encode($response,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES );
}
