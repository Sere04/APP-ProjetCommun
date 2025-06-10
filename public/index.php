<?php
// Autoload classes (using Composer or similar)
require_once __DIR__ . '/../vendor/autoload.php';

use App\Controllers\HomeController;

// Basic routing (more robust routing library would be used in a real app)
$requestUri = $_SERVER['REQUEST_URI'];

if ($requestUri === '/' || $requestUri === '/home') {
    $controller = new HomeController();
    $controller->index();
} else {
    // Handle 404
    http_response_code(404);
    echo "Page Not Found";
}
?>