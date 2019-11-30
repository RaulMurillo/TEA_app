<?php

$response = array("error" => false);
$result=[];
$info=array();

if (isset($_POST['carpeta']) && isset($_POST['idTutor']) && isset($_POST['path'])) {
    
    $path=$_POST['path'];
    if(is_dir('picts/usr/'.$_POST['idTutor']."/".$_POST['carpeta'])){
        $aux=stristr($path,"/");
        $aux=stristr($aux,".jpg");
        $directorio='picts/usr/'.$_POST['idTutor']."/".$_POST['carpeta'].$aux[0];
        symlink($path,$directorio);
    }
    else{
        http_response_code(400);
        $response["error"] = true;
        $response["error_msg"] = "No existe directorio";
        echo json_encode($response);

    }
    
     
}
elseif(isset($_POST['carpeta']) && isset($_POST['idTutor'])&&isset($_POST['archivo'])) {

}
else{
    http_response_code(400);
    $response["error"] = true;
    $response["error_msg"] = "No se puede subir fichero";
    echo json_encode($response);
}