<?php
header('Access-Control-Allow-Origin: *');
require_once 'db_function.php';
$db = new DBFunctions();
$response =array ("error"=>FALSE);
if(  isset($_POST['id_tutor']) &&  isset($_POST['id_tutor_accion']) && isset($_POST['id_kid'])&& isset($_POST['accion'])) 
{
    $idTutor = $_POST['id_tutor'];
    $idTutorAccion = $_POST['id_tutor_accion'];
    $idKid = $_POST['id_kid'];
    $accion = $_POST['accion'];

    if($accion == 'ACCEPTED' || $accion == 'REFUSED')
    {
        $kid = $db->getNinoById($idKid);
        if($kid)
        {
            //comprobamos que el id del tutor que realiza la accion sea el principal del niño
            if($kid["id_main_tutor"] == $idTutor)
            {
                $res = $db->updateTutoria($idTutorAccion, $idKid,$accion);
                if($res)
                {
                    $response["error"] = false;
                    $response["turoria"] = $res;
                    echo json_encode($response,JSON_UNESCAPED_UNICODE);
                }
                else
                {
                    http_response_code(400);
                    $response["error"] = true;
                    $response["error_msg"] = "Caballero de la buena mesa, ese niño no esta asociado a ese tutor, por faavor no la cague mas";
                    echo json_encode($response,JSON_UNESCAPED_UNICODE);
    
                }
                
            }
            else{
                http_response_code(400);
                $response["error"] = true;
                $response["error_msg"] = "No eres el tutor principal, no tienes poder sobre este niño -_-";
                echo json_encode($response,JSON_UNESCAPED_UNICODE);

            }
        }else
        {
            http_response_code(400);
            $response["error"] = true;
            $response["error_msg"] = "No existe el niño";
            echo json_encode($response,JSON_UNESCAPED_UNICODE);
        }
       
    }
   
    else
    {
        http_response_code(400);
        $response["error"] = true;
        $response["error_msg"] = "La accion debe ser ACCEPTED o REFUSED";
        echo json_encode($response);
    }
   
   
}
else
{
    http_response_code(400);
    $response["error"] = true;
    $response["error_msg"] = "Parametros incorrectos";
    echo json_encode($response);
}