<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Check Request Method
if ($_SERVER['REQUEST_METHOD'] != 'DELETE') {
    http_response_code(405);
    echo json_encode(['error' => 'Method Not Allowed']);
    exit();
}

try {
    include_once '../db/Database.php';
    include_once '../models/Bookmark.php';

    // Get posted data
    $data = json_decode(file_get_contents("php://input"));

    if (!isset($data->id)) {
        throw new Exception('ID is required');
    }

    // Instantiate a Database object & connect
    $database = new Database();
    $dbConnection = $database->connect();

    // Instantiate Bookmark object
    $bookmark = new Bookmark($dbConnection);
    $bookmark->setId($data->id);

    // Delete the bookmark
    if ($bookmark->delete()) {
        echo json_encode(['message' => 'Bookmark deleted successfully']);
    } else {
        throw new Exception('Failed to delete bookmark');
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
