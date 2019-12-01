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

    public function insertTutor($name, $surname, $email, $password, $birth=null)
    {
        $stmt = $this->conn->prepare("INSERT INTO tutor (nombre, apellido, email, crypto_pass, salt, birth_date) VALUES(?,?,?,?,?,?)");
        $hash = $this->hashSSHA($password);
        $stmt->bind_param("ssssss", $name, $surname, $email, $hash["encrypted"], $hash["salt"], $birth);

        $result = $stmt->execute();
        $stmt->close();
        if ($result) {
            echo "New record created successfully!\n";

            $stmt = $this->conn->prepare("SELECT id_tutor, nombre, apellido, email, birth_date FROM tutor WHERE email =? ");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $user = $stmt->get_result()->fetch_assoc();
            $stmt->close();
            return $user;
        } else {
            echo "Could not create such record\n";
            return null;
        }
    }

    public function getTutorEmailPass($email, $password)
    {
        $stmt = $this->conn->prepare("SELECT * FROM tutor WHERE email = ? ");
        $stmt->bind_param("s", $email);

        if ($stmt->execute()) {
            $user = $stmt->get_result()->fetch_assoc();
            $stmt->close();
            $salt = $user['salt'];
            $encrypted = $user['crypto_pass'];
            $hash = $this->checkHashSSHA($salt, $password);
            if ($encrypted == $hash) {
                return $user;
            }
        } else {
            return null;
        }
    }

    public function getTutorById($tutorId)
    {
        $stmt = $this->conn->prepare("SELECT * FROM tutor WHERE id_tutor = ? ");
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
        $stmt = $this->conn->prepare("SELECT * FROM kid WHERE id_kid = ? ");
        $stmt->bind_param("s", $ninoId);

        if ($stmt->execute()) {
            $user = $stmt->get_result()->fetch_assoc();
            $stmt->close();
            return $user;
        } else {
            return null;
        }
    }
    public function getTaskById($taskId)
    {
        $stmt = $this->conn->prepare("SELECT * FROM tareas WHERE id_tarea = ? ");
        $stmt->bind_param("s", $taskId);

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
        $stmt = $this->conn->prepare("SELECT * FROM tutor_kid_relation WHERE id_tutor = ? and id_kid = ? ");
        $stmt->bind_param("ss", $tutorId, $ninoId);

        if ($stmt->execute()) {
            $tutoria = $stmt->get_result()->fetch_assoc();
            $stmt->close();
            return $tutoria;
        } else {
            return null;
        }
    }
    public function createTutoria($tutorId, $ninoId,$estado)
    {
        $stmt = $this->conn->prepare("INSERT INTO tutor_kid_relation(id_tutor, id_kid,state) Values (?,?,?)");
        $stmt->bind_param("sss", $tutorId, $ninoId,$estado);

        if ($stmt->execute()) {
            echo "New Tutoria created successfully!\n";

            $tutoria = $this->getTutoriaTutorNino($tutorId,$ninoId);
            $stmt->close();
            return $tutoria;
        } else {
            echo "Could not create such record\n";
            return false;
        }
    }
     public function updateTutoria($tutorId, $ninoId,$estado)
    {
        $stmt = $this->conn->prepare("UPDATE tutor_kid_relation SET state = ? WHERE id_tutor = ? and id_kid = ? ");
        $stmt->bind_param("sss", $estado, $tutorId, $ninoId);

        if ($stmt->execute()) {
            echo "State changed successfully!\n";

            $tutoria = $this->getTutoriaTutorNino($tutorId,$ninoId);
            $stmt->close();
            return $tutoria;
        } else {
            echo "Could not create such record\n";
            return false;
        }
    }
    public function delTutoria($tutorId, $ninoId)
    {
        $stmt = $this->conn->prepare("DELETE FROM tutor_kid_relation WHERE id_tutor =? and id_kid =?");
        $stmt->bind_param('ss', $tutorId, $ninoId);
        $result = $stmt->execute();
        $stmt->close();
        return $result;

    }
    public function delTask($id_tarea)
    {
        $stmt = $this->conn->prepare("DELETE FROM tareas WHERE id_tarea =?");
        $stmt->bind_param('s', $id_tarea);
        $result = $stmt->execute();
        $stmt->close();
        return $result;

    }

    public function existeEmail($email)
    {
        $stmt = $this->conn->prepare("SELECT * FROM tutor WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->close();
            return true;
        } else {
            $stmt->close();
            return false;
        }
    }

    public function existeNick($nick)
    {
        $stmt = $this->conn->prepare("SELECT * FROM kid WHERE nick = ?");
        $stmt->bind_param("s", $nick);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->close();
            return true;
        } else {
            $stmt->close();
            return false;
        }
    }

    public function storeNino($nick, $nombre, $apellido, $id_tutor, $birth=null)
    {

        //$id_kid = 5;

        $stmt = $this->conn->prepare("INSERT INTO kid (nick, nombre, apellido, id_main_tutor, birth_date) Values (?,?,?,?,?)");
        $stmt->bind_param("sssss", $nick, $nombre, $apellido, $id_tutor, $birth);
        $result = $stmt->execute();
        $stmt->close();
        if ($result) {
            echo "New record created successfully!\n";

            $stmt = $this->conn->prepare("SELECT * FROM kid WHERE nick =? ");
            $stmt->bind_param("s", $nick);
            $stmt->execute();
            $user = $stmt->get_result()->fetch_assoc();
            $stmt->close();
            return $user;
        } else {
            echo "Could not create such record\n";
            return false;
        }

    }
    public function getGroupbyName($group)
    {
        
        $stmt = $this->conn->prepare("SELECT * FROM tea_group WHERE nombre = ?");
        $stmt->bind_param("s", $group);
        if ($stmt->execute()) {
            $grupo = $stmt->get_result()->fetch_assoc();
            $stmt->close();
            return $grupo;
        } else {
            return null;
        }
    }
    public function createGroup($group, $tutor)
    {
        $stmt = $this->conn->prepare("INSERT INTO tea_group(id_tutor, nombre) Values (?,?)");
        $stmt->bind_param("ss", $tutor,$group);

        if ($stmt->execute()) {
            echo "New Group created successfully!\n";

            $grupo = $this->getGroupbyName($group);
            $stmt->close();
            return $grupo;
        } else {
            echo "Could not create such record\n";
            return false;
        }
    }
    public function getGroupKids($group)
    {
        $stmt = $this->conn->prepare("SELECT * FROM kid_group_relation WHERE id_group = ?");
        $stmt->bind_param("s", $group);
        if ($stmt->execute()) {
            $grupo = $stmt->get_result()->fetch_array();
            $stmt->close();
            return $grupo;
        } else {
            return null;
        }
    }
    public function getGroup($group)
    {
        $stmt = $this->conn->prepare("SELECT * FROM tea_group WHERE id_group = ?");
        $stmt->bind_param("s", $group);
        if ($stmt->execute()) {
            $grupo = $stmt->get_result()->fetch_assoc();
            $stmt->close();
            return $grupo;
        } else {
            return null;
        }  
    }
    public function delGroup($group)
    {
        $stmt = $this->conn->prepare("DELETE FROM tea_group WHERE id_group =?");
        $stmt->bind_param('s', $group);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }
    public function getGroupKidGrupo($id_kid,$id_group)	
    {
        $stmt = $this->conn->prepare("SELECT * FROM kid_group_relation WHERE id_group = ? and id_kid = ?");
        $stmt->bind_param("ss", $id_group,$id_kid);
        if ($stmt->execute()) {
            $grupo = $stmt->get_result()->fetch_assoc();
            $stmt->close();
            return $grupo;
        } else {
            return null;
        }
    }
    public function unionGrupo($id_kid,$id_group)
    {
        $stmt = $this->conn->prepare("INSERT INTO kid_group_relation (id_group, id_kid) Values (?,?)");
        $stmt->bind_param("ss",$id_group,$id_kid);

        if ($stmt->execute()) {
            echo "New Group created successfully!\n";

            $grupo = $this->getGroupsNino($id_kid);
            $stmt->close();
            return $grupo;
        } else {
            echo "Could not create such record\n";
            return false;
        }
    }
    public function delKidGroup($id_group,$id_kid)
    {
        $stmt = $this->conn->prepare("DELETE FROM kid_group_relation WHERE id_group =? and id_kid = ?");
        $stmt->bind_param('ss', $id_group,$id_kid);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }
    public function getGroupsNino($id_kid)
    {
        $stmt = $this->conn->prepare("SELECT * FROM kid_group_relation WHERE  id_kid = ?");
        $stmt->bind_param("s",$id_kid);
        if ($stmt->execute()) {
            $grupo = $stmt->get_result()->fetch_array();
            $stmt->close();
            return $grupo;
        } else {
            return null;
        }
    }
    public function getGroupsTutor($tutor)
    {
        $stmt = $this->conn->prepare("SELECT * FROM tea_group WHERE  id_tutor = ?");
        $stmt->bind_param("s",$tutor);
        if ($stmt->execute()) {
            $grupo = $stmt->get_result()->fetch_array();
            $stmt->close();
            return $grupo;
        } else {
            return null;
        }
    }

    public function storeTask( $tini,$tfin,$path_picto,$id_tutor,$id_nino,$text,$id_dia)
    {
        $tstam= date('Y-m-d H:i:s');
        $stmt = $this->conn->prepare("INSERT INTO tareas (hora_inicio, hora_fin, id_nino, id_tutor,texto, path_picto,t_stamp,dia) Values (?,?,?,?,?,?,?,?)");
        $stmt->bind_param("ssssssss", $tini,$tfin,$id_nino,$id_tutor,$text,$path_picto,$tstam,$id_dia);
        $result = $stmt->execute();
        $stmt->close();
        if ($result) {
            echo "New record created successfully!\n";

            $stmt = $this->conn->prepare("SELECT * FROM tareas WHERE t_stamp =? and id_tutor =? and id_nino =?");
            $stmt->bind_param("sss", $tstam,$id_tutor,$id_nino);
            $stmt->execute();
            $user = $stmt->get_result()->fetch_assoc();
            $stmt->close();
            return $user;
        } else {
            echo "Could not create such record\n";
            return false;
        }

    }
    public function updateTask( $tini,$tfin,$path_picto,$id_tutor,$id_nino,$text,$id_tarea)
    {
        $tstam= date('Y-m-d H:i:s');
        //UPDATE tblFacilityHrs SET title = ?, description = ? WHERE uid = ?
        $stmt = $this->conn->prepare("UPDATE  tareas SET hora_inicio = ?, hora_fin= ?, id_nino= ?, id_tutor= ?
                                        ,texto= ?, path_picto= ?,t_stamp= ? WHERE id_tarea = ?");
        $stmt->bind_param("ssssssss", $tini,$tfin,$id_nino,$id_tutor,$text,$path_picto,$tstam,$id_tarea);
        $result = $stmt->execute();
        $stmt->close();
        if ($result) {
            echo "New record created successfully!\n";

            $stmt = $this->conn->prepare("SELECT * FROM tareas WHERE id_tarea =?");
            $stmt->bind_param("s", $id_tarea);
            $stmt->execute();
            $user = $stmt->get_result()->fetch_assoc();
            $stmt->close();
            return $user;
        } else {
            echo "Could not create such record\n";
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


//colisiones en proceso
    public function collisions($dia,$tini,$tfin){
        $stmt = $this->conn->prepare("SELECT * FROM tareas WHERE ( ( hora_inicio <= ? and ?<= hora_fin ) or
                                         ( ? <= hora_fin and hora_fin <= ? ) or 
                                         ( hora_inicio <= ? and  ? <= hora_fin ) or ( ? <= hora_inicio and hora_fin <= ?) ) 
                                         and dia = ?");
        $stmt->bind_param("sssssssss",$tfin,$tfin,$tini,$tfin,$tini,$tfin,$tini,$tfin,$dia);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->close();
            return true;
        } else {
            $stmt->close();
            return false;
        }

    }

    public function collisionsUpdate($dia,$tini,$tfin,$id_tarea){
        $stmt = $this->conn->prepare("SELECT * FROM tareas WHERE ( ( hora_inicio <= ? and ?<= hora_fin ) or
        ( ? <= hora_fin and hora_fin <= ? ) or 
        ( hora_inicio <= ? and  ? <= hora_fin ) or ( ? <= hora_inicio and hora_fin <= ?) ) 
                                            and dia = ? and id_tarea != ?");
        $stmt->bind_param("ssssssssss",$tfin,$tfin,$tini,$tfin,$tini,$tfin,$tini,$tfin,$dia,$id_tarea);
        $stmt->execute();
        $stmt->store_result();
        

        if ($stmt->num_rows > 0) {
            $stmt->close();
            return true;
        } else {
            $stmt->close();
            return false;
        }

    }
}
