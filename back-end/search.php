<?php
require_once 'db_function.php';
require_once 'pgregg.php';
$db = new DBFunctions();
$response = array("error" => false);
$result=[];
$info=array();
;
if (isset($_POST['palabra'])) {
    $palabra=$_POST['palabra'];
    $directorio = 'picts/shared';
   // $files = glob($directorio."/$palabra*.jpg");
    $files = glob($directorio."/*");
    foreach ($files as $file){
        if(($aux=stristr($file, $palabra))!=false){
            $iparr = explode("/", $file); 
            $name= explode(".", $iparr[2]); 
            $result["nombre"] = $name[0];
            $result["path"] = $file;
            array_push($info,$result);
        }
            
    }
    $response["error"] = false;
    $response["sources"]=$info;
    echo json_encode($response,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES );

}