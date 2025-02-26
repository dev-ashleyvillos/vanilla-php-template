<?php
/**
 * Main Configuration File
 *
 * Loads configuration from .env file and defines constants
 */

// Require the DotEnv class
require_once __DIR__ . '/../includes/DotEnv.php';

// Load environment variables from .env file
$dotenv = new DotEnv(__DIR__ . '/../.env');
$dotenv->load();

// Application settings
define('APP_NAME', DotEnv::get('APP_NAME', 'PHP Application'));
define('APP_ENV', DotEnv::get('APP_ENV', 'production'));
define('APP_DEBUG', filter_var(DotEnv::get('APP_DEBUG', false), FILTER_VALIDATE_BOOLEAN));

// URL settings
define('BASE_URL', DotEnv::get('BASE_URL', 'http://localhost/'));
define('BASE_PATH', DotEnv::get('BASE_PATH', '/'));

// Database settings
define('DB_HOST', DotEnv::get('DB_HOST', 'localhost'));
define('DB_NAME', DotEnv::get('DB_NAME', 'myapp_db'));
define('DB_USER', DotEnv::get('DB_USER', 'root'));
define('DB_PASS', DotEnv::get('DB_PASS', ''));

// Email settings
define('MAIL_HOST', DotEnv::get('MAIL_HOST', 'smtp.mailtrap.io'));
define('MAIL_PORT', DotEnv::get('MAIL_PORT', '2525'));
define('MAIL_USER', DotEnv::get('MAIL_USER', null));
define('MAIL_PASS', DotEnv::get('MAIL_PASS', null));
define('MAIL_FROM', DotEnv::get('MAIL_FROM', 'noreply@example.com'));
define('MAIL_NAME', DotEnv::get('MAIL_NAME', 'My Application'));

// Other settings
define('TIMEZONE', DotEnv::get('TIMEZONE', 'UTC'));
define('SESSION_LIFETIME', DotEnv::get('SESSION_LIFETIME', 120));
define('UPLOAD_MAX_SIZE', DotEnv::get('UPLOAD_MAX_SIZE', 10485760)); // 10MB default

// File paths
define('ROOT_PATH', realpath(__DIR__ . '/../'));
define('VIEWS_PATH', ROOT_PATH . '/views/');
define('UPLOADS_PATH', ROOT_PATH . '/uploads/');
define('LOGS_PATH', ROOT_PATH . '/logs/');

// Set timezone
date_default_timezone_set(TIMEZONE);

// Enable or disable error reporting based on environment
if (APP_DEBUG) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}