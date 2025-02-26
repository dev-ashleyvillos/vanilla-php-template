<?php
/**
 * URL Helper Functions
 *
 * A set of helper functions for generating URLs in views.
 * This file should be included in your views or in a common include file.
 */

/**
 * Generate a URL for a route
 *
 * @param string $route The route name
 * @param array $params Optional query string parameters
 * @return string The full URL
 */
function url($route, $params = []) {
    $baseUrl = BASE_URL;

    // Build the URL
    $url = rtrim($baseUrl, '/') . '/' . ltrim($route, '/');

    // Add query parameters if any
    if (!empty($params)) {
        $url .= '?' . http_build_query($params);
    }

    return $url;
}

/**
 * Generate a URL for an asset file (CSS, JS, images)
 *
 * @param string $path The asset path relative to assets directory
 * @return string The full URL to the asset
 */
function asset($path) {
    $baseUrl = BASE_URL;

    // Build the asset URL
    return rtrim($baseUrl, '/') . '/assets/' . ltrim($path, '/');
}

/**
 * Redirect to a specific route
 *
 * @param string $route The route to redirect to
 * @param array $params Optional query string parameters
 * @return void
 */
function redirect($route, $params = []) {
    $url = url($route, $params);
    header("Location: $url");
    exit;
}
?>