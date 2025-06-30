<?php
// index.php

// Get the requested route from URL query parameter (?page=home)
$page = $_GET['page'] ?? 'home'; // Default to 'home' if not set

// Sanitize to allow only letters, numbers, dashes, and underscores
$page = preg_replace('/[^a-zA-Z0-9_-]/', '', $page);

// Full path to page (extension is added in PHP, not URL)
$pageFile = __DIR__ . "/pages/{$page}.php";

// Use output buffering to include header and page
if (file_exists($pageFile)) {
    include __DIR__ . '/includes/header.php';
    include $pageFile;
} else {
    include __DIR__ . '/includes/header.php';
    include __DIR__ . '/pages/404.php';
}
// Include footer only on home page
if ($page === 'home') {
    include __DIR__ . '/includes/footer.php';
}
