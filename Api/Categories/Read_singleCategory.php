<?php
    //headers
    header('Acces-Allow-Origin = *');
    header('content-type = application/JSON');

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

    //check if id is in the url as a get request
    if(!isset($_GET['id'])) {
        echo json_encode(array('message' => 'You need to specify the id as a get request'));

        return;
    }

    //if id is specified use it in the read request
    $category->id = $_GET['id'];

    //get results by using category function read
    $result = $category->read_singleCategory();

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

            //each category gets into his own array
            $category_item = array(
                'id' => $id,
                'name' => $name,
            );

            //push the category array into data array
            array_push($category_arr['data'], $category_item);

        }

        //turn to JSON and output data
        echo json_encode($category_arr);
    }
    else {
        echo json_encode(array('Message' => 'Category doesnt exist.'));
    }
