<?php
    class Client {
        //db propperties
        private $conn;
        private $table = 'clients';

        //client propperties
        public $username;
        public $password;

        //db constuctor
        public function __construct($db) {
            $this->conn = $db;
        }

        public function create() {
            //query
            $query = 'INSERT INTO '. 
            $this->table .' (username, password)
            VALUES (:username, :password) ';
        
            //prepare statement
            $stmt = $this->conn->prepare($query);

            //bindparams
            $stmt->bindParam(':username', $this->username, PDO::PARAM_STR, 255);
            $stmt->bindParam(':password', $this->password, PDO::PARAM_STR, 255);

            //execute statement
            $stmt->execute();

            //return results of statement
            return $stmt;
        }

        public function verifyClient() {
            //query
            $query = 'SELECT * FROM '. $this->table .
            ' WHERE (username = :username) AND 
            (password = :password) ';
        
            //prepare statement
            $stmt = $this->conn->prepare($query);

            //bindparams
            $stmt->bindParam(':username', $this->username, PDO::PARAM_STR, 255);
            $stmt->bindParam(':password', $this->password, PDO::PARAM_STR, 255);

            //execute statement
            $stmt->execute();

            //return results of statement
            return $stmt;
        }

    }