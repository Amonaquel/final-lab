<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Check Request Method
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method Not Allowed']);
    exit();
}

try {
    include_once '../db/Database.php';
    include_once '../models/Bookmark.php';

    // Get posted data
    $data = json_decode(file_get_contents("php://input"));

    if (!isset($data->title) || !isset($data->link)) {
        throw new Exception('Title and link are required');
    }

    // Instantiate a Database object & connect
    $database = new Database();
    $dbConnection = $database->connect();

    // Instantiate Bookmark object
    $bookmark = new Bookmark($dbConnection);
    $bookmark->setTitle($data->title);
    $bookmark->setLink($data->link);

    // Create the bookmark
    if ($bookmark->create()) {
        http_response_code(201);
        echo json_encode(['message' => 'Bookmark created successfully']);
    } else {
        throw new Exception('Failed to create bookmark');
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
