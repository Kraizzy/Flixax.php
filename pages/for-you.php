<?php
include __DIR__ . '/../includes/api-functions.php';

// Fetch movie data from the API
$response = fetchApiData("http://linkskool.net/api/v3/public/movies/all");

// Debug the API response (remove this in production)
// var_dump($response);

// Get the movie ID from the query parameter
$movieId = $_GET['id'] ?? null;

$selectedMovie = null;
$allMovies = [];

// Check if API response is valid
if (isset($response['data']) && is_array($response['data'])) {
    // Flatten movies from all categories into a single array
    $categories = ['hot', 'recommended', 'new_and_trending'];
    foreach ($categories as $category) {
        if (isset($response['data'][$category]) && is_array($response['data'][$category])) {
            foreach ($response['data'][$category] as $movie) {
                if (is_array($movie) && isset($movie['id'])) {
                    $allMovies[] = $movie;
                }
            }
        }
    }

    // If a movie ID is provided, try to find the movie
    if ($movieId && !empty($allMovies)) {
        foreach ($allMovies as $movie) {
            if ((string)$movie['id'] == (string)$movieId) {
                $selectedMovie = $movie;
                break;
            }
        }
    }

    // If no movie was found or no ID was provided, select a random movie
    if (!$selectedMovie && !empty($allMovies)) {
        $selectedMovie = $allMovies[array_rand($allMovies)];
        $movieId = $selectedMovie['id'];
    }
} else {
    $error = "Unable to load movies from the API or invalid response.";
}

// Validate embed type and URL
$iframeUrl = $selectedMovie['video_url'] ?? null;
$iframeValid = true;
if ($iframeUrl) {
    $headers = @get_headers($iframeUrl);
    if (!$headers || strpos($headers[0], '200') === false) {
        $iframeValid = false;
        $iframeError = "The video source is unavailable or invalid.";
    }
} else {
    $iframeValid = false;
    $iframeError = "No video URL available for this movie.";
}

