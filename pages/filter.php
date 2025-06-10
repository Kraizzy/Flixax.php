<?php
// Function to fetch movies by genre ID
function fetchMoviesByGenre($genreId)
{
    //  API endpoint for movies by genre
    $url = "http://linkskool.net/api/v3/public/movies/genre/" . urlencode($genreId);
    $response = @file_get_contents($url);

    if ($response === false) {
        return []; // Return empty array on failure
    }

    $data = json_decode($response, true);
    // Adjust based on actual API response structure
    return isset($data['data']) && is_array($data['data']) ? $data['data'] : [];
}
function getGenreNameById($genreId) {
    // Replace this with your actual genre list API endpoint
    $genreApiUrl = "http://linkskool.net/api/v3/public/movies/genres";

    $response = @file_get_contents($genreApiUrl);
    if ($response === false) {
        return "Unknown Genre";
    }

    $data = json_decode($response, true);
    if (!isset($data['data']) || !is_array($data['data'])) {
        return "Unknown Genre";
    }

    // Loop through genre list to match ID
    foreach ($data['data'] as $genre) {
        if ($genre['id'] == $genreId) {
            return $genre['name'];
        }
    }

    return "Unknown Genre";
}

// Get genre_id from URL, with basic validation
$genreId = isset($_GET['genre_id']) ? filter_var($_GET['genre_id'], FILTER_VALIDATE_INT) : null;
$movies = $genreId ? fetchMoviesByGenre($genreId) : [];

$CurrentGenreName = $genreId ? getGenreNameById($genreId) : 'All';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movies by Genre</title>
    <style>
        /* Basic styling for demonstration */
        .movie-list {
            width: 95%;
            margin: 3rem auto;
            border-radius: 4px;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
        }

        .movie-item {
            border-bottom: 1px solid #ccc;
            padding: 10px 0;
        }

        .error {
            color: red;
            text-align: center;
        }

        .movie-card {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1.5rem;
            padding: 0.8rem 1rem;
            height: 291px;
            background-color: #222222;
            border-radius: 8px;
            will-change: transform;
            transition: transform 0.5s ease;
        }

        .movie-card:hover {
            transform: scale(1.02);
        }

        body {
            font-family: Nunito, sans-serif;
            background-color: #101010;
        }

        .details {
            display: flex;
            justify-content: space-between;
            gap: 0.8rem;
            flex-direction: column;
            width: 90%;
            margin-bottom: 0px;
            padding: 1rem 0.8rem;
            height: 80%;
            /* background-color: blueviolet; */
        }

        .image-placeholder {
            width: 35%;
            height: 100%;
            overflow: hidden;
            border-radius: 8px;
        }

        .filter-typo {
            display: flex;
            flex-direction: column;
            gap: 18px;
        }

        .filter-typo h2,
        p {
            margin-top: 0px;
            margin-bottom: 0px;
        }

        .filter-typo h2 {
            font-family: "Nunito", sans-serif;
            font-size: 24px;
            margin-bottom: 18px;
            color: #fff;
            font-weight: 800;
            line-height: 24px;
            font-style: normal;
        }

        .description {
            color: rgba(255, 255, 255, 0.50);
            font-family: Nunito;
            font-size: 14px;
            font-style: normal;
            font-weight: 400;
            line-height: 24px;
            /* -webkit-line-clamp: 4; */
            /* Limits to 4 lines */
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .genres {
            color: rgba(255, 255, 255, 0.70);
            font-family: Nunito;
            font-size: 16px;
            font-style: normal;
            font-weight: 500;
            line-height: 24px;
            /* 150% */
        }

        .watch-now {
            display: flex;
            gap: 9.341px;
            align-items: center;
            justify-content: center;
            padding: 10.224px 12.78px;
            width: 130px;
            color: #FFF;
            font-family: "Nunito", sans-serif;
            font-weight: 500;
            font-style: normal;
            background-color: #FA528C;
            border-radius: 37.366px;
            cursor: pointer;
            border: none;
            height: 40px;
        }

        .add-to-list {
            display: flex;
            gap: 9.341px;
            align-items: center;
            justify-content: center;
            padding: 10.224px 12.78px;
            width: 130px;
            height: 40px;
            color: #FA528C;
            font-family: "Nunito", sans-serif;
            font-weight: 500;
            font-style: normal;
            border-radius: 37.689px;
            border: 1.102px solid #FA528C;
            background: rgba(252, 125, 135, 0.20);
            cursor: pointer;
        }

        .buttons {
            display: flex;
            gap: 20px;
            width: 280px;
            height: 40px;
        }

        .div-container {
            margin: 0 auto;
            margin-top: 8rem;
            width: 100%;
        }

        .filter {
            width: 90%;
            margin: 1rem auto;
        }

        .filter-buttons {
            width: 8rem;
            padding: 1rem 1.2rem;
            background-color: #313131;
            gap: 10px;
            justify-content: center;
            align-items: center;
            border: none;
            border-radius: 4px;
            color: #FFF;
            font-family: "DM Sans", sans-serif;
            font-size: 0.95rem;
            font-style: normal;
            font-weight: 500;
            line-height: normal;
        }

        .filter-buttons:hover{
            background: rgba(252, 125, 135, 0.20);
            color: #FA528C;
            cursor: pointer;
        }
        .filter-buttons.active {
            background: rgba(252, 125, 135, 0.20);
            color: #FA528C;
            cursor: pointer;
        }

        .filter-list span {
            color: #828282;
            font-family: "DM Sans";
            font-size: 1rem;
            font-style: normal;
            font-weight: 500;
            line-height: normal;
        }

        .filter-list {
            margin: 0.5rem auto;
            width: 95%;
        }

        .filter-grid {
            /* background-color: #FA528C; */
            display: grid;
            margin: 0 auto;
            width: 95%;
            gap: 1rem 1rem;
            margin-bottom: 1.5rem;
            grid-template-columns: repeat(9, auto);
            /* justify-content: space-between; */
        }

        .filter-grid a {
            text-decoration: none;
            display: inline-flex;
            justify-content: center;
            align-items: center;
        }
    </style>
</head>

<body>
    <?php
$activeGenre = $_GET['genre_id'] ?? null; // ✅ Define it before usage
?>
    <div class="filter">
        <div class="div-container">
            <div class="filter-list">
                <p><span>Filter /</span> <?= htmlspecialchars($CurrentGenreName) ?></p>
            </div>
            <div class="filter-grid">
                <?php
                if (empty($genres)) {
                    echo '<button class="filter-buttons" disabled>Error loading genres</button>';
                } else {
                    echo '<li><a href="filter" class="filter-buttons' . ($activeGenre === null ? ' active' : '') . '">All</a></li>';
                    foreach ($genres as $genre) {
                        $genreId = htmlspecialchars($genre['id'], ENT_QUOTES, 'UTF-8');
                        $genreName = htmlspecialchars($genre['name'], ENT_QUOTES, 'UTF-8');
                        $activeClass = ($genreId == $activeGenre) ? ' active' : '';
                        echo "<li><a href=\"filter?genre_id=$genreId\" class=\"filter-buttons$activeClass\">$genreName</a></li>";
                    }
                }
                ?>
            </div>
        </div>
        <div class="movie-list">
            <?php if ($genreId === null || $genreId === false): ?>
                <p class="error">Invalid or missing genre ID.</p>
            <?php elseif (empty($movies)): ?>
                <p class="error">No movies found for this genre or error loading movies.</p>
            <?php else: ?>
                <?php foreach ($movies as $movie): ?>
                    <div class="movie-card">
                        <div class="image-placeholder">
                            <img src="<?= htmlspecialchars($movie['poster_portrait']) ?>" alt="Card Image" class="card-image" />
                        </div> <!-- Placeholder for movie poster -->
                        <div class="details">
                            <div class="filter-typo">
                                <div class="filter-title">
                                    <h2><?php echo htmlspecialchars($movie['title'] ?? 'Untitled', ENT_QUOTES, 'UTF-8'); ?></h2>
                                    <div class="genres"><?php echo htmlspecialchars(implode(', ', ($movie['genres'] ?? ['Unknown'])), ENT_QUOTES, 'UTF-8'); ?></div>
                                </div>
                                <div class="view-count"><?php echo number_format($movie['view_count'] ?? 0); ?>k</div>
                                <div class="description"><?php $description = $movie['description'] ?? 'No description';
                                                            $maxLength = 200; // Adjust based on your design
                                                            if (strlen($description) > $maxLength) {
                                                                $description = substr($description, 0, $maxLength) . '....';
                                                            }
                                                            echo htmlspecialchars($description, ENT_QUOTES, 'UTF-8');
                                                            ?></div>
                            </div>

                            <div class="buttons">
                                <button onclick="window.location.href='<?= $baseUrl ?>/for-you?id=<?= urlencode($movie['id']) ?>'" class="watch-now">Watch Now</button>
                                <button onclick="" class="add-to-list">Add to List</button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

</body>

</html>