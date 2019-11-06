<?php

class DBFunctions
{
    private $conn;
    public function __construct()
    {
        require_once 'db_connect.php';
        $db = new DBConnect();
        $this->conn = $db->connect();

    }
    public function __destruct()
    {}
		
	
    public function getTutorEmailPass($email, $password)
    {
        $stmt = $this->conn->prepare("SELECT * FROM Tutor WHERE Email =? ");
        $stmt->bind_param("s", $email);

        if ($stmt->execute()) {
            $user = $stmt->get_result()->fetch_assoc();
            $stmt->close();
            $salt = $user['Salt'];
            $Contrasena = $user['Contrasena'];
            $hash = $this->checkHashSSHA($salt, $password);
            if ($Contrasena == $hash) {
                return $user;
            }

        } else {
            return NULL;
        }
    }

    public function getTutorById($tutorId)
    {
        $stmt = $this->conn->prepare("SELECT * FROM Tutor WHERE Idtutor =? ");
        $stmt->bind_param("s", $tutorId);

        if ($stmt->execute()) {
            $user = $stmt->get_result()->fetch_assoc();
            $stmt->close();
            return $user;
        } else {
            return NULL;
        }
    }

    public function getNinoById($ninoId)
    {
        $stmt = $this->conn->prepare("SELECT * FROM Nino WHERE IdNino =? ");
        $stmt->bind_param("s", $ninoId);

        if ($stmt->execute()) {
            $user = $stmt->get_result()->fetch_assoc();
            $stmt->close();
            return $user;
        } else {
            return NULL;
        }
    }

    public function getTutoriaTutorNino($tutorId, $ninoId)
    {
        $stmt = $this->conn->prepare("SELECT * FROM Tutoria WHERE Idtutor =? and IdNino=? ");
        $stmt->bind_param("ss", $tutorId, $ninoId);

        if ($stmt->execute()) {
            $tutoria = $stmt->get_result()->fetch_assoc();
            $stmt->close();
            return $tutoria;
        } else {
            return NULL;
        }
	}
	public function delTutoria($tutorId, $ninoId)
	{
		$stmt = $this->conn->prepare("DELETE FROM Tutoria WHERE Idtutor =? and IdNino=?");
		$stmt->bind_param('ss',$tutorId, $ninoId);
		$result =$stmt->execute(); 
		$stmt->close();
		return $result;

		
	}

    private function hashSSHA($password)
    {
        $salt = sha1(rand());
        $salt = substr($salt, 0, 10);
        $encrypted = base64_encode(sha1($password . $salt, TRUE) . $salt);
        $hash = array("salt" => $salt, "encrypted" => $encrypted);
        return $hash;
    }

    private function checkHashSSHA($salt, $password) 
    {
        $hash = base64_encode(sha1($password . $salt, TRUE) . $salt);
        return $hash;
    }
}
?>