<?php
header('Access-Control-Allow-Origin: *');

$response = array("error" => false);
if (isset($_POST['carpeta']) && isset($_POST['idTutor'])) {
    $directorio='picts/usr/'.$_POST['idTutor'];
    if(is_dir($directorio) ){
        $directorio=$directorio."/".$_POST['carpeta'];
        if(!is_dir($directorio) ){
            mkdir($directorio, 0777);
            http_response_code(200);
            $response["error"] = false;
            echo json_encode($response);
        
        }
        else{
            http_response_code(400);
            $response["error"] = true;
            $response["error_msg"] = "No se puede crear la carpeta, ya existe";
            echo json_encode($response);
        }
    }
    else{
        http_response_code(400);
        $response["error"] = true;
        $response["error_msg"] = "No existe el directorio";
        echo json_encode($response);
    }
    
}
else{
    http_response_code(400);
    $response["error"] = true;
    $response["error_msg"] = "No se puede crear la carpeta";
    echo json_encode($response);
}
