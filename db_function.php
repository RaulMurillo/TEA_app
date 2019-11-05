<?php

class DB_FUNCTIONS{
private $conn;
function __construct(){
	require_once 'db_connect.php';
	$db=new DB_Connect();
	$this->conn=$db->connect();

}
function __destruct(){}



public function getTutorEmailPass($email,$password){
	$stmt =$this->conn->prepare("SELECT * FROM Tutor WHERE Email =? ");
	$stmt->bind_param("s",$email);

	if($stmt->execute())
	{
		$user =$stmt->get_result()->fetch_assoc();
		$stmt->close();
		$salt =$user['Salt'];
		$Contrasena=$user['Contrasena'];
		$hash=$this->checkhashSSHA($salt,$password);
		if ($Contrasena==$hash)
				return $user;
	}
	else{
		return NULL;
	}
}



public function hashSSHA($password)
{
	$salt=sha1(rand());
	$salt=substr($salt,0,10);
	$encrypted=base64_encode(sha1($password.$salt,true).$salt);
	$hash=array("salt"=>$salt,"encrypted"=>$encrypted);
	return $hash;
	}

public function checkhashSSHA($salt,$password){
	$hash=base64_encode(sha1($password.$salt,true).$salt);
	return $hash;
}	
}
?>