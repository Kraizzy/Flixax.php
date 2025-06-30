<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include __DIR__ . '/../includes/api-functions.php';

// Fetch all movies
$response = fetchApiData("http://linkskool.net/api/v3/public/movies/shorts");

if (!isset($response['data']) || !is_array($response['data'])) {
    echo json_encode([]);
    exit;
}

$movies = $response['data'];

// Get page number and batch size (limit)
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$limit = isset($_GET['limit']) ? max(1, (int)$_GET['limit']) : 3;

$offset = ($page - 1) * $limit;
$paginatedData = array_slice($movies, $offset, $limit);

header('Content-Type: application/json');
echo json_encode($paginatedData);
