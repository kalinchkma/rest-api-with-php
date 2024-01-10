<?php
    //headers
    header('Acces-Control-Allow-Origin = *');
    header('Content-Type = application/json');

    //include needed php classes
    include_once('../../Models/Category.php');
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

    //Initiate modal class category
    $category = new Category($db);

    //get results by using category function read
    $result = $category->read();

    //get count of rows from result
    $numberOfRows = $result->rowCount();

    //Do something with the result
    //check if any rows first
    if ($numberOfRows>0) {
        //if rows exist in result
        $category_arr = array();
        $category_arr['data'] = array();

        //loop the results
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            //extract the row so u can use the propperties as variables
            extract($row);

            //each post gets into his own array
            $category_item = array(
                'id' => $id,
                'name' => $name
            );

            //push the category array into data array
            array_push($category_arr['data'], $category_item);

        }

        //turn to JSON and output data
        echo json_encode($category_arr);
    }
    else {
        //no results
        echo json_encode( array(
            'message' => 'There are no categories'
        ));
    }
