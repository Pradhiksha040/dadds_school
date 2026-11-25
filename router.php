<?php
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
if ($uri === '/file.php' || strpos($uri, '/file.php') === 0) {
    require __DIR__ . '/file.php';
    exit;
}
require __DIR__ . '/index.php';
