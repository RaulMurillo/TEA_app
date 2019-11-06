<?php

class DBConnect
{
    private $conn;
    public function connect()
    {
        require_once 'config.php';
        $this->conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
        // Check connection
        if ($this->conn->connect_error) {
			die("Connection failed: " . $this->conn->connect_error);
			return NULL;
        }
        mysqli_set_charset($this->conn, 'utf8');
        return $this->conn;
    }
}
