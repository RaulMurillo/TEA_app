<?php
header('Access-Control-Allow-Origin: *');
require_once 'db_function.php';
$db = new DBFunctions();
$response = array("error" => false);

if (isset($_POST['id_subtask']) && isset($_POST['text'])&& isset($_POST['path'])) {
    $subtask=$_POST['id_subtask'];
    $texto=$_POST['text'];
    $path=$_POST['path'];
    if($db->getSubTaskbyId($subtask)){
        $stask=$db->updtSubTask($subtask,$texto,$path);
        $response["error"] = false;
        $response["subtask"] = $stask;
        echo json_encode($response);
    }
    else {
        $response["error_msg"] = "La subtarea no existe";
        $response["error"] = true;
        echo json_encode($response);
    }
        
        
    

} else {
    
    $response["error_msg"] = "faltan campos";
    $response["error"] = true;
    echo json_encode($response);
}
