<?php
    class Database {
        //Database parameters
        private $host = 'localhost';
        private $db_name = 'posts';
        private $username = 'root';
        private $password  = '';
        private $conn;

        //Database connection
        public function connect() {
            $this->conn = null;

            try {
                $this->conn = new PDO('mysql:host='. $this->host.';dbname=' . $this->db_name  ,   $this->username , $this->password);
            } catch(PDOException $e) {
                echo('Connection error:' . $e->getMessage());
                die();
            }

            return $this->conn;
        }
    }