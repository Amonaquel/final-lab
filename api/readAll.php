<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Check Request Method
if ($_SERVER['REQUEST_METHOD'] != 'GET') {
    http_response_code(405);
    echo json_encode(['error' => 'Method Not Allowed']);
    exit();
}

try {
    include_once '../db/Database.php';
    include_once '../models/Bookmark.php';

    // Instantiate a Database object & connect
    $database = new Database();
    $dbConnection = $database->connect();

    // Instantiate Bookmark object
    $bookmark = new Bookmark($dbConnection);

    // Read all Bookmark items
    $result = $bookmark->readAll();
    
    if (!empty($result)) {
        echo json_encode($result);
    } else {
        echo json_encode(['message' => 'No bookmarks were found']);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
