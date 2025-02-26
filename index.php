<?php
/**
 * Simple PHP Router
 *
 * This is a basic PHP routing structure that allows navigation to different views
 * by simply putting the view name in the URL (e.g., /landing).
 *
 * Features:
 * - Manual BASE_URL configuration
 * - Simple view routing
 */

// Directory structure:
// - index.php (this file)
// - config/routes.php (route configuration)
// - views/ (directory containing all view files)
//   - home.php
//   - landing.php
//   - about.php
//   - error.php

// Start the session if needed
session_start();

// Include the configuration file
require_once 'config/config.php';

// Router class definition
class Router {
    private $routes = [];
    private $notFoundCallback;

    /**
     * Add a route to the router
     *
     * @param string $route The route URL (e.g., 'landing')
     * @param string $view The view file to load (e.g., 'landing.php')
     * @return void
     */
    public function addRoute($route, $view) {
        $this->routes[$route] = $view;
    }

    /**
     * Set the callback for when a route is not found
     *
     * @param callable $callback The function to call when a route is not found
     * @return void
     */
    public function setNotFound($callback) {
        $this->notFoundCallback = $callback;
    }

    /**
     * Route the request to the appropriate view
     *
     * @return void
     */
    public function route() {
        // Get the requested path from the URL
        $uri = $_SERVER['REQUEST_URI'];

        // Remove query string if present
        if (strpos($uri, '?') !== false) {
            $uri = substr($uri, 0, strpos($uri, '?'));
        }

        // Remove trailing slash if present
        $uri = rtrim($uri, '/');

        // Extract the base path from the configured BASE_URL
        $parsedBaseUrl = parse_url(BASE_URL);
        $basePath = isset($parsedBaseUrl['path']) ? rtrim($parsedBaseUrl['path'], '/') : '';

        // Remove the base path from the URI
        if ($basePath && strpos($uri, $basePath) === 0) {
            $uri = substr($uri, strlen($basePath));
        }

        // Get the route name (remove leading slash)
        $route = ltrim($uri, '/');

        // Default to home if no route is specified
        if ($route === '') {
            $route = 'home';
        }

        // Check if the route exists
        if (array_key_exists($route, $this->routes)) {
            // Route exists, include the view file
            $viewFile = 'views/' . $this->routes[$route];

            if (file_exists($viewFile)) {
                include $viewFile;
            } else {
                // View file doesn't exist
                $this->handleNotFound("View file '$viewFile' not found.");
            }
        } else {
            // Route doesn't exist
            $this->handleNotFound("Route '$route' not defined.");
        }
    }

    /**
     * Handle a route not found error
     *
     * @param string $message The error message
     * @return void
     */
    private function handleNotFound($message) {
        if (is_callable($this->notFoundCallback)) {
            call_user_func($this->notFoundCallback, $message);
        } else {
            // Default not found handler
            header("HTTP/1.0 404 Not Found");
            echo "<h1>404 Not Found</h1>";
            echo "<p>$message</p>";
        }
    }
}

// Load route configuration
require_once 'config/routes.php';

// Create router instance
$router = new Router();

// Configure routes from the config
foreach ($routes as $route => $view) {
    $router->addRoute($route, $view);
}

// Set not found handler
$router->setNotFound(function($message) {
    // Include error view
    include 'views/error.php';
});

// Route the request
$router->route();
?>