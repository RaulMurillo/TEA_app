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

    public function insertTutor()
    {
        // prepare and bind
        $stmt = $this->conn->prepare("INSERT INTO Tutor ()
                VALUES(:first_name, :last_name, :email)");
        // TO-DO: set parameters and execute
        $stmt->bind_param(':first_name', $name);
        $stmt->bind_param(':last_name', $surname);
        $stmt->bind_param(':email', $email);
        

        if ($stmt->execute()) {

        } else {
            return null;
        }
    }

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
            return null;
        }
    }

    public function getTutorById($tutorId)
    {
        $stmt = $this->conn->prepare("SELECT * FROM Tutor WHERE Id_tutor =? ");
        $stmt->bind_param("s", $tutorId);

        if ($stmt->execute()) {
            $user = $stmt->get_result()->fetch_assoc();
            $stmt->close();
            return $user;
        } else {
            return null;
        }
    }

    public function getNinoById($ninoId)
    {
        $stmt = $this->conn->prepare("SELECT * FROM Nino WHERE Id_Nino =? ");
        $stmt->bind_param("s", $ninoId);

        if ($stmt->execute()) {
            $user = $stmt->get_result()->fetch_assoc();
            $stmt->close();
            return $user;
        } else {
            return null;
        }
    }

    public function getTutoriaTutorNino($tutorId, $ninoId)
    {
        $stmt = $this->conn->prepare("SELECT * FROM Tutoria WHERE Id_tutor =? and Id_Nino=? ");
        $stmt->bind_param("ss", $tutorId, $ninoId);

        if ($stmt->execute()) {
            $tutoria = $stmt->get_result()->fetch_assoc();
            $stmt->close();
            return $tutoria;
        } else {
            return null;
        }
    }
    public function delTutoria($tutorId, $ninoId)
    {
        $stmt = $this->conn->prepare("DELETE FROM Tutoria WHERE Id_tutor =? and Id_Nino=?");
        $stmt->bind_param('ss', $tutorId, $ninoId);
        $result = $stmt->execute();
        $stmt->close();
        return $result;

    }

    public function existeNick($nick){
        $stmt =$this->conn->prepare("SELECT * FROM Nino WHERE nick =?");
        $stmt->bind_param("s",$nick);
        $stmt->execute();
        $stmt->store_result();
    
        if($stmt->num_rows>0)
        {
    
            $stmt->close();
            return true;
        }
        else{
            $stmt->close();
            return false;
        }
    }

    public function storeNino($nick,$fecha_nacimiento,$nombre,$apellido,$id_tutor){
        
        $Id_nino=5;

        $stmt=$this->conn->prepare("INSERT INTO Nino(Id_nino,Nick,Fecha_nacimiento,Nombre,Apellido,Id_tutor_principal) Values (?,?,?,?,?,?)");
        $stmt->bind_param("ssssss",$Id_nino,$nick,$fecha_nacimiento,$nombre,$apellido,$id_tutor);
        $result =$stmt->execute();
        $stmt->close();
        if($result){
            $stmt =$this->conn->prepare("SELECT * FROM nino WHERE Nick =? ");
            $stmt->bind_param("s",$nick);
            $stmt->execute();
            $user = $stmt->get_result()->fetch_assoc();
            $stmt->close();
            return $user;
        }else {
            return false;
        }
    
    }

    private function hashSSHA($password)
    {
        $salt = sha1(rand());
        $salt = substr($salt, 0, 10);
        $encrypted = base64_encode(sha1($password . $salt, true) . $salt);
        $hash = array("salt" => $salt, "encrypted" => $encrypted);
        return $hash;
    }

    private function checkHashSSHA($salt, $password)
    {
        $hash = base64_encode(sha1($password . $salt, true) . $salt);
        return $hash;
    }
}
