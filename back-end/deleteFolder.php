<?php
header('Access-Control-Allow-Origin: *');
function rrmdir($dir) { 
    if (is_dir($dir)) { 
      $objects = scandir($dir); 
      foreach ($objects as $object) { 
        if ($object != "." && $object != "..") { 
          if (is_dir($dir."/".$object) && !is_link($dir."/".$object))
            rrmdir($dir."/".$object);
          else
            unlink($dir."/".$object); 
        } 
      }
      rmdir($dir); 
    } 
  }

$response = array("error" => false);

if (isset($_POST['carpeta']) && isset($_POST['idTutor'])) {
    $directorio='picts/usr/'.$_POST['idTutor']."/".$_POST['carpeta'];
    
    if(is_dir($directorio)){
        rrmdir($directorio);
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
