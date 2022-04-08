<?php

require ("backendDataBase.php");

if($_SERVER['REQUEST_METHOD'] === 'POST')
{
    /*
    $data = readPostData();

    $query = "INSERT INTO employees VALUES(DEFAULT, '$data->birthDate', '$data->firstName', '$data->lastName', '$data->gender', '$data->hireDate');";
    
    if($Connessione->query($query) === TRUE)
    {
        $json_respond = Test($Connessione->query($query));
        header('Content-Type: application/json');
    }
    */
}
else if($_SERVER['REQUEST_METHOD'] === 'GET')
{
    $backend = new backendDataBase($_GET['page'], $_GET['size']);

    $json_respond = $backend->GET($_GET['page'], $_GET['size']);
    
    header('Content-Type: application/json');        
}

echo json_encode($json_respond);


function readPostData() 
{
    // Takes raw data from the request
    $json = file_get_contents('php://input');

    // Converts it into a PHP object
    $data = json_decode($json);

    return $data;
}

?>