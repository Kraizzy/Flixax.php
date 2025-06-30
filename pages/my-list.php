<?php
$collectionMovies = $_SESSION['collection'] ?? [];
$recentlyWatchedMovies = $_SESSION['recently_watched'] ?? [];
$baseUrl = "/";
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My List</title>
  <style>
    body {
      background-color: #000;
      color: #fff;
      font-family: Nunito, sans-serif;
      margin: 6rem auto;
      padding: 0;
    }

    .nav-tabs {
      display: flex;
      gap: 20px;
      width: 85%;
      margin: 1rem auto;
      padding: 10px;
      border-bottom: 1px solid #333;
    }

    .nav-tabs a {
      color: #b3b3b3;
      font-family: Nunito, sans-serif;
      text-decoration: none;
      padding-bottom: 5px;
    }

    .nav-tabs a.active {
      color: #fff;
      border-bottom: 2px solid #ff2e63;
    }

    .content {
      padding: 20px;
      margin: 0 auto;
      width: 95%;
      text-align: center;
    }

    .empty-state {
      margin-top: 50px;
    }

    .empty-state h2 {
      font-size: 24px;
      margin-bottom: 10px;
    }

    .empty-state p {
      color: #b3b3b3;
      margin-bottom: 20px;
    }

    .btn {
      background-color: #ff2e63;
      color: #fff;
      padding: 10px 20px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      text-decoration: none;
    }

    .movie-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
      gap: 20px;
      margin-top: 20px;
    }

    .movie-item {
      text-align: center;
    }

    .movie-item img {
      width: 100%;
      height: auto;
      border-radius: 5px;
    }

    .movie-item p {
      margin: 5px 0;
      font-size: 14px;
      color: #b3b3b3;
    }

    .movie-item .new-label {
      position: absolute;
      background-color: #ff2e63;
      color: #fff;
      padding: 2px 8px;
      border-radius: 3px;
      font-size: 12px;
    }
  </style>
</head>

<body>
  <div class="nav-tabs">
    <a href="#" class="tab-link active" data-tab="recently-watched">Recently Watched</a>
    <a href="#" class="tab-link" data-tab="collection">Collection</a>
  </div>

  <div class="content">
    <!-- Recently Watched -->
    <div id="recently-watched" class="tab-content active">
      <?php if (empty($recentlyWatchedMovies)): ?>
        <div id="recently-watched-empty" class="empty-state">
          <h2>Nothing to See Here!</h2>
          <p>Go to Home and save something you would like to watch later.</p>
          <a href="<?= $baseUrl ?>/home" class="btn">Back to Home</a>
        </div>
        <div id="recently-watched-grid" class="movie-grid" style="display: none;"></div>
      <?php else: ?>
        <div id="recently-watched-empty" class="empty-state" style="display: none;"></div>
        <div id="recently-watched-grid" class="movie-grid">
          <?php foreach ($recentlyWatchedMovies as $movie): ?>
            <div class="movie-card">
              <img src="<?= htmlspecialchars($movie['thumbnail']) ?>" alt="<?= htmlspecialchars($movie['title']) ?>">
              <p class="movie-title"><?= htmlspecialchars($movie['title']) ?></p>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>

    <!-- Collection -->
    <div id="collection" class="tab-content" style="display: none;">
      <?php if (empty($collectionMovies)): ?>
        <div id="collection-empty" class="empty-state">
          <h2>Nothing to See Here!</h2>
          <p>Go to Home and save something you would like to watch later.</p>
          <a href="<?= $baseUrl ?>/home" class="btn">Back to Home</a>
        </div>
        <div id="collection-grid" class="movie-grid" style="display: none;"></div>
      <?php else: ?>
        <div id="collection-empty" class="empty-state" style="display: none;"></div>
        <div id="collection-grid" class="movie-grid">
          <?php foreach ($collectionMovies as $movie): ?>
            <div class="movie-card">
              <img src="<?= htmlspecialchars($movie['poster_portrait']) ?>" alt="<?= htmlspecialchars($movie['title']) ?>">
              <p class="movie-title"><?= htmlspecialchars($movie['title']) ?></p>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>
  </div>

  <script>
    // Tab switching
    document.querySelectorAll('.tab-link').forEach(tab => {
      tab.addEventListener('click', (e) => {
        e.preventDefault();
        document.querySelectorAll('.tab-link').forEach(t => t.classList.remove('active'));
        document.querySelectorAll('.tab-content').forEach(t => t.style.display = 'none');
        tab.classList.add('active');
        document.getElementById(tab.dataset.tab).style.display = 'block';
      });
    });
  </script>
</body>

</html>