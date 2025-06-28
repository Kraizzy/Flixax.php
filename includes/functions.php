<?php
// Session management functions
function addToCollection($movie) {
    $collection = $_SESSION['collection'] ?? [];
    if (!isset($collection[$movie['movieId']])) {
        $collection[$movie['movieId']] = $movie;
        $_SESSION['collection'] = $collection;
    }
}

function addToRecentlyWatched($movie) {
    $recentlyWatched = $_SESSION['recently_watched'] ?? [];
    $recentlyWatched[$movie['movieId']] = $movie;
    if (count($recentlyWatched) > 10) {
        $recentlyWatched = array_slice($recentlyWatched, -10, 10, true);
    }
    $_SESSION['recently_watched'] = $recentlyWatched;
}

function removeFromList($movieId, $listType) {
    if ($listType === 'collection' && isset($_SESSION['collection'][$movieId])) {
        unset($_SESSION['collection'][$movieId]);
    } elseif ($listType === 'recently_watched' && isset($_SESSION['recently_watched'][$movieId])) {
        unset($_SESSION['recently_watched'][$movieId]);
    }
}

// API functions
function fetchMoviesByGenre($genreId) {
    $url = "http://linkskool.net/api/v3/public/movies/genre/" . urlencode($genreId);
    $response = @file_get_contents($url);
    if ($response === false) {
        return [];
    }
    $data = json_decode($response, true);
    return isset($data['data']) && is_array($data['data']) ? $data['data'] : [];
}

function fetchGenres() {
    $genreApiUrl = "http://linkskool.net/api/v3/public/movies/genres";
    $response = @file_get_contents($genreApiUrl);
    if ($response === false) {
        return [];
    }
    $data = json_decode($response, true);
    return isset($data['data']) && is_array($data['data']) ? $data['data'] : [];
}

function getGenreNameById($genreId, $genres) {
    foreach ($genres as $genre) {
        if ($genre['id'] == $genreId) {
            return $genre['name'];
        }
    }
    return "Unknown Genre";
}
?>