<?php
    class Category {
        //db propperties
        private $conn;
        private $table = 'categories';

        //post propperties
        public $id;
        public $name;

        //db constuctor
        public function __construct($db) {
            $this->conn = $db;
        }

        //GET categories
        public function read() {
            //query
            $query = 'SELECT * FROM ' . $this->table;

            //prepare statement
            $stmt = $this->conn->prepare($query);

            //execute statement
            $stmt->execute();

            //return results of statement
            return $stmt;
        }

        //GET specific category by name
        public function read_singleCategory() {
            //query
            $query = 'SELECT * FROM ' . $this->table . ' WHERE id = :id';

            //prepare statement
            $stmt = $this->conn->prepare($query);

            //bind parameters SECURITY
            $stmt->bindParam(':id', $this->id, PDO::PARAM_STR, 255);

            //execute statement
            $stmt->execute();

            //return results of statement
            return $stmt;

        }

        //Create posts
        public function create() {
            //query
            $query = 'INSERT INTO ' . $this->table . ' (
                name
            )
            VALUES (
                :name
            ) ' ;
            
            //prepare statement
            $stmt = $this->conn->prepare($query);

            //bind parameters SECURITY
            $stmt->bindParam(':name', $this->name, PDO::PARAM_STR, 255);

            //execute statement with checking if something goes wrong
            //if correct
            if ($stmt->execute()) {
                return true;
            }
            
            //if something wrong
            //if something wrong print error
            print_r($stmt->errorInfo());

            //return false
            return false;
        }

        //Update categories
        public function update() {
                //query
                $query = 'UPDATE ' . $this->table . ' 
                SET
                    name = :name
                WHERE 
                    (id = :id)';
                
                //prepare statement
                $stmt = $this->conn->prepare($query);
    
                //bind parameters SECURITY
                $stmt->bindParam(':name', $this->name, PDO::PARAM_STR, 255);
                $stmt->bindParam(':id', $this->id, PDO::PARAM_STR, 255);
    
                //execute statement with checking if something goes wrong
                //if correct
                if ($stmt->execute()) {
                    return true;
                }
                //if something wrong print error
                print_r($stmt->errorInfo());

                //return false
                return false;

        }

        //Delete categories
        public function delete() {
            //query
            $query = 'DELETE FROM ' . $this->table . ' 
            WHERE 
                (id = :id)';
            
            //prepare statement
            $stmt = $this->conn->prepare($query);

            //bind parameters SECURITY
            $stmt->bindParam(':id', $this->id);

            //execute statement
            $stmt->execute();

            //return statement
            return $stmt;
            
        }

    }