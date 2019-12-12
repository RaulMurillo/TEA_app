<?php
header('Access-Control-Allow-Origin: *');
require_once 'db_function.php';
$db = new DBFunctions();
$response =array ("error"=> FALSE);
if(  isset($_POST['id_tutor']) && isset($_POST['nombre']))
{
    $id_tutor = $_POST['id_tutor'];
    $nombre = $_POST['nombre'];
    //comprobamos si existe tutor
    $tutor = $db->getTutorById($id_tutor);
    if($tutor)
    {
        //comprobamos que no exista dicho nombre de cuento para ese tutor
        $story = $db->getStory($id_tutor,$nombre);
        if($story)
        {
            http_response_code(400);
            $response["error"] = true;
            $response["error_msg"] = "Nombre de cuento ya existente";
            echo json_encode($response,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES );
        }
        else
        {
            $story = $db->createStory($id_tutor,$nombre);
            if($story)
            {
                http_response_code(200);
                $response["error"] = false;
                $response["story"] = $story;
                echo json_encode($response,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES );
            }
            else{
                http_response_code(400);
                $response["error"] = true;
                $response["error_msg"] = "Error al crear el cuento";
                echo json_encode($response,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES );
            }
            
        }
    }
    else{
        http_response_code(400);
        $response["error"] = true;
        $response["error_msg"] = "Error no existe el tutor";
        echo json_encode($response,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES );
    }
    
}
else{
    http_response_code(400);
    $response["error"] = true;
    $response["error_msg"] = "Parametros incorrectos";
    echo json_encode($response,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES );
}