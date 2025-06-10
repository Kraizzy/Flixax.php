<?php
$searchTerm = isset($_GET['query']) ? strtolower(trim($_GET['query'])) : '';

$movies = [];
$url = "http://linkskool.net/api/v3/public/movies/all";
$response = @file_get_contents($url);

if ($response !== false) {
    $data = json_decode($response, true);
    $sections = $data['data'] ?? [];

    // Flatten all movies from all nested arrays (hot, recommended, etc.)
    foreach ($sections as $section) {
        if (is_array($section)) {
            foreach ($section as $movie) {
                if (is_array($movie)) {
                    $movies[] = $movie;
                }
            }
        }
    }
}

$results = [];

if ($searchTerm && !empty($movies)) {
    $results = array_filter($movies, function ($movie) use ($searchTerm) {
        $titleMatch = isset($movie['title']) && stripos($movie['title'], $searchTerm) !== false;
        $descMatch = isset($movie['description']) && stripos($movie['description'], $searchTerm) !== false;
        $idMatch = isset($movie['id']) && stripos((string)$movie['id'], $searchTerm) !== false;

        return $titleMatch || $descMatch || $idMatch;
    });
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Search Results</title>
  <style>
    body { font-family: Nunito; background: #0f0f0f; color: #fff; }
    .movie-card { margin-bottom: 20px; background: #1c1c1c; padding: 15px; border-radius: 8px; }
    img { width: 100%; max-width: 100%; border-radius: 6px; }
    .result-container { display: grid; grid-template-columns: repeat(auto-fill, minmax(20rem, 1fr)); gap: 20px; }
    .not-found { color: #aaa; margin-top: 40px; font-size: 18px; text-align: center; }
    .searchContainer{  padding: 1.8rem; margin: 0 auto;  margin-top: 5rem;}
  </style>
</head>
<body>
<div class="searchContainer">
    <h1>Search Results for "<?= htmlspecialchars($_GET['query'] ?? '') ?>"</h1>
    
    <?php if (empty($results)): ?>
      <p class="not-found">No results found. Try searching by movie title, description, or ID.</p>
    <?php else: ?>
      <div onclick="window.location.href='<?= $baseUrl ?>/for-you?id=<?= urlencode($movie['id']) ?>'" class="result-container">
        <?php foreach ($results as $movie): ?>
          <div class="movie-card">
            <img src="<?= htmlspecialchars($movie['poster_portrait'] ?? $movie['poster_landscape'] ?? '') ?>" alt="<?= htmlspecialchars($movie['title']) ?>">
            <h3><?= htmlspecialchars($movie['title']) ?></h3>
            <p><?= htmlspecialchars(substr($movie['description'] ?? 'No description', 0, 100)) ?>...</p>
            <a href="<?= $baseUrl ?>/for-you?id=<?= urlencode($movie['id']) ?>" style="color:#0af">Watch Now</a>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
</div>

</body>
</html>
