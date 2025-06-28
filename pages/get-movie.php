<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);


include __DIR__ . '/../includes/api-functions.php';

$response = fetchApiData("http://linkskool.net/api/v3/public/movies/shorts");

if (!isset($response['data']) || !is_array($response['data'])) {
    echo json_encode([]);
    exit;
}

$movies = $response['data'];

// If ID is provided, return only that movie
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    foreach ($movies as $movie) {
        if ($movie['id'] == $id) {
            header('Content-Type: application/json');
            echo json_encode($movie);
            exit;
        }
    }
    // If movie not found
    echo json_encode([]);
    exit;
}

// Otherwise return paginated data
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 3;
$offset = ($page - 1) * $limit;
$paginatedData = array_slice($movies, $offset, $limit);

header('Content-Type: application/json');
echo json_encode($paginatedData);