$isTVShow = $selectedMovie && isset($selectedMovie['has_sub_series']) && $selectedMovie['has_sub_series'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Watch Movie</title>
  <link rel="stylesheet" href="assets/style.css">
  <meta http-equiv="Content-Security-Policy" content="frame-src 'self' https://vidsrc.to; default-src 'self'">
  <style>
    body {
  background-color: #1A1A1A;
  color: #FFFFFF;
  font-family: Nunito, sans-serif;
  margin: 0;
}

.video-container {
  display: flex;
  height: 87vh;
  width: 100%;
  margin-top: 5.1rem;
}

.foryou-video-panel {
  flex: 2;
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 0.5rem;
}

.foryou-video-panel iframe {
  width: 100%;
  max-width: 600px;
  height: 100%;
  max-height: 80vh;
  background: #000;
  display: block; /* Ensure iframe doesn't interfere with layout */
}

.episode-big-div {
  flex: 1;
  display: flex;
  flex-direction: column;
  padding: 1rem;
  /* background-color: #FA528C; */
  display: flex;
  gap: 10rem;
  padding-left: 1.2rem;
  align-items: center;
  border-left: 1px solid gray;
  width: 30%;
}

.episode-info-panel {
  display: flex;
  flex-direction: column;
  gap: 2.5rem;
  width: 100%;
}

.episode-content-head {
  display: flex;
  flex-direction: column;
  gap: 2.5rem;
  border-bottom: 1px solid gray;
}

.episode-content-head h3 {
  display: flex;
  color: #FFF;
  margin-top: 0;
  margin-bottom: 0;
  font-family: Nunito;
  font-size: 1.5rem;
  font-style: normal;
  font-weight: 800;
  line-height: 1.875rem; /* 125.472% */
}

.content-head-btn-div {
  display: flex;
  gap: 0.5rem;
}
.episode-content-head-btn-div {
  display: flex;
  margin-bottom: 2.5rem;
  gap: 0.75rem;
}
.genre-tag {
  display: flex;
  border-radius: 0.125rem;
  border: 0.5px solid rgba(255, 255, 255, 0.50);
  background: #313131;
  padding: 0.125rem 0.5rem;
  cursor: pointer;
  justify-content: center;
  align-items: center;
  gap: 0.5625rem;
  color: #FFF;
  font-family: Nunito;
  font-size: 0.875rem;
  font-style: normal;
  font-weight: 600;
}

.showing-div {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  background-color: #333;
  padding: 0.5rem;
  border-radius: 5px;
  width: fit-content;
}

.content-head-icons {
    display: flex;
    gap: 2.5rem;
    align-items: center;
}

.viewcount, .addlist, .share-btn {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  cursor: pointer;
}

.description-content-body p {
  color: rgba(255, 255, 255, 0.50);
  font-family: Nunito;
  font-size: 1rem;
  margin: 0;
  font-style: normal;
  font-weight: 400;
  margin-bottom: 1rem;
}

.episode-dropmenu {
  margin-top: 1rem;
}

.episode-btn {
  background-color: #FA528C;
  color: #FFFFFF;
  border: none;
  padding: 0.5rem 1rem;
  border-radius: 5px;
  cursor: pointer;
  font-size: 1rem;
}

.next-arrow {
  align-self: flex-end;
  cursor: pointer;
}
.back-arrow{
    position: absolute;
    top: 8rem;
    left: 3rem;
    text-align: center;
    width: 3.125rem;
    height: 3.125rem;
    padding: 0.35rem;
    border-radius: 50%;
    background-color: rgba(252, 125, 135, 0.20);
    cursor: pointer;
}
.div1{
  display: flex;
  flex-direction: column;
  gap: 1.25rem;
}
.webkit-scroll-div{
  padding: 1.5rem;
  /* background-color: #5CA8FF; */
  width: 91.7%;
  scrollbar-width: thin;
  scrollbar-color: #0b1624 #222;
  max-height: 84vh;
  overflow-y: auto;
  overflow-x: hidden;
}
.webkit-scroll-div::-webkit-scrollbar {
  width: 0.8rem; /* Adjust scrollbar width */
}
.webkit-scroll-div::-webkit-scrollbar-track {
  background: #212121; /* Scrollbar background (track) */
}
.webkit-scroll-div::-webkit-scrollbar-thumb {
  background-color: #828282; /* Scrollbar handle */
  border-radius: 0.5rem;       /* Optional: rounded corners */
  border: 1px solid #ccc; /* Creates padding inside the track */
}
.path-dir a{
  color: #7A7A7A;
  font-family: "Nunito", sans-serif;
  font-size: 1rem;
}
.path-dir a.active{
  color: #FFF;
}
</style>
</head>
<body>
    <div onclick="window.location.href='<?= $baseUrl ?>/watch'" class="back-arrow">
  <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none">
  <path d="M8.41901 8.1166C8.17554 8.1237 7.94438 8.22526 7.77448 8.3998L1.52448 14.6498C1.34873 14.8256 1.25 15.064 1.25 15.3126C1.25 15.5612 1.34873 15.7997 1.52448 15.9755L7.77448 22.2255C7.86086 22.3155 7.96434 22.3873 8.07883 22.4368C8.19333 22.4863 8.31654 22.5124 8.44127 22.5137C8.56599 22.5149 8.68972 22.4913 8.80519 22.4442C8.92067 22.397 9.02558 22.3273 9.11378 22.2391C9.20197 22.1509 9.27169 22.046 9.31883 21.9305C9.36598 21.815 9.38961 21.6913 9.38834 21.5666C9.38708 21.4419 9.36093 21.3187 9.31145 21.2042C9.26197 21.0897 9.19013 20.9862 9.10016 20.8998L4.4505 16.2501H27.8123C27.9365 16.2519 28.0599 16.2289 28.1752 16.1826C28.2905 16.1363 28.3954 16.0675 28.4839 15.9803C28.5723 15.8931 28.6426 15.7891 28.6905 15.6745C28.7385 15.5599 28.7632 15.4369 28.7632 15.3126C28.7632 15.1884 28.7385 15.0654 28.6905 14.9508C28.6426 14.8362 28.5723 14.7322 28.4839 14.645C28.3954 14.5578 28.2905 14.489 28.1752 14.4427C28.0599 14.3963 27.9365 14.3734 27.8123 14.3751H4.4505L9.10016 9.72549C9.23541 9.59376 9.32775 9.42428 9.36508 9.23921C9.40241 9.05415 9.38301 8.86212 9.3094 8.68827C9.2358 8.51441 9.11142 8.36683 8.95255 8.26483C8.79369 8.16283 8.60773 8.11116 8.41901 8.1166Z" fill="#FA528C"/>
    </svg>
      </div>
<?php if (isset($error)): ?>
  <p><?= htmlspecialchars($error) ?></p>
<?php elseif (!$selectedMovie): ?>
  <p>No valid movie data available.</p>
<?php else: ?>
  <div class="video-container">
    <div class="foryou-video-panel">
      <?php if ($iframeValid): ?>
        <iframe 
          src="<?= htmlspecialchars($iframeUrl) ?>" 
          frameborder="0" 
          allowfullscreen 
          sandbox="allow-same-origin allow-scripts"
          onerror="this.style.display='none'; document.getElementById('iframe-error').style.display='block';">
        </iframe>
        <div id="iframe-error" style="display: none; color: #FF5555;">
          <?= htmlspecialchars($iframeError ?? 'Failed to load the video.') ?>
        </div>
      <?php else: ?>
        <div style="color: #FF5555;">
          <?= htmlspecialchars($iframeError) ?>
        </div>
      <?php endif; ?>
    </div>
    <div class="episode-big-div">
      <div class="episode-info-panel">
        <div class="webkit-scroll-div">
        <div class="episode-content-head">
            <div class="div1">
                <div class="path-dir">
                               <a href="<?= $baseUrl ?>/home">Home/</a>
                               <a href="#" class="passive-path active"><?= htmlspecialchars($selectedMovie['title'] ?? 'Untitled') ?></a>
                           </div>
                           <h3><?= htmlspecialchars($selectedMovie['title'] ?? 'Untitled') ?></h3>
                           <?php if ($isTVShow): ?>
                            <div class="showing-div">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path d="M7.5 3V4.5H16.5V3H7.5ZM5.25 5.25V6.75H18.75V5.25H5.25ZM3 7.5V21H21V7.5H3ZM4.5 9H19.5V19.5H4.5V9ZM9.75 10.2188V18.2812L15.375 14.8828L16.4531 14.25L15.375 13.6172L9.75 10.2188ZM11.25 12.8672L13.5703 14.25L11.25 15.6328V12.8672Z" fill="white"/>
                                </svg>
                                Showing EP.<?= count($selectedMovie['episodes']) ?>/<?= count($selectedMovie['episodes']) ?>
                            </div>
                            <?php endif; ?>
                            <div class="content-head-icons">
                                <div class="viewcount">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none">
                                        <path d="M19.7775 6.32307C19.5231 6.02369 19.1088 5.91369 18.7394 6.04932C18.3706 6.18494 18.125 6.53619 18.125 6.92932V9.68744C18.125 10.2043 17.7044 10.6249 17.1875 10.6249C16.6706 10.6249 16.25 10.2043 16.25 9.68744V3.08432C16.25 2.81557 16.135 2.56057 15.9338 2.38244C15.7256 2.19869 15.6038 2.09557 15.6038 2.09557C15.2562 1.80307 14.7475 1.80182 14.3981 2.09369C14.0144 2.41494 5 10.0449 5 17.4999C5 23.0137 9.48625 27.4999 15 27.4999C20.5138 27.4999 25 23.0137 25 17.4999C25 13.3474 22.16 9.12994 19.7775 6.32307ZM15.1213 25.9356C14.18 25.9631 13.2831 25.6018 12.5431 25.0193C8.9225 22.1699 12.3094 17.6062 14.0781 15.6393C14.5725 15.0899 15.4306 15.0931 15.925 15.6424C17.1237 16.9762 19.0625 19.4999 19.0625 21.8749C19.0625 24.0781 17.3088 25.8712 15.1213 25.9356Z" fill="url(#paint0_linear_812_1147)"/>
                                        <defs>
                                            <linearGradient id="paint0_linear_812_1147" x1="3" y1="6.60616" x2="27.4844" y2="23.0838" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#FFBE00"/>
                                                <stop offset="0.528601" stop-color="#FF55FD"/>
                                                <stop offset="1" stop-color="#7FBBFF"/>
                                            </linearGradient>
                                        </defs>
                                    </svg>
                                    <span>2.5k</span>
                                </div>
                                <div class="addlist">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none">
                                        <path d="M14.9855 3.11144C14.7371 3.11532 14.5004 3.21765 14.3273 3.39595C14.1543 3.57425 14.0591 3.81394 14.0627 4.06237V14.0624H4.06267C3.93844 14.0606 3.8151 14.0836 3.69982 14.1299C3.58453 14.1762 3.47961 14.245 3.39114  archeology .3322C3.30266 14.4194 3.23241 14.5234 3.18446 14.638C3.13651 14.7526 3.11182 14.8756 3.11182 14.9999C3.11182 15.1241 3.13651 15.2471 3.18446 15.3617C3.23241 15.4763 3.30266 15.5803 3.39114 15.6675C3.47961 15.7547 3.58453 15.8235 3.69982 15.8699C3.8151 15.9162 3.93844 15.9391 4.06267 15.9374H14.0627V25.9374C14.0609 26.0616 14.0839 26.1849 14.1302 26.3002C14.1765 26.4155 14.2453 26.5204 14.3325 26.6089C14.4197 26.6974 14.5237 26.7676 14.6383 26.8156C14.7529 26.8635 14.8759 26.8882 15.0002 26.8882C15.1244 26.8882 15.2474 26.8635 15.362 26.8156C15.4766 26.7676 15.5806 26.6974 15.6678 26.6089C15.755 26.5204 15.8238 26.4155 15.8701 26.3002C15.9165 26.1849 15.9394 26.0616 15.9377 25.9374V15.9374H25.9377C26.0619 15.9391 26.1852 15.9162 26.3005 15.8699C26.4158 15.8235 26.5207 15.7547 26.6092 15.6675C26.6977 15.5803 26.7679 15.4763 26.8159 15.3617C26.8638 15.2471 26.8885 15.1241 26.8885 14.9999C26.8885 14.8756 26.8638 14.7526 26.8159 14.638C26.7679 14.5234 26.6977 14.4194 26.6092 14.3322C26.5207 14.245 26.4158 14.1762 26.3005 14.1299C26.1852 14.0836 26.0619 14.0606 25.9377 14.0624H15.9377V4.06237C15.9395 3.93689 15.9161 3.81233 15.8688 3.69606C15.8216 3.5798 15.7515 3.4742 15.6627 3.38552C15.5739 3.29684 15.4682 3.22689 15.3519 3.17981C15.2356 3.13273 15.111 3.10948 14.9855 3.11144Z" fill="white"/>
                                    </svg>
                                    <span>Add to List</span>
                                </div>
                                <div class="share-btn">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none">
                                        <path d="M17.1741 4.37509C16.9278 4.37864 16.6928 4.47898 16.5199 4.65441C16.3469 4.82984 16.25 5.06627 16.25 5.31259V10.1783C14.5889 10.3636 11.8581 10.8396 9.10889 12.6197C5.9875 14.6408 3.21261 18.3565 3.14819 24.4911C3.14726 24.4957 3.14424 24.4986 3.14331 24.5033H3.14575C3.14508 24.5707 3.125 24.6195 3.125 24.6876C3.12525 24.92 3.21184 25.1441 3.36797 25.3163C3.5241 25.4886 3.73865 25.5966 3.96997 25.6196C4.20129 25.6426 4.43289 25.5788 4.61984 25.4406C4.80678 25.3025 4.93574 25.0998 4.98169 24.8719C5.72378 21.1618 8.03698 19.5176 10.6006 18.6744C12.7643 17.9627 14.8828 17.9625 16.25 18.0348V22.8126C16.2501 22.998 16.3051 23.1792 16.4081 23.3333C16.5111 23.4874 16.6575 23.6075 16.8288 23.6785C17.0001 23.7494 17.1885 23.768 17.3704 23.7318C17.5522 23.6957 17.7192 23.6065 17.8503 23.4754L26.6003 14.7254C26.7761 14.5496 26.8748 14.3112 26.8748 14.0626C26.8748 13.814 26.7761 13.5756 26.6003 13.3998L17.8503 4.64975C17.7617 4.56108 17.6562 4.49109 17.54 4.44391C17.4239 4.39673 17.2994 4.37333 17.1741 4.37509ZM18.125 7.57578L24.6118 14.0626L18.125 20.5494V17.1156C18.1251 16.8821 18.0381 16.6569 17.8809 16.4842C17.7238 16.3115 17.5079 16.2036 17.2754 16.1817C15.9729 16.0598 12.9935 15.9136 10.0146 16.8934C8.62295 17.3511 7.24089 18.1215 6.05469 19.2225C7.0041 16.9011 8.46608 15.2706 10.1282 14.1944C12.8619 12.4244 16.0033 11.9941 17.2559 11.9019C17.492 11.8847 17.7129 11.7786 17.8741 11.6052C18.0354 11.4317 18.125 11.2037 18.125 10.9669V7.57578Z" fill="white"/>
                                    </svg>
                                    <span>Share</span>
                                </div>
                            </div>
                        </div>
                        <div class="div">
                            <div class="description-content-body">
                                <p><?= htmlspecialchars($selectedMovie['description'] ?? 'No description available.') ?></p>
                            </div>
                            <div class="episode-content-head-btn-div">
                              <?php if (!empty($selectedMovie['genres'])): ?>             
                                 <?php foreach ($selectedMovie['genres'] as $genre): ?>
                                  <span class="genre-tag"><?= htmlspecialchars($genre) ?></span>
                                <?php endforeach; ?>
                              <?php endif; ?>
                            </div>
                        </div>
            </div>
        </div>
        <?php if ($isTVShow): ?>
          <div class="episode-dropmenu">
            <button class="episode-btn">ALL EPISODES</button>
          </div>
        <?php endif; ?>
      </div>
  </div>
<?php endif; ?>
</body>
</html>