<?php

class Database {
    private $host = "postgres";
    private $db_name = "hybriddrive";
    private $username = "user";
    private $password = "password";

    public function getConnection() {
        $conn = null;

        try {
            $conn = new PDO("pgsql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
        } catch(PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }

        return $conn;
    }
}
