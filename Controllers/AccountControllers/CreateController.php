<?php  
    // include our database object and client modal
    include_once('../../Config/Database.php');
    include_once('../../Models/Client.php');

    //Initiate database connection
    $db = new Database();
    $db = $db->connect();

    //Initiate client class
    $client = new Client($db);

    //set propperties with the post variables
    $client->username = $_POST['username'];
    $client->password = sha1($_POST['password']) . sha1($_POST['username']);

    //login the user
    $result = $client->create();

    //get result of login
    $numberOfRows = $result->rowCount();

    //check if user is logged in
    if($numberOfRows>0) {
        //redirect to the success page
        return header('location: http://localhost/RESTAPI-RAWPHP/Views/index.php');
        
    }

    //if user failed to login set session variable to failed
    echo('something went wrong when creating client');

    






