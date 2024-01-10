<?php
    // include our database object and client modal
    include_once('../../Config/Database.php');
    include_once('../../Models/Client.php');

    class Authenticate {
        public function verify() {
            if(isset($_GET)) {
                //Authenticate get
                if (isset($_GET['username']) && isset($_GET['password'])) {
                    //initiate the database connection
                    $db = new Database();
                    $db = $db->connect();

                    //initiate client modal
                    $client = new Client($db);

                    $client->username = $_GET['username'];
                    $client->password = sha1($_GET['password']) . sha1($_GET['username']);

                    if ($client->verifyClient()->rowCount()>0) {
                    
                        return true;
                    }
                }
                return false;
            }
            else {
                //Authenticate post
                if (isset($_POST['username']) && isset($_POST['password'])) {
                    //initiate the database connection
                    $db = new Database();
                    $db = $db->connect();

                    //initiate client modal
                    $client = new Client($db);

                    $client->username = $_POST['username'];
                    $client->password = sha1($_POST['password']) . sha1($_POST['username']);

                    if ($client->verifyClient()->rowCount()>0) {
                
                        return true;
                    }
                }
                return false;
            }

        }
    }