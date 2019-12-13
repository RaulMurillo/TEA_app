<?php
header('Access-Control-Allow-Origin: *');
// require_once 'db_function.php';

// $db = new DBFunctions();
$response = array("error" => false);

class GamesList //extends \SplEnum
{
    const Identificar_picto = 99901;
}

if(isset($_POST['id_game'])){

    //$game = new GamesList($_POST['id_game']);

    $game = ($_POST['id_game']);
    switch ($game) {
        case GamesList::Identificar_picto:
            
            require 'game1.php';
            $g = new Identificar_picto();
            $response['game'] = $g->play();

            if ($response['game']==null){
                $response["error"] = true;
                $response["error_msg"] = "El juego ha fallado";
                echo json_encode($response,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES );
            }
            else{
                echo json_encode($response,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES );
            }
            break;
        default:
            //http_response_code(400);
            $response["error"] = true;
            $response["error_msg"] = "El juego no existe";
            echo json_encode($response,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES );
    }



}
else{
    http_response_code(400);
    $response["error"] = true;
    $response["error_msg"] = "Parametros Incorrectos";
    echo json_encode($response,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES );
}