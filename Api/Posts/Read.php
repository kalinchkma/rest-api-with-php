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

    //get results by using post function read
    $result = $post->read();

    //get count of rows from result
    $numberOfRows = $result->rowCount();

    //Do something with the result
    //check if any rows first
    if ($numberOfRows>0) {
        //if rows exist in result
        $post_arr = array();
        $post_arr['data'] = array();

        //loop the results
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            //extract the row so u can use the propperties as variables
            extract($row);

            //each post gets into his own array
            $post_item = array(
                'id' => $id,
                'title' => $title,
                'author' => $author,
                'category_name' => $category_name,
                'body' => $body,
                'created_at' => $created_at
            );

            //push the post array into data array
            array_push($post_arr['data'], $post_item);

        }

        //turn to JSON and output data
        echo json_encode($post_arr);
    }
    else {
        //no results
        echo json_encode( array(
            'message' => 'There are no posts'
        ));
    }
