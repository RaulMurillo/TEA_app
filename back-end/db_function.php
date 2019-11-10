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
    public function delTutoria($tutorId, $ninoId)
    {
        $stmt = $this->conn->prepare("DELETE FROM tutor_kid_relation WHERE id_tutor =? and id_kid =?");
        $stmt->bind_param('ss', $tutorId, $ninoId);
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
