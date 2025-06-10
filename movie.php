<?php
$movieId = $_GET['id'] ?? null;

if (!$movieId) {
  echo "Movie not found!";
  exit;
}

// Assuming VidSrc uses some format like this:
$embedUrl = "https://vidsrc.to/embed/movie/$movieId";

?>

<!DOCTYPE html>
<html>
<head>
  <title>Watch Movie</title>
  <style>
    iframe {
      width: 70%;
      height: 90vh;
      border: none;
    }
  </style>
</head>
<body>
  <h2>Now Playing</h2>
  <iframe src="<?= $embedUrl ?>" allowfullscreen></iframe>
</body>
</html>