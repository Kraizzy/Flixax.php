<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home</title>
  <link rel="stylesheet" href="/assets/css/style.css"> 

  <style>
    .skeleton-card {
  flex: 0 0 295px;
  scroll-snap-align: start;
  background: #222;
  height: 32rem;
  border-radius: 8px;
  overflow: hidden;
  position: relative;
  display: flex;
  flex-direction: column;
  animation: shimmer 1.5s infinite linear;
  background: linear-gradient(90deg, #222 25%, #333 50%, #222 75%);
  background-size: 200% 100%;
}

@keyframes shimmer {
  0% { background-position: -200% 0; }
  100% { background-position: 200% 0; }
}

.skeleton-image {
  width: 100%;
  height: 24rem;
  background: #333;
  border-radius: 5.6px;
}

.skeleton-title {
  height: 16px;
  background: #333;
  border-radius: 4px;
  width: 100%;
}
/* Hero Section */
.skeleton-slide-img {
  width: 100%;
  height: 100%;
  background: linear-gradient(90deg, #1a1a1a 25%, #333 50%, #1a1a1a 75%);
  background-size: 200% 100%;
  animation: shimmer 1.5s infinite;
}

.skeleton-title {
  width: 300px;
  height: 2.5rem;
  background: #2a2a2a;
  margin-bottom: 1rem;
  border-radius: 4px;
  animation: shimmer 1.5s infinite;
}

.skeleton-button {
  width: 10rem;
  height: 2.75rem;
  background: #2a2a2a;
  border-radius: 6px;
  animation: shimmer 1.5s infinite;
}

@keyframes shimmer {
  0% { background-position: -200% 0; }
  100% { background-position: 200% 0; }
}
  </style>
</head>

<body>




  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const slides = document.querySelectorAll(".slide");
      const dots = document.querySelectorAll(".dot");
      const prevArrow = document.querySelector(".slider-prev");
      const nextArrow = document.querySelector(".slider-next");

      let current = 0;

      function showSlide(index) {
        slides.forEach((s, i) => {
          s.classList.toggle("active", i === index);
          dots[i].classList.toggle("active", i === index);
        });
        current = index;
      }

      // Handle next arrow click
      nextArrow.addEventListener("click", () => {
        let nextIndex = (current + 1) % slides.length; // Loop back to first slide
        showSlide(nextIndex);
      });

      // Handle previous arrow click
      prevArrow.addEventListener("click", () => {
        let prevIndex = (current - 1 + slides.length) % slides.length; // Loop back to last slide
        showSlide(prevIndex);
      });

      // Dot Navigation
      dots.forEach((dot, i) => {
        dot.addEventListener("click", () => showSlide(i));
      });

      // Autoplay every 5s
      setInterval(() => {
        let next = (current + 1) % slides.length;
        showSlide(next);
      }, 5000);
    });
  </script>
  <!-- ==================================
           +  HERO SECTION +
    =================================== -->

  <?php
  include __DIR__ . '/../includes/api-functions.php';

  $response = fetchApiData("http://linkskool.net/api/v3/public/movies/all");
  $slides = [];

  if ($response && isset($response['data']['hot'])) {
    $slides = $response['data']['hot'];
  }

  ?>

  <div class="hero-section">
    <div class="shadow-overlay"></div>
    <div class="slides">
      <?php if (!empty($slides)): ?>
        <?php foreach ($slides as $index => $slide): ?>
          <div class="slide<?= $index === 0 ? ' active' : '' ?>">
            <img src="<?= htmlspecialchars($slide['poster_landscape']) ?>" alt="<?= htmlspecialchars($slide['title']) ?>" />
            <div class="hero-content">
              <h1><?= htmlspecialchars($slide['title']) ?></h1>
              <button onclick="window.location.href='<?= $baseUrl ?>/for-you?id=<?= htmlspecialchars($slide['id']) ?>'">
                <span><img src="assets/Vector.svg" alt="Play" /></span> Play Now
              </button>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
          <!-- Show skeleton loader -->
      <div class="slides hero-skeleton">
        <div class="slide active">
          <div class="skeleton-slide-img"></div>
          <div class="hero-content">
            <div class="skeleton-title"></div>
            <div class="skeleton-button"></div>
          </div>
        </div>
      </div>
      <?php endif; ?>
    </div>

    <!-- Left Arrow -->
    <button class="slider-arrow slider-prev" aria-label="Previous slide">
      <svg width="24" height="24" fill="white" viewBox="0 0 24 24">
        <path d="M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12z" />
      </svg>
    </button>

    <!-- Right Arrow -->
    <button class="slider-arrow slider-next" aria-label="Next slide">
      <svg width="30" height="30" fill="white" viewBox="0 0 24 24">
        <path d="M8.59 16.59L10 18l6-6-6-6-1.41 1.41L13.17 12z" />
      </svg>
    </button>

    <div class="dots">
      <?php if (!empty($slides)): ?>
        <?php foreach ($slides as $index => $slide): ?>
          <span class="dot<?= $index === 0 ? ' active' : '' ?>"></span>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </div>

  <!-- ===========================
        + NEW AND HOT SECTION +
    =========================== -->

  <div class="fore-div">
    <?php
    $response = fetchApiData("http://linkskool.net/api/v3/public/movies/all");
    $slides = [];
    if ($response && isset($response['success']) && $response['success']) {
      // Assuming the API returns the structure you showed earlier,
      // and 'hot' is inside 'data'
      $new_and_hot_item = $response['data']['hot'];
    }
    ?>
    <div class="animate-on-scroll">
      <div class="newandHot-title">
        <h2>New and HOT<span>&#33;</span></h2>
        <div class="arrow-div">
          <div class="arrow-icon" style="padding-left: 0.725rem">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="14"
              height="26"
              viewBox="0 0 14 26"
              fill="none">
              <path
                d="M13.0018 0.7699C12.771 0.776628 12.5518 0.87293 12.3907 1.03842L0.835167 12.594C0.66853 12.7607 0.574921 12.9867 0.574921 13.2224C0.574921 13.4582 0.66853 13.6842 0.835167 13.8509L12.3907 25.4065C12.4726 25.4918 12.5707 25.5599 12.6793 25.6068C12.7879 25.6537 12.9047 25.6785 13.0229 25.6797C13.1412 25.6809 13.2585 25.6585 13.368 25.6138C13.4775 25.5691 13.577 25.503 13.6606 25.4194C13.7442 25.3358 13.8103 25.2363 13.855 25.1268C13.8997 25.0173 13.9221 24.9 13.9209 24.7817C13.9197 24.6635 13.8949 24.5467 13.848 24.4381C13.8011 24.3295 13.733 24.2314 13.6477 24.1495L2.72058 13.2224L13.6477 2.29536C13.7759 2.17047 13.8634 2.00977 13.8988 1.8343C13.9342 1.65883 13.9158 1.47677 13.8461 1.31193C13.7763 1.14708 13.6583 1.00715 13.5077 0.910442C13.3571 0.813731 13.1808 0.764747 13.0018 0.7699Z"
                fill="white"
                fill-opacity="0.5" />
            </svg>
          </div>
          <div class="arrow-icon" style="padding-left: 0.725rem">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="14"
              height="26"
              viewBox="0 0 14 26"
              fill="none">
              <path
                d="M1.34793 0.7699C1.57878 0.776628 1.79795 0.87293 1.95904 1.03842L13.5146 12.594C13.6812 12.7607 13.7748 12.9867 13.7748 13.2224C13.7748 13.4582 13.6812 13.6842 13.5146 13.8509L1.95904 25.4065C1.87713 25.4918 1.77903 25.5599 1.67047 25.6068C1.56191 25.6537 1.44508 25.6785 1.32683 25.6797C1.20857 25.6809 1.09126 25.6585 0.981771 25.6138C0.872281 25.5691 0.772811 25.503 0.689186 25.4194C0.605562 25.3358 0.539464 25.2363 0.494762 25.1268C0.450061 25.0173 0.427656 24.9 0.428858 24.7817C0.43006 24.6635 0.454845 24.5467 0.501763 24.4381C0.548681 24.3295 0.616789 24.2314 0.702097 24.1495L11.6292 13.2224L0.702097 2.29536C0.573859 2.17047 0.486313 2.00977 0.450914 1.8343C0.415516 1.65883 0.433914 1.47677 0.503703 1.31193C0.573491 1.14708 0.691419 1.00715 0.842051 0.910442C0.992682 0.813731 1.169 0.764747 1.34793 0.7699Z"
                fill="white"
                fill-opacity="0.5" />
            </svg>
          </div>
        </div>
      </div>
      <div class="card-grid">
  <?php if (!empty($new_and_hot_item)): ?>
    <?php foreach ($new_and_hot_item as $item): ?>
      <div class="card">
        <a style="text-decoration: none; color: white;" href="<?= $baseUrl ?>/for-you?id=<?= htmlspecialchars($item['id']) ?>">
          <div class="new-ribbon">NEW</div>
          <img src="<?= htmlspecialchars($item['poster_portrait']) ?>" alt="Card Image" class="card-image" />
          <div class="card-overlay">
            <div class="overlayTypo">
              <h3><?= htmlspecialchars($item['title']) ?></h3>
              <p class="genre"><?= htmlspecialchars(implode(", ", $item['genres'])) ?></p>
              <p class="description">
                <?php
                  $description = $item['description'] ?? 'No description';
                  $maxLength = 200;
                  if (strlen($description) > $maxLength) {
                    $description = substr($description, 0, $maxLength) . '....';
                  }
                  echo htmlspecialchars($description, ENT_QUOTES, 'UTF-8');
                ?>
              </p>
            </div>
            <a href="<?= $baseUrl ?>/for-you?id=<?= htmlspecialchars($item['id']) ?>">
              <button class="watch-button">▶ Watch now</button>
            </a>
          </div>
          <div class="card-content">
            <p class="movieTitle"><?= htmlspecialchars($item['title']) ?></p>
          </div>
        </a>
      </div>
    <?php endforeach; ?>
  <?php else: ?>
    <!-- Render skeleton placeholders immediately if no data -->
    <?php for ($i = 0; $i < 8; $i++): ?>
      <div class="skeleton-card">
        <div class="skeleton-ribbon">New</div>
        <div class="skeleton-image"></div>
        <div class="card-overlay"></div>
        <div class="card-content"></div>
        <div class="skeleton-title"></div>
      </div>
    <?php endfor; ?>
    <?php endif;?>
</div>

<!-- ===========================
        + M0ST TRENDING +
    =========================== -->

  <div class="fore-div" style="width: 100%;">
    <?php
    $response = fetchApiData("http://linkskool.net/api/v3/public/movies/all");
    $slides = [];
    if ($response && isset($response['success']) && $response['success']) {
      // Assuming the API returns the structure you showed earlier,
      // and 'hot' is inside 'data'
      $mostTrending = $response['data']['new_and_trending'];
    }
    ?>
    <div class="animate-on-scroll">
      <div class="newandHot-title">
        <h2>Most Trending</h2>
        <div class="arrow-div">
          <div class="arrow-icon" style="padding-left: 0.725rem">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="14"
              height="26"
              viewBox="0 0 14 26"
              fill="none">
              <path
                d="M13.0018 0.7699C12.771 0.776628 12.5518 0.87293 12.3907 1.03842L0.835167 12.594C0.66853 12.7607 0.574921 12.9867 0.574921 13.2224C0.574921 13.4582 0.66853 13.6842 0.835167 13.8509L12.3907 25.4065C12.4726 25.4918 12.5707 25.5599 12.6793 25.6068C12.7879 25.6537 12.9047 25.6785 13.0229 25.6797C13.1412 25.6809 13.2585 25.6585 13.368 25.6138C13.4775 25.5691 13.577 25.503 13.6606 25.4194C13.7442 25.3358 13.8103 25.2363 13.855 25.1268C13.8997 25.0173 13.9221 24.9 13.9209 24.7817C13.9197 24.6635 13.8949 24.5467 13.848 24.4381C13.8011 24.3295 13.733 24.2314 13.6477 24.1495L2.72058 13.2224L13.6477 2.29536C13.7759 2.17047 13.8634 2.00977 13.8988 1.8343C13.9342 1.65883 13.9158 1.47677 13.8461 1.31193C13.7763 1.14708 13.6583 1.00715 13.5077 0.910442C13.3571 0.813731 13.1808 0.764747 13.0018 0.7699Z"
                fill="white"
                fill-opacity="0.5" />
            </svg>
          </div>
          <div class="arrow-icon" style="padding-left: 0.725rem">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="14"
              height="26"
              viewBox="0 0 14 26"
              fill="none">
              <path
                d="M1.34793 0.7699C1.57878 0.776628 1.79795 0.87293 1.95904 1.03842L13.5146 12.594C13.6812 12.7607 13.7748 12.9867 13.7748 13.2224C13.7748 13.4582 13.6812 13.6842 13.5146 13.8509L1.95904 25.4065C1.87713 25.4918 1.77903 25.5599 1.67047 25.6068C1.56191 25.6537 1.44508 25.6785 1.32683 25.6797C1.20857 25.6809 1.09126 25.6585 0.981771 25.6138C0.872281 25.5691 0.772811 25.503 0.689186 25.4194C0.605562 25.3358 0.539464 25.2363 0.494762 25.1268C0.450061 25.0173 0.427656 24.9 0.428858 24.7817C0.43006 24.6635 0.454845 24.5467 0.501763 24.4381C0.548681 24.3295 0.616789 24.2314 0.702097 24.1495L11.6292 13.2224L0.702097 2.29536C0.573859 2.17047 0.486313 2.00977 0.450914 1.8343C0.415516 1.65883 0.433914 1.47677 0.503703 1.31193C0.573491 1.14708 0.691419 1.00715 0.842051 0.910442C0.992682 0.813731 1.169 0.764747 1.34793 0.7699Z"
                fill="white"
                fill-opacity="0.5" />
            </svg>
          </div>
        </div>
      </div>
      <div class="card-grid">
        <?php if (!empty($mostTrending)): ?>
          <?php foreach ($mostTrending as $item): ?>
            <div class="card">
              <a style="text-decoration: none; color: white;" href="<?= $baseUrl ?>/for-you?id=<?= htmlspecialchars($item['id']) ?>">
                <div class="new-ribbon">TRENDING</div>
                <img src="<?= htmlspecialchars($item['poster_portrait']) ?>" alt="Card Image" class="card-image" />
                <div class="card-overlay">
                  <div class="overlayTypo">
                    <h3><?= htmlspecialchars($item['title']) ?></h3>
                    <p class="genre"><?= htmlspecialchars(implode(", ", $item['genres'])) ?></p>
                    <p class="description">
                      <?php
                        $description = $item['description'] ?? 'No description';
                        $maxLength = 200;
                        if (strlen($description) > $maxLength) {
                          $description = substr($description, 0, $maxLength) . '....';
                        }
                        echo htmlspecialchars($description, ENT_QUOTES, 'UTF-8');
                      ?>
                    </p>
                  </div>
                  <a href="<?= $baseUrl ?>/for-you?id=<?= htmlspecialchars($item['id']) ?>">
                    <button class="watch-button">▶ Watch now</button>
                  </a>
                </div>
                <div class="card-content">
                  <p class="movieTitle"><?= htmlspecialchars($item['title']) ?></p>
                </div>
              </a>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <!-- Render skeleton placeholders immediately if no data -->
          <?php for ($i = 0; $i < 8; $i++): ?>
            <div class="skeleton-card">
              <div class="skeleton-image"></div>
              <div class="skeleton-title"></div>
              <div class="skeleton-text"></div>
            </div>
          <?php endfor; ?>
        <?php endif; ?>
      </div>
    </div>
  </div>


    <!-- ===========================
        + MOST TRENDING +
    =========================== -->

  <div class="fore-div" style="width: 100%;">
    <?php
    $response = fetchApiData("http://linkskool.net/api/v3/public/movies/all");
    $slides = [];
    if ($response && isset($response['success']) && $response['success']) {
      // Assuming the API returns the structure you showed earlier,
      // and 'hot' is inside 'data'
      $mostTrending = $response['data']['new_and_trending'];
    }
    ?>
    <div class="animate-on-scroll">
      <div class="newandHot-title">
        <h2>Most Watched</h2>
        <div class="arrow-div">
          <div class="arrow-icon" style="padding-left: 0.725rem">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="14"
              height="26"
              viewBox="0 0 14 26"
              fill="none">
              <path
                d="M13.0018 0.7699C12.771 0.776628 12.5518 0.87293 12.3907 1.03842L0.835167 12.594C0.66853 12.7607 0.574921 12.9867 0.574921 13.2224C0.574921 13.4582 0.66853 13.6842 0.835167 13.8509L12.3907 25.4065C12.4726 25.4918 12.5707 25.5599 12.6793 25.6068C12.7879 25.6537 12.9047 25.6785 13.0229 25.6797C13.1412 25.6809 13.2585 25.6585 13.368 25.6138C13.4775 25.5691 13.577 25.503 13.6606 25.4194C13.7442 25.3358 13.8103 25.2363 13.855 25.1268C13.8997 25.0173 13.9221 24.9 13.9209 24.7817C13.9197 24.6635 13.8949 24.5467 13.848 24.4381C13.8011 24.3295 13.733 24.2314 13.6477 24.1495L2.72058 13.2224L13.6477 2.29536C13.7759 2.17047 13.8634 2.00977 13.8988 1.8343C13.9342 1.65883 13.9158 1.47677 13.8461 1.31193C13.7763 1.14708 13.6583 1.00715 13.5077 0.910442C13.3571 0.813731 13.1808 0.764747 13.0018 0.7699Z"
                fill="white"
                fill-opacity="0.5" />
            </svg>
          </div>
          <div class="arrow-icon" style="padding-left: 0.725rem">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="14"
              height="26"
              viewBox="0 0 14 26"
              fill="none">
              <path
                d="M1.34793 0.7699C1.57878 0.776628 1.79795 0.87293 1.95904 1.03842L13.5146 12.594C13.6812 12.7607 13.7748 12.9867 13.7748 13.2224C13.7748 13.4582 13.6812 13.6842 13.5146 13.8509L1.95904 25.4065C1.87713 25.4918 1.77903 25.5599 1.67047 25.6068C1.56191 25.6537 1.44508 25.6785 1.32683 25.6797C1.20857 25.6809 1.09126 25.6585 0.981771 25.6138C0.872281 25.5691 0.772811 25.503 0.689186 25.4194C0.605562 25.3358 0.539464 25.2363 0.494762 25.1268C0.450061 25.0173 0.427656 24.9 0.428858 24.7817C0.43006 24.6635 0.454845 24.5467 0.501763 24.4381C0.548681 24.3295 0.616789 24.2314 0.702097 24.1495L11.6292 13.2224L0.702097 2.29536C0.573859 2.17047 0.486313 2.00977 0.450914 1.8343C0.415516 1.65883 0.433914 1.47677 0.503703 1.31193C0.573491 1.14708 0.691419 1.00715 0.842051 0.910442C0.992682 0.813731 1.169 0.764747 1.34793 0.7699Z"
                fill="white"
                fill-opacity="0.5" />
            </svg>
          </div>
        </div>
      </div>
      <div class="card-grid">
        <?php foreach ($new_and_hot_item as $item): ?>
          <div class="card">
            <a style="text-decoration: none; color: white;" href="<?= $baseUrl ?>/for-you?id=<?= htmlspecialchars($item['id']) ?>">
              <img src="<?= htmlspecialchars($item['poster_portrait']) ?>" alt="Card Image" class="card-image" />
              <div class="card-overlay-most-trend">
                <div class="overlayTypo">
                  <h3><?= htmlspecialchars($item['title']) ?></h3>
                  <p class="genre"><?= htmlspecialchars(implode(", ", $item['genres'])) ?></p>
                </div>
              </div>
            </a>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>

    </div>
  </div>

  <!-- ===========================
        + YOU MIGHT ALSO LIKE SECTION +
    =========================== -->
  <div class="section5-div">
    <?php
    $response = fetchApiData("http://linkskool.net/api/v3/public/movies/all");
    $slides = [];
    if ($response && isset($response['success']) && $response['success']) {
      // Assuming the API returns the structure you showed earlier,
      // and 'hot' is inside 'data'
      $mostTrending = $response['data']['recommended'];
    }
    ?>
    <div class="animate-on-scroll">
      <div class="newandHot-title">
        <h2>You Might Also Like...</h2>
        <div class="arrow-div">
          <div class="arrow-icon" style="padding-left: 0.725rem">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="14"
              height="26"
              viewBox="0 0 14 26"
              fill="none">
              <path
                d="M13.0018 0.7699C12.771 0.776628 12.5518 0.87293 12.3907 1.03842L0.835167 12.594C0.66853 12.7607 0.574921 12.9867 0.574921 13.2224C0.574921 13.4582 0.66853 13.6842 0.835167 13.8509L12.3907 25.4065C12.4726 25.4918 12.5707 25.5599 12.6793 25.6068C12.7879 25.6537 12.9047 25.6785 13.0229 25.6797C13.1412 25.6809 13.2585 25.6585 13.368 25.6138C13.4775 25.5691 13.577 25.503 13.6606 25.4194C13.7442 25.3358 13.8103 25.2363 13.855 25.1268C13.8997 25.0173 13.9221 24.9 13.9209 24.7817C13.9197 24.6635 13.8949 24.5467 13.848 24.4381C13.8011 24.3295 13.733 24.2314 13.6477 24.1495L2.72058 13.2224L13.6477 2.29536C13.7759 2.17047 13.8634 2.00977 13.8988 1.8343C13.9342 1.65883 13.9158 1.47677 13.8461 1.31193C13.7763 1.14708 13.6583 1.00715 13.5077 0.910442C13.3571 0.813731 13.1808 0.764747 13.0018 0.7699Z"
                fill="white"
                fill-opacity="0.5" />
            </svg>
          </div>
          <div class="arrow-icon" style="padding-left: 0.725rem">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="14"
              height="26"
              viewBox="0 0 14 26"
              fill="none">
              <path
                d="M1.34793 0.7699C1.57878 0.776628 1.79795 0.87293 1.95904 1.03842L13.5146 12.594C13.6812 12.7607 13.7748 12.9867 13.7748 13.2224C13.7748 13.4582 13.6812 13.6842 13.5146 13.8509L1.95904 25.4065C1.87713 25.4918 1.77903 25.5599 1.67047 25.6068C1.56191 25.6537 1.44508 25.6785 1.32683 25.6797C1.20857 25.6809 1.09126 25.6585 0.981771 25.6138C0.872281 25.5691 0.772811 25.503 0.689186 25.4194C0.605562 25.3358 0.539464 25.2363 0.494762 25.1268C0.450061 25.0173 0.427656 24.9 0.428858 24.7817C0.43006 24.6635 0.454845 24.5467 0.501763 24.4381C0.548681 24.3295 0.616789 24.2314 0.702097 24.1495L11.6292 13.2224L0.702097 2.29536C0.573859 2.17047 0.486313 2.00977 0.450914 1.8343C0.415516 1.65883 0.433914 1.47677 0.503703 1.31193C0.573491 1.14708 0.691419 1.00715 0.842051 0.910442C0.992682 0.813731 1.169 0.764747 1.34793 0.7699Z"
                fill="white"
                fill-opacity="0.5" />
            </svg>
          </div>
        </div>
      </div>
     <div class="row-grid">
      <div class="row1">
        <?php foreach ($new_and_hot_item as $item): ?>
          <div class="rows">
            <div class="content-container">
              <a style="text-decoration: none; color: white;" href="<?= $baseUrl ?>/for-you?id=<?= htmlspecialchars($item['id']) ?>">
                <div class="img-div">
                  <img src="<?= htmlspecialchars($item['poster_portrait']) ?>" alt="img" width="140" height="140"/>
                </div>
         
                <div class="typography">
                  <h4><?= htmlspecialchars($item['title']) ?></h4>
                  <p class="genre"><?= htmlspecialchars(implode(", ", $item['genres'])) ?></p>
                </div>
              </a>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
      <div class="row2">
        <?php foreach ($new_and_hot_item as $item): ?>
          <div class="rows">
            <div class="content-container">
              <a style="text-decoration: none; color: white;" href="<?= $baseUrl ?>/for-you?id=<?= htmlspecialchars($item['id']) ?>">
                <div class="img-div">
                  <img src="<?= htmlspecialchars($item['poster_portrait']) ?>" alt="img" width="140" height="140"/>
                </div>
         
                <div class="typography">
                  <h4><?= htmlspecialchars($item['title']) ?></h4>
                  <p class="genre"><?= htmlspecialchars(implode(", ", $item['genres'])) ?></p>
                </div>
              </a>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>

    </div>
  </div>


  <!-- ===========================
        + MORE-CONTENT SECTION +
    =========================== -->
  <div class="fore-div">
    <?php
    $response = fetchApiData("http://linkskool.net/api/v3/public/movies/all");
    $slides = [];
    if ($response && isset($response['success']) && $response['success']) {
      $new_and_hot_items = $response['data']['recommended'];
    }
    ?>
    <div class="animate-on-scroll">
      <div class="newandHot-title">
        <h2>Recommended</h2>
        <div class="arrow-div">
          <div class="arrow-icon" style="padding-left: 0.725rem">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="14"
              height="26"
              viewBox="0 0 14 26"
              fill="none">
              <path
                d="M13.0018 0.7699C12.771 0.776628 12.5518 0.87293 12.3907 1.03842L0.835167 12.594C0.66853 12.7607 0.574921 12.9867 0.574921 13.2224C0.574921 13.4582 0.66853 13.6842 0.835167 13.8509L12.3907 25.4065C12.4726 25.4918 12.5707 25.5599 12.6793 25.6068C12.7879 25.6537 12.9047 25.6785 13.0229 25.6797C13.1412 25.6809 13.2585 25.6585 13.368 25.6138C13.4775 25.5691 13.577 25.503 13.6606 25.4194C13.7442 25.3358 13.8103 25.2363 13.855 25.1268C13.8997 25.0173 13.9221 24.9 13.9209 24.7817C13.9197 24.6635 13.8949 24.5467 13.848 24.4381C13.8011 24.3295 13.733 24.2314 13.6477 24.1495L2.72058 13.2224L13.6477 2.29536C13.7759 2.17047 13.8634 2.00977 13.8988 1.8343C13.9342 1.65883 13.9158 1.47677 13.8461 1.31193C13.7763 1.14708 13.6583 1.00715 13.5077 0.910442C13.3571 0.813731 13.1808 0.764747 13.0018 0.7699Z"
                fill="white"
                fill-opacity="0.5" />
            </svg>
          </div>
          <div class="arrow-icon" style="padding-left: 0.725rem">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="14"
              height="26"
              viewBox="0 0 14 26"
              fill="none">
              <path
                d="M1.34793 0.7699C1.57878 0.776628 1.79795 0.87293 1.95904 1.03842L13.5146 12.594C13.6812 12.7607 13.7748 12.9867 13.7748 13.2224C13.7748 13.4582 13.6812 13.6842 13.5146 13.8509L1.95904 25.4065C1.87713 25.4918 1.77903 25.5599 1.67047 25.6068C1.56191 25.6537 1.44508 25.6785 1.32683 25.6797C1.20857 25.6809 1.09126 25.6585 0.981771 25.6138C0.872281 25.5691 0.772811 25.503 0.689186 25.4194C0.605562 25.3358 0.539464 25.2363 0.494762 25.1268C0.450061 25.0173 0.427656 24.9 0.428858 24.7817C0.43006 24.6635 0.454845 24.5467 0.501763 24.4381C0.548681 24.3295 0.616789 24.2314 0.702097 24.1495L11.6292 13.2224L0.702097 2.29536C0.573859 2.17047 0.486313 2.00977 0.450914 1.8343C0.415516 1.65883 0.433914 1.47677 0.503703 1.31193C0.573491 1.14708 0.691419 1.00715 0.842051 0.910442C0.992682 0.813731 1.169 0.764747 1.34793 0.7699Z"
                fill="white"
                fill-opacity="0.5" />
            </svg>
          </div>
        </div>
      </div>
      <div class="card-grid">
  <?php if (!empty($new_and_hot_item)): ?>
    <?php foreach ($new_and_hot_item as $item): ?>
      <div class="card">
        <a style="text-decoration: none; color: white;" href="<?= $baseUrl ?>/for-you?id=<?= htmlspecialchars($item['id']) ?>">
          <div class="new-ribbon">NEW</div>
          <img src="<?= htmlspecialchars($item['poster_portrait']) ?>" alt="Card Image" class="card-image" />
          <div class="card-overlay">
            <div class="overlayTypo">
              <h3><?= htmlspecialchars($item['title']) ?></h3>
              <p class="genre"><?= htmlspecialchars(implode(", ", $item['genres'])) ?></p>
              <p class="description">
                <?php
                  $description = $item['description'] ?? 'No description';
                  $maxLength = 200;
                  if (strlen($description) > $maxLength) {
                    $description = substr($description, 0, $maxLength) . '....';
                  }
                  echo htmlspecialchars($description, ENT_QUOTES, 'UTF-8');
                ?>
              </p>
            </div>
            <a href="<?= $baseUrl ?>/for-you?id=<?= htmlspecialchars($item['id']) ?>">
              <button class="watch-button">▶ Watch now</button>
            </a>
          </div>
          <div class="card-content">
            <p class="movieTitle"><?= htmlspecialchars($item['title']) ?></p>
          </div>
        </a>
      </div>
    <?php endforeach; ?>
  <?php else: ?>
    <!-- Render skeleton placeholders immediately if no data -->
    <?php for ($i = 0; $i < 8; $i++): ?>
      <div class="skeleton-card">
        <div class="skeleton-ribbon">New</div>
        <div class="skeleton-image"></div>
        <div class="card-overlay"></div>
        <div class="card-content"></div>
        <div class="skeleton-title"></div>
      </div>
    <?php endfor; ?>
    <?php endif;?>
</div>
    </div>
  </div>
</body>
<script>
  document.querySelectorAll('.arrow-div').forEach(arrowDiv => {
      const arrows = arrowDiv.querySelectorAll('.arrow-icon');
      let scrollTarget = arrowDiv.parentElement.nextElementSibling;

      // Fallback: look inside section for known scrollable classes
      if (!scrollTarget || !(scrollTarget.classList.contains('card-grid') || scrollTarget.classList.contains('row-grid'))) {
        scrollTarget = arrowDiv.closest('section')?.querySelector('.card-grid, .row-grid');
      }

      if (arrows.length === 2 && scrollTarget) {
        arrows[0].addEventListener('click', () => {
          scrollTarget.scrollBy({ left: -300, behavior: 'smooth' });
        });

        arrows[1].addEventListener('click', () => {
          scrollTarget.scrollBy({ left: 300, behavior: 'smooth' });
    });
  }
});
</script>
</html>