<?php
// Check Request Method
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Allow: POST');
    http_response_code(405);
    echo json_encode('Method Not Allowed');
    return;
}

// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');

include_once '../db/Database.php';
include_once '../models/Bookmark.php';

// Instantiate a Database object & connect
$database = new Database();
$dbConnection = $database->connect();

// Instantiate Bookmark object
$bookmark = new Bookmark($dbConnection);

// Get the HTTP POST request JSON body
$data = json_decode(file_get_contents("php://input"), true);
if (
    !$data ||
    !isset($data['title']) ||
    !isset($data['link'])
) {
    http_response_code(422);
    echo json_encode([
        'message' => 'Error: Missing required parameters (title and link) in the JSON body.'
    ]);
    return;
}

// Set bookmark data
$bookmark->setTitle($data['title']);
$bookmark->setLink($data['link']);

// Create Bookmark
if ($bookmark->create()) {
    echo json_encode([
        'message' => 'Bookmark was created successfully.'
    ]);
} else {
    echo json_encode([
        'message' => 'Error: Bookmark was not created.'
    ]);
}
