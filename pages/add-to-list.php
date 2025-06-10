<?php
// Dummy fetch from TMDB or source (or you pass full info via GET)
$movieId = $_GET['id'] ?? null;
$title = $_GET['title'] ?? 'Untitled';
$thumbnail = $_GET['thumbnail'] ?? 'default.jpg';

if ($movieId) {
    $movie = [
        'id' => $movieId,
        'title' => $title,
        'thumbnail' => $thumbnail,
    ];

    // Initialize list if not set
    if (!isset($_SESSION['collection'])) {
        $_SESSION['collection'] = [];
    }

    // Prevent duplicate
    $alreadyExists = false;
    foreach ($_SESSION['collection'] as $item) {
        if ($item['id'] == $movieId) {
            $alreadyExists = true;
            break;
        }
    }

    if (!$alreadyExists) {
        $_SESSION['collection'][] = $movie;
    }

    // Redirect back
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}
?>
