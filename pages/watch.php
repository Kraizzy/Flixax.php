<?php
include __DIR__ . '/../includes/api-functions.php';

// Fetch all movies for initial page
$response = fetchApiData("http://linkskool.net/api/v3/public/movies/shorts");
$allMovies = $response['data'] ?? [];
$allMovieIds = array_column($allMovies, 'id');

$currentMovieId = $_GET['id'] ?? ($allMovieIds[array_rand($allMovieIds)] ?? null);
$currentMovie = null;

if ($currentMovieId) {
  foreach ($allMovies as $movie) {
    if ($movie['id'] == $currentMovieId) {
      $currentMovie = $movie;
      break;
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
      font-family: "Nunito", -apple-system, BlinkMacSystemFont, sans-serif;
      overflow-y: auto;
    }

    .app-container {
      display: flex;
      margin-top: 4rem;
      height: 92vh;
      padding: 0.9rem 1.5rem;
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
      margin-left: 0.98rem;
      padding: 20px;
      height: 40vh;
      overflow-y: auto;
      background: rgba(0, 0, 0, 0.7);
    }

    .video-container {
      position: relative;
      height: 97.5%;
      user-select: none;
      width: 80%;
    }

    .video-player {
      width: 95%;
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
      flex-direction: column;
      gap: 1rem;
      /* ADDED: 1rem gap between buttons */
      z-index: 20;
    }

    .next-video-btn,
    .prev-video-btn {
      /* MODIFIED: Added prev-video-btn */
      background: none;
      display: none;
      border: none;
      cursor: pointer;
    }

    .next-video-btn svg,
    .prev-video-btn svg {
      /* MODIFIED: Added prev-video-btn svg */
      width: 40px;
      height: 40px;
      filter: drop-shadow(0 0 5px rgba(0, 0, 0, 0.5));
    }

    .video-title {
      font-size: 1.8rem;
      font-weight: bold;
      margin-bottom: 15px;
    }

    .lazy-video {
      position: relative;
      width: 95%;
      height: 100%;
      user-select: none;
      object-fit: cover;
    }

    .video-thumb {
      width: 100%;
      height: 100%;
      object-fit: cover;
      display: block;
    }

    .video-info {
      padding: 10px 12px;
    }

    .video-meta {
      display: flex;
      gap: 15px;
      margin-bottom: 15px;
      font-size: 0.9rem;
    }

    .genre-tag {
      background: rgba(255, 255, 255, 0.2);
      padding: 3px 8px;
      border-radius: 4px;
    }

    .video-description {
      font-size: 1rem;
      color: #fff;
      line-height: 1.4;
      max-height: 3.5em;
      overflow: hidden;

    }

    .action-buttons {
      display: flex;
      gap: 20px;
      margin-bottom: 30px;
    }

    .nav-buttons img {
      width: 3rem;
      height: 3rem;
      border-radius: 50%;
    }

    .action-button {
      display: flex;
      align-items: center;
      padding: 5px 6px;
      border-radius: 5px;
      border: solid 1px rgba(255, 255, 255, 0.05);
      background: rgba(255, 255, 255, 0.08);
      gap: 5px;
      cursor: pointer;
      transition: background 0.2s ease;
    }

    .action-button:hover {
      background: rgba(194, 72, 72, 0.6);
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
      background: rgba(255, 255, 255, 0.1);
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

      .next-video-btn svg,
      .prev-video-btn svg {
        width: 30px;
        height: 30px;
      }
    }

    /* Skeleton styles */
    .skeleton {
      background: linear-gradient(90deg, #333 25%, #444 50%, #333 65%);
      background-size: 200% 100%;
      animation: shimmer 1.2s infinite;
      border-radius: 4px;
    }

    @keyframes shimmer {
      0% {
        background-position: 200% 0;
      }

      100% {
        background-position: -200% 0;
      }
    }

    .skeleton-text {
      height: 20px;
      margin: 20px 0;
      width: 100%;
    }

    .skeleton-title {
      height: 32px;
      width: 100%;
      margin-top: 20px;
      margin-bottom: 20px;
    }

    .skeleton-genre {
      width: 80px;
      height: 20px;
      margin-right: 10px;
    }

    .skeleton-btn {
      width: 60px;
      height: 60px;
      border-radius: 6px;
    }

    .skeleton-video {
      height: 85%;
      width: 85%;
      margin-left: 15px;
      border-radius: 10px;
    }
  </style>
</head>

<body>
  <main class="video-feed">
    <div class="app-container">
      <!-- Video Column -->
      <div class="video-column">
        <div id="videoSkeleton" class="skeleton skeleton-video" style="display: block;"></div>

        <video id="videoPlayer" class="video-player" autoplay controls playsinline style="display: none;">
          <source src="" type="video/mp4">
        </video>

        <div class="nav-buttons">
          <button class="prev-video-btn" id="prevVideoBtn">
            <img src="assets/up-arrow.png" alt="Previous">
          </button>
          <button class="next-video-btn" id="nextVideoBtn">
            <img src="assets/down-arrow.png" alt="Next">
          </button>
        </div>
      </div>

      <!-- Info Column -->
      <div class="info-column" id="infoColumn" style="display: none;"></div>
    </div>

    <!-- Video Feed Grid -->
    <div class="video-feed-container" id="videoFeed"">
      <!-- Cards injected here -->
    </div>
  </main>

  <div id=" loading" class="loading-spinner" style="display: none;">Loading...</div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
      const currentMovieId = "<?= $currentMovieId ?>";
      const allMovieIds = <?= json_encode($allMovieIds) ?>;
      let currentIndex = allMovieIds.indexOf(currentMovieId);

      function fetchMovieInfo(id) {
        $('#infoColumn').hide();
        $('#videoPlayer').hide();
        $('#videoSkeleton').show();

        $.getJSON('pages/get-movie.php', {
          id
        }, function(data) {
          if (!data) return;

          // Update video source
          const videoPlayer = $('#videoPlayer');
          videoPlayer.find('source').attr('src', data.video_url);
          videoPlayer[0].load(); // Force reload
          videoPlayer.show();

          $('#videoSkeleton').hide();

          // Build info HTML
          let html = `
          <h1 class="video-title">${data.title}</h1>
          <div class="video-meta">
            ${(data.genres || []).map(g => `<span class="genre-tag">${g}</span>`).join('')}
          </div>
          <div class="action-buttons">
            <div class="action-button gas-button"><img src="assets/icons8_gas 1.svg" alt="0k" height="30" width="30"><span class="gas-count">0</span></div>
            <div class="action-button"> <img src="assets/icons8_plus_math 1.svg" alt="+" height="30" width="30"> Add to List</div>
            <div class="action-button"> <img src="assets/icons8_forward_arrow 1.svg" alt="Share" height="30" width="30"> Share</div>
          </div>
          <p class="video-description">${data.description || ''}</p>
        `;

          if (Array.isArray(data.episodes) && data.episodes.length > 0) {
            html += `
            <div class="episodes-section">
              <div class="episodes-title">All Episodes</div>
              <div class="episode-list">
                ${data.episodes.map((ep, i) => `<div class="episode-item">EP${i + 1}: ${ep.title}</div>`).join('')}
              </div>
            </div>
          `;
          }

          $('#infoColumn').html(html).show();
        });
      }

      function changeVideo(indexDelta) {
        currentIndex = (currentIndex + indexDelta + allMovieIds.length) % allMovieIds.length;
        fetchMovieInfo(allMovieIds[currentIndex]);
      }

      $(document).ready(function() {
        fetchMovieInfo(currentMovieId);

        // Nav buttons
        $('#nextVideoBtn').click(() => changeVideo(1));
        $('#prevVideoBtn').click(() => changeVideo(-1));

        // Keyboard nav
        document.addEventListener('keydown', (e) => {
          if (['ArrowRight', 'ArrowDown'].includes(e.key)) {
            e.preventDefault();
            changeVideo(1);
          } else if (['ArrowLeft', 'ArrowUp'].includes(e.key)) {
            e.preventDefault();
            changeVideo(-1);
          }
        });
        // Error log
        document.querySelector('#videoPlayer').addEventListener('error', () => {
          console.error('Error loading video');
        });
      });
    </script>

    <!-- Lazy Loading Feed + Infinite Scroll -->
    <script>
      $(document).on('click', '.gas-button', function () {
  const countEl = $(this).find('.gas-count');
  let currentText = countEl.text().trim();

  // Convert "0k", "1k" to numbers
  let num = parseInt(currentText.replace('k', '')) || 0;

  // Increment
  num += 1;

  // Update with "k" suffix
  countEl.text(num >= 1000 ? `${Math.floor(num / 1000)}k` : num);
});
      let currentPage = 1;
      let loading = false;
      const limit = 3;

      // Create an IntersectionObserver to watch thumbnails
      const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          const el = entry.target;

          if (entry.isIntersecting) {
            // If it's an image placeholder and hasn't been replaced yet
            if (el.tagName === 'IMG' && el.dataset.video) {
              const video = document.createElement('video');
              video.controls = true;
              video.autoplay = true;
              video.loop = true;
              video.playsInline = true;
              video.muted = true; // Avoid autoplay restrictions
              video.classList.add('lazy-video');

              const source = document.createElement('source');
              source.src = el.dataset.video;
              source.type = 'video/mp4';
              video.appendChild(source);

              el.parentNode.replaceChild(video, el);

              // Observe new video for play/pause based on visibility
              observer.observe(video);
            }

            // If it's already a video, play it
            if (el.tagName === 'VIDEO') {
              el.play().catch(() => {});
            }
          } else {
            if (el.tagName === 'VIDEO') {
              el.pause();
            }
          }
        });
      }, {
        root: null,
        threshold: 0.6 // 60% visible to trigger play/pause
      });


      function fetchBatch(page) {
        if (loading) return;
        loading = true;
        $('#loading').show();

        $.getJSON(`pages/get-movie-batch.php?page=${page}&limit=${limit}`, function(movies) {
          if (Array.isArray(movies) && movies.length > 0) {
            movies.forEach(movie => {
              const card = `
          <div class="app-container" data-id="${movie.id}">
            <div class="video-column">
              <img src="${movie.poster || 'fallback.jpg'}" alt="${movie.title}" class="video-thumb" data-video="${movie.video_url}">
            </div>
            <div class="info-column">
              <h3 class="video-title">${movie.title}</h3>
              <div class="video-meta">
                ${(movie.genres || []).map(g => `<span class="genre-tag">${g}</span>`).join('')}
              </div>
              <div class="action-buttons">
              <div class="action-button gas-button"><img src="assets/icons8_gas 1.svg" alt="0k" height="25" width="25"><span class="gas-count">0</span></div>
            <div class="action-button"><img src="assets/icons8_plus_math 1.svg" alt="+" height="25" width="25"> Add to List</div>
            <div class="action-button"><img src="assets/icons8_forward_arrow 1.svg" alt="Share"> Share</div>
          </div>
              <p class="video-description">${movie.description || ''}</p>
            </div>
            
          </div>
        `;
              $('#videoFeed').append(card);
            });

            // After appending, observe all new thumbnails for autoplay
            $('.video-thumb').each((_, img) => {
              observer.observe(img);
            });
          }

          $('#loading').hide();
          loading = false;
          currentPage++;
        });
      }

      // $(document).off('click', '.video-thumb');

      $(window).on('scroll', function() {
        const nearBottom = $(window).scrollTop() + $(window).height() + 100 >= $(document).height();
        if (nearBottom && !loading) {
          fetchBatch(currentPage);
        }
      });

      $(document).ready(function() {
        fetchBatch(currentPage);
      });
    </script>
</body>

</html>