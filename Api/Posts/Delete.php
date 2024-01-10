<?php
    //headers
    header('Acces-Control-Allow-Origin = *');
    header('Content-Type = application/json');

    //include needed php classes
    include_once('../../Models/Post.php');
    include_once('../../Config/Database.php');
    include_once('../Authentication/Authenticate.php');

    //Authenticate
    $authenticate = new Authenticate();
    if(!$authenticate->verify()) {
        echo json_encode(array('message' => 'authentication failed'));

        return;
    }

    //initiate the database connection
    $db = new Database();
    $db = $db->connect();

    //Initiate modal class post
    $post = new Post($db);

    //check if id is in the url as a get request
    if(!isset($_GET['id'])) {
        echo json_encode(array('message' => 'You need to specify the id as a get request'));

        return;
    }

    //store the data
    $post->id = $_GET['id'];

    //Save the new post into database
    if ($post->delete()->rowCount()>0) {
        echo json_encode(array('message'=> "Post has succesfully been deleted"));
    }
    else {
        echo json_encode(array("message" => "Post with this id does not exist"));
    }
