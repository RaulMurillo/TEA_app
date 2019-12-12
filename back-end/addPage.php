<?php
header('Access-Control-Allow-Origin: *');
require_once 'db_function.php';
$db = new DBFunctions();
$response =array ("error"=> FALSE);
if(  isset($_POST['id_tutor']) && isset($_POST['id_cuento'])&& isset($_POST['path']))
{
    $id_tutor = $_POST['id_tutor'];
    $id_cuento = $_POST['id_cuento'];
    $path = $_POST['path'];
    //comprobamos que ese cuento exista para el tutor
    $story = $db->getStoryByid($id_tutor,$id_cuento);
    if($story)
    {
        $pages=$db->createPage($id_cuento,$path);
        if($pages)
        {
            http_response_code(200);
            $response["error"] = false;
            $response["page"] = $pages[count($pages)-1];
            echo json_encode($response,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES );
        }
        else
        {
            http_response_code(400);
            $response["error"] = true;
            $response["error_msg"] = "Error al crear pagina";
            echo json_encode($response,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES );
        }

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
    $response["error_msg"] = "Parametros incorrectos";
    echo json_encode($response,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES );
}
