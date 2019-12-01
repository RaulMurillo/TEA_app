<?php

$response = array("error" => false);
$result=[];
$info=array();
 //caso en el que recibo carpeta e id
if (isset($_POST['carpeta']) && isset($_POST['idTutor'])) {
    $directorio='picts/usr/'.$_POST['idTutor']."/".$_POST['carpeta'];
    //$directorio = 'picts/shared';
    //$files = glob($directorio."/$palabra*.jpg");
    if(is_dir($directorio)){
        $files = glob($directorio."/*");
        foreach ($files as $file){
            if(($aux=stristr($file,".jpg"))!=false){
                $iparr = explode("/", $file); 
                $name= explode(".", $iparr[4]); 
                $result["nombre"] = $name[0];
                $result["path"] = $file;
                array_push($info,$result);
            }
            else{
                http_response_code(400);
                $response["error"] = true;
                $response["error_msg"] = "Archivo no valido";
            }
                
        }
        $response["error"] = false;
        $response["sources"]=$info;
        echo json_encode($response,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES );
    }
    else{
        http_response_code(400);
        $response["error"] = true;
        $response["error_msg"] = "El directorio no existe";
        echo json_encode($response);
    }
    

}
//caso para leer carpeta de usuario
elseif(isset($_POST['idTutor']))
{
    $directorio='picts/usr/'.$_POST['idTutor'];
    if(is_dir($directorio))
    {
        $files = glob($directorio."/*");
        foreach ($files as $file){
                $name = explode("/", $file); 
                $result["nombre"] = $name[3];
                //$result["path"] = urlencode($file);
                array_push($info,$result);
        }
        $response["error"] = false;
        $response["sources"]=$info;
        echo json_encode($response);
    }

}
else{
    $directorio = 'picts/shared';
    $files = glob($directorio."/*");
    foreach ($files as $file){
        $iparr = explode("/", $file); 
        $name= explode(".", $iparr[2]); 
        $result["nombre"] = $name[0];
        $result["path"] = $file;
        array_push($info,$result);
            
    }
    
    $response["error"] = false; 
    $response["sources"]=$info;
    echo json_encode($response,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES );
}
