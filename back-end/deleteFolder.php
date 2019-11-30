<?php


$response = array("error" => false);

if (isset($_POST['carpeta']) && isset($_POST['idTutor'])) {
    $directorio='picts/usr/'.$_POST['idTutor']."/".$_POST['carpeta'];
    
    if(is_dir($directorio)){
        rmdir($directorio);
        http_response_code(200);
        $response["error"] = false;
        echo json_encode($response);
       
    }
    else{
        http_response_code(400);
        $response["error"] = true;
        $response["error_msg"] = "No existe la carpeta";
        echo json_encode($response);
    }
}
else{
    http_response_code(400);
    $response["error"] = true;
    $response["error_msg"] = "Datos incorrectos";
    echo json_encode($response);
}
