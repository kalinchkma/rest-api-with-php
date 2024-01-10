<?php
    //include needed php classes
    include_once('../../Api/Call/CallAPI.php');

    //initiate api call class
    $apiCall = new CallAPI();

    //set options variables
    $method = 'GET';
    $curl = 'localhost/RESTAPI-RAWPHP/Api/Posts/Read.php';
    $data = array('username'=>'testclient', 'password'=>'testpass');

    $result = $apiCall->call($method, $curl, $data);

    echo ($result);