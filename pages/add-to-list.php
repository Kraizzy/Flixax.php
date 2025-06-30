<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $title = $_POST['title'] ?? null;
    $thumbnail = $_POST['thumbnail'] ?? null;

    if ($id && $title && $thumbnail) {
        $collection = $_SESSION['collection'] ?? [];
        $recentlyWatched = $_SESSION['recently_watched'] ?? [];

        // Check for duplicates
        $exists = false;
        foreach ($collection as $movie) {
            if ($movie['id'] == $id) {
                $exists = true;
                break;
            }
        }

        if (!$exists) {
            $collection[] = [
                'id' => $id,
                'title' => $title,
                'thumbnail' => $thumbnail
            ];
            $_SESSION['collection'] = $collection;
        }
    }
}

// Redirect back to previous page
header("Location: {$_SERVER['HTTP_REFERER']}");
exit;
