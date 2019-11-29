<?php
require_once 'db_function.php';
require_once 'pgregg.php';
$db = new DBFunctions();
$response = array("error" => false);
$result=array();
;
if (isset($_POST['palabra'])) {
    $palabra=$_POST['palabra'];
    $directorio = 'picts/shared';
   // $files = glob($directorio."/$palabra*.jpg");
    $files = glob($directorio."/*");
    foreach ($files as $file){
        if(($aux=stristr($file, $palabra))!=false)
           array_push($result,$file);
            
    }
    $response["error"] = false;
    $response["sources"] = $result;
    echo json_encode($response,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES );

}