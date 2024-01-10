<?php
    class Post {
        //db propperties
        private $conn;
        private $table = 'posts';

        //post propperties
        public $id;
        public $category_id;
        public $category_name;
        public $title;
        public $body;
        public $author;
        public $created_at;

        //db constuctor
        public function __construct($db) {
            $this->conn = $db;
        }

        //GET posts
        public function read() {
            //query
            $query = 'SELECT
                p.id,
                p.category_id,
                p.title,
                p.body,
                p.author,
                p.created_at,
                c.name as category_name
            FROM 
                ' . $this->table . ' p
            LEFT JOIN
                categories c ON p.category_id = c.id
            ORDER BY 
                p.id
            DESC';

            //prepare statement
            $stmt = $this->conn->prepare($query);

            //execute statement
            $stmt->execute();

            //return the result from statement
            return $stmt;
        }

        public function read_sameAuthor() {
            //query
            $query = 'SELECT
                p.id,
                p.category_id,
                p.title,
                p.body,
                p.author,
                p.created_at,
                c.name as category_name
            FROM 
                ' . $this->table . ' p
            LEFT JOIN
                categories c ON p.category_id = c.id
            WHERE p.author = :author
            ORDER BY 
                p.id
            DESC';

            //prepare statement
            $stmt = $this->conn->prepare($query);

            //bind parameters SECURITY
            $stmt->bindParam(':author', $this->author, PDO::PARAM_STR, 255);

            //execute statement
            $stmt->execute();

            //return the result from statement
            return $stmt;
        }

        //Create posts
        public function create() {
            //create the date and format it into string
            $date = new DateTime('now', new DateTimeZone('Europe/Brussels'));
            $date = $date->format('Y-m-d H:i:s');

            //query
            $query = 'INSERT INTO ' . $this->table . ' (
                title, 
                author, 
                body, 
                category_id,
                created_at
            )
            VALUES (
                :title,
                :author,
                :body,
                :category_id,
                :date
            ) ' ;
            
            //prepare statement
            $stmt = $this->conn->prepare($query);

            //bind parameters SECURITY
            $stmt->bindParam(':title', $this->title, PDO::PARAM_STR, 255);
            $stmt->bindParam(':author', $this->author, PDO::PARAM_STR, 255);
            $stmt->bindParam(':body', $this->body, PDO::PARAM_STR, 1000);
            $stmt->bindParam(':category_id', $this->category_id, PDO::PARAM_INT, 11);
            $stmt->bindParam(':date', $date);

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

        //Update posts
        public function update() {
                //create the date and format it into string
                $date = new DateTime('now', new DateTimeZone('Europe/Brussels'));
                $date = $date->format('Y-m-d H:i:s');
    
                //query
                $query = 'UPDATE ' . $this->table . ' 
                SET
                    title = :title, 
                    author = :author, 
                    body = :body, 
                    category_id = :category_id,
                    created_at = :date
                WHERE 
                    (id = :id)';
                
                //prepare statement
                $stmt = $this->conn->prepare($query);
    
                //bind parameters SECURITY
                $stmt->bindParam(':title', $this->title, PDO::PARAM_STR, 255);
                $stmt->bindParam(':author', $this->author, PDO::PARAM_STR, 255);
                $stmt->bindParam(':body', $this->body, PDO::PARAM_STR, 1000);
                $stmt->bindParam(':category_id', $this->category_id, PDO::PARAM_INT, 11);
                $stmt->bindParam(':date', $date);
                $stmt->bindParam(':id', $this->id);
    
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

        //Delete posts
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

            //return result
            return $stmt;
            
        }

    }