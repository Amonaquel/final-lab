<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET');

include_once '../db/Database.php';
include_once '../models/Todo.php';

// Instantiate a Database object & connect
$database = new Database();
$dbConnection = $database->connect();

// Instantiate Todo object
$todo = new Todo($dbConnection);



// Read all ToDo items
$result = $todo->readAll();
if (! empty($result)) {
    echo json_encode($result);
} else {
    echo json_encode(
        array('message' => 'No todo items were found')
    );
}
