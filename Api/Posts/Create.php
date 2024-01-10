<?php
    //headers
    header('Acces-Control-Allow-Origin = *');
    header('Content-Type = application/json');

    //include needed php classes
    include_once('../../Config/Database.php');
    include_once('../../Models/Post.php');
    include_once('../Authentication/Authenticate.php');

    //Authenticate
    $authenticate = new Authenticate();
    if(!$authenticate->verify()) {
        echo json_encode(array('message' => 'authentication failed'));
        return;
    }

    //Initiate database connection
    $db = new Database();
    $db = $db->connect();

    //Initiate modal class Post
    $post = new Post($db);
    
    //Get all input
    $data = json_decode(file_get_contents('php://input'));

    //store the data
    $post->title = $data->title;
    $post->author = $data->author;
    $post->body = $data->body;
    $post->category_id = $data->category_id;

    //Save the new post into database
    if ($post->create()) {
        echo json_encode(array('message'=> "post has succesfully been created"));
    }
    else {
        echo json_encode(array("message" => "Post not created"));
    }
    