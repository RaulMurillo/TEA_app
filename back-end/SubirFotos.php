<?php
require_once 'db_function.php';
$db = new DBFunctions();
$response = array("error" => false);
if (isset($_POST['id_tutor']){
    $id_tutor = $_POST['id_tutor'];
    $nombre = $_FILES['archivo']['name'];
    $pwd = $_FILES['archivo']['tmp_name'];
    if(!file_exists('fotos'.$id_tutor)){
        mkdir('fotos'.$id_tutor,0777,true)
    }
    if(move_uploaded_file($pwd,'fotos'.$id_tutor)){


    }
    else{
        $response["error"] = true;
        $response["error_msg"] = "No se ha podido guardar el archivo";
        echo json_encode($response);
    }


    

}
else{
    $response["error"] = true;
    $response["error_msg"] = "Es necesario el id del tutor";
    echo json_encode($response);
}