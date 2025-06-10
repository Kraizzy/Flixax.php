
<?php
include __DIR__ . '/../includes/api-functions.php';
$response = fetchApiData("http://linkskool.net/api/v3/public/movies/all");

// Initialize variables
$allMovies = [];
$allMovieIds = [];
$currentMovieId = null;
$currentIndex = 0;

// Debug: View the complete API response structure
// echo '<pre>'; print_r($response); echo '</pre>'; exit;

// Get all movies from all categories
if (isset($response['data']) && is_array($response['data'])) {
    // Define the categories we want to include
    $categories = ['hot', 'recommended', 'new_and_trending']; // Add any other categories you want
    
    foreach ($categories as $category) {
        if (isset($response['data'][$category]) && is_array($response['data'][$category])) {
            $allMovies = array_merge($allMovies, $response['data'][$category]);
        }
    }
    
    // Extract all movie IDs
    $allMovieIds = array_column($allMovies, 'id');
    
    // Only proceed if we have valid movies
    if (!empty($allMovieIds)) {
        $currentMovieId = $_GET['id'] ?? $allMovieIds[array_rand($allMovieIds)];
        $currentIndex = array_search($currentMovieId, $allMovieIds);
        
        // Fallback if ID not found
        if ($currentIndex === false) {
            $currentMovieId = $allMovieIds[array_rand($allMovieIds)];
            $currentIndex = array_search($currentMovieId, $allMovieIds);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Watch Movies</title>
  <link rel="stylesheet" href="assets/style.css">
  <style>
    body {
      margin: 0;
      padding: 0;
      background-color: #000;
      color: white;
      font-family: -apple-system, BlinkMacSystemFont, sans-serif;
      overflow: hidden;
    }
    
    .app-container {
      display: flex;
      margin-top: 3.7rem;
      height: 92vh;
      padding: 0.5rem;
    }
    
    .video-column {
      flex: 2;
      padding-top: 2rem;
      position: relative;
      padding-left: 2rem;
    }
    
    .info-column {
      flex: 1;
      margin-top: 4.2rem;
      padding: 20px;
      height: 80%;
      overflow-y: auto;
      background: rgba(0,0,0,0.7);
    }
    
    .video-container {
      position: relative;
      height: 97.5%;
      user-select: none;
      width: 85%;
    }
    
    .video-player {
      width: 100%;
      user-select: none;
      height: 100%;
      object-fit: cover;
    }
    
    /* MODIFIED: Adjusted to group navigation buttons with 1rem gap and centered alignment */
    .nav-buttons {
      position: absolute;
      display: none;
      right: 20px;
      top: 50%;
      transform: translateY(-50%);
      display: flex;
      flex-direction: column;
      gap: 1rem; /* ADDED: 1rem gap between buttons */
      z-index: 20;
    }
    
    .next-video-btn, .prev-video-btn { /* MODIFIED: Added prev-video-btn */
      background: none;
      display: none;
      border: none;
      cursor: pointer;
    }
    
    .next-video-btn svg, .prev-video-btn svg { /* MODIFIED: Added prev-video-btn svg */
      width: 40px;
      height: 40px;
      filter: drop-shadow(0 0 5px rgba(0,0,0,0.5));
    }
    
    .video-title {
      font-size: 1.8rem;
      font-weight: bold;
      margin-bottom: 15px;
    }
    
    .video-meta {
      display: flex;
      gap: 15px;
      margin-bottom: 15px;
      font-size: 0.9rem;
    }
    
    .genre-tag {
      background: rgba(255,255,255,0.2);
      padding: 3px 8px;
      border-radius: 4px;
    }
    
    .video-description {
      margin-bottom: 30px;
      line-height: 1.5;
    }
    
    .action-buttons {
      display: flex;
      gap: 20px;
      margin-bottom: 30px;
    }
    .nav-buttons img{
      width: 3rem;
      height: 3rem;
      border-radius: 50%;
    }
    .action-button {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 5px;
      cursor: pointer;
    }
    
    .action-button svg {
      width: 30px;
      height: 30px;
    }
    
    .episodes-section {
      margin-top: 30px;
    }
    
    .episodes-title {
      font-weight: bold;
      margin-bottom: 15px;
      font-size: 1.2rem;
    }
    
    .episode-list {
      display: flex;
      flex-direction: column;
      gap: 10px;
    }
    
    .episode-item {
      padding: 8px 12px;
      background: rgba(255,255,255,0.1);
      border-radius: 4px;
      cursor: pointer;
    }
    
    @media (max-width: 768px) {
      .app-container {
        flex-direction: column;
      }
      
      .video-column {
        height: 60vh;
      }
      
      .info-column {
        height: 40vh;
      }
      
      /* ADDED: Adjust nav-buttons for mobile */
      .nav-buttons {
        right: 10px;
        gap: 0.5rem;
      }
      
      .next-video-btn svg, .prev-video-btn svg {
        width: 30px;
        height: 30px;
      }
    }
  </style>
</head>
<body>
    
  <?php if (!empty($allMovies) && $currentMovieId): ?>
    <?php 
    // Find current movie
    $currentMovie = null;
    foreach ($allMovies as $movie) {
        if ($movie['id'] == $currentMovieId) {
            $currentMovie = $movie;
            break;
        }
    }
    ?>
    
    <?php if ($currentMovie): ?>
      <div class="app-container">
        <!-- Video Column -->
        <div class="video-column">
          <div class="video-container">
            <iframe 
              class="video-player"
              src="<?= htmlspecialchars($currentMovie['video_url'] ?? "https://vidsrc.to/embed/movie/{$currentMovieId}") ?>?autoplay=1&mute=1" 
              frameborder="0" 
              allowfullscreen
              allow="autoplay"
            ></iframe>
          </div>
          <!-- CHANGED: Wrapped buttons in nav-buttons container for grouping -->
          <div class="nav-buttons">
            <!-- ADDED: Previous video button -->
            <button class="prev-video-btn" id="prevVideoBtn">
              <img src="assets/up-arrow.png" alt="up-arrow">
            </button>
            <button class="next-video-btn" id="nextVideoBtn">
              <img src="assets/down-arrow.png" alt="down-arrow">
            </button>
          </div>
        </div>
        
        <!-- Info Column -->
        <div class="info-column">
          <h1 class="video-title"><?= htmlspecialchars($currentMovie['title'] ?? 'Untitled') ?></h1>
          
          <div class="video-meta">
            <?php if (!empty($currentMovie['genres'])): ?>
              <?php foreach ($currentMovie['genres'] as $genre): ?>
                <span class="genre-tag"><?= htmlspecialchars($genre) ?></span>
              <?php endforeach; ?>
            <?php endif; ?>
          </div>
          
          <div class="action-buttons">
            <div class="action-button" id="addToListBtn">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white">
                <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
              </svg>
              <span>Add to List</span>
            </div>
            
            <div class="action-button" id="shareBtn">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white">
                <path d="M18 16.08c-.76 0-1.44.3-1.96.77L8.91 12.7c.05-.23.09-.46.09-.7s-.04-.47-.09-.7l7.05-4.11c.54.5 1.25.81 2.04.81 1.66 0 3-1.34 3-3s-1.34-3-3-3-3 1.34-3 3c0 .24.04.47.09.7L8.04 9.81C7.5 9.31 6.79 9 6 9c-1.66 0-3 1.34-3 3s1.34 3 3 3c.79 0 1.5-.31 2.04-.81l7.12 4.16c-.05.21-.08.43-.08.65 0 1.61 1.31 2.92 2.92 2.92 1.61 0 2.92-1.31 2.92-2.92s-1.31-2.92-2.92-2.92z"/>
              </svg>
              <span>Share</span>
            </div>
          </div>
          
          <p class="video-description">
            <?= htmlspecialchars($currentMovie['description'] ?? 'No description available') ?>
          </p>
          
          <?php if (!empty($currentMovie['episodes']) && is_array($currentMovie['episodes'])): ?>
            <div class="episodes-section">
              <div class="episodes-title">All Episodes</div>
              <div class="episode-list">
                <?php foreach ($currentMovie['episodes'] as $index => $episode): ?>
                  <div class="episode-item">
                    EP<?= $index + 1 ?>: <?= htmlspecialchars($episode['title'] ?? 'Episode') ?>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
          <?php endif; ?>
        </div>
      </div>
      
      <!-- MODIFIED: Added scroll event handling and updated keyboard navigation -->
      <script>
        document.addEventListener('DOMContentLoaded', function() {
          const nextVideoBtn = document.getElementById('nextVideoBtn');
          const prevVideoBtn = document.getElementById('prevVideoBtn'); // ADDED: Reference to prev button
          const allMovieIds = <?= json_encode($allMovieIds) ?>;
          const currentMovieId = <?= json_encode($currentMovieId) ?>;
          
          // Navigation function
          function navigateVideo(direction) {
            const currentIndex = allMovieIds.indexOf(currentMovieId);
            let nextIndex;
            if (direction === 'next') {
              nextIndex = (currentIndex + 1) % allMovieIds.length;
            } else if (direction === 'prev') {
              nextIndex = (currentIndex - 1 + allMovieIds.length) % allMovieIds.length;
            }
            window.location.href = `?id=${allMovieIds[nextIndex]}`;
          }
          
          // Next video button click handler
          nextVideoBtn.addEventListener('click', function() {
            navigateVideo('next');
          });
          
          // ADDED: Previous video button click handler
          prevVideoBtn.addEventListener('click', function() {
            navigateVideo('prev');
          });
          
          // MODIFIED: Updated keyboard navigation to include ArrowUp/ArrowDown
          document.addEventListener('keydown', function(e) {
            if (e.key === 'ArrowRight' || e.key === 'ArrowDown') {
              e.preventDefault();
              navigateVideo('next');
            } else if (e.key === 'ArrowLeft' || e.key === 'ArrowUp') {
              e.preventDefault();
              navigateVideo('prev');
            }
          });
          
          // ADDED: Mouse scroll navigation with debounce
          let scrollTimeout;
          document.addEventListener('wheel', function(e) {
            e.preventDefault(); // Prevent default scrolling
            clearTimeout(scrollTimeout);
            scrollTimeout = setTimeout(() => {
              if (e.deltaY > 0) {
                navigateVideo('next'); // Scroll down
              } else if (e.deltaY < 0) {
                navigateVideo('prev'); // Scroll up
              }
            }, 200); // Debounce delay of 200ms
          }, { passive: false });
          
          // Add error handling for video load
          const videoIframe = document.querySelector('.video-player');
          videoIframe.onerror = function() {
            console.error('Error loading video');
          };
        });
      </script>
    <?php endif; ?>
  <?php else: ?>
    <div style="display: flex; justify-content: center; align-items: center; height: 100vh; color: white;">
      <p>No movies available. Please try again later.</p>
    </div>
  <?php endif; ?>
</body>
</html>
