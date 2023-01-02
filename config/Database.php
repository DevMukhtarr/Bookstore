<?php

class Database{
    // db params
    private $host = "localhost";
    private $db_name = "crudservice";
    private $username = "root";
    private $password = "";
    private $conn;

    public function connect(){
        $this->conn = null;

        try {
            //code...
            $this->conn = new PDO('mysql:host='. $this->host . ';dbname='. $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            //throw $th;
            echo 'Connection error: ' . $e->getMessage();
        }

        return $this->conn;
    }
}