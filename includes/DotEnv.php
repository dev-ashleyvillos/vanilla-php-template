<?php
/**
 * DotEnv Loader Class
 *
 * A simple class to load environment variables from a .env file
 */
class DotEnv {
    /**
     * The directory where the .env file can be found
     *
     * @var string
     */
    protected $path;

    /**
     * Constructor
     *
     * @param string $path Path to .env file
     */
    public function __construct($path) {
        if (!file_exists($path)) {
            throw new \InvalidArgumentException(sprintf('File %s does not exist', $path));
        }
        $this->path = $path;
    }

    /**
     * Load environment variables from .env file
     *
     * @return void
     */
    public function load() {
        if (!is_readable($this->path)) {
            throw new \RuntimeException(sprintf('File %s is not readable', $this->path));
        }

        $lines = file($this->path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            // Skip comments
            if (strpos(trim($line), '#') === 0) {
                continue;
            }

            // Process variable definitions
            if (strpos($line, '=') !== false) {
                list($name, $value) = array_map('trim', explode('=', $line, 2));

                // Skip if the line doesn't look like a variable definition
                if (!$name || strpos($name, ' ') !== false) {
                    continue;
                }

                // Remove quotes from value if present
                if (strpos($value, '"') === 0 && substr($value, -1) === '"') {
                    $value = substr($value, 1, -1);
                }

                // Set environment variable if it doesn't already exist
                if (!array_key_exists($name, $_ENV)) {
                    $_ENV[$name] = $value;
                }

                if (!array_key_exists($name, $_SERVER)) {
                    $_SERVER[$name] = $value;
                }

                // Also set as a constant for convenience
                if (!defined($name)) {
                    define($name, $value);
                }
            }
        }
    }

    /**
     * Get environment variable value
     *
     * @param string $key Variable name
     * @param mixed $default Default value if variable doesn't exist
     * @return mixed
     */
    public static function get($key, $default = null) {
        if (isset($_ENV[$key])) {
            return $_ENV[$key];
        }

        if (isset($_SERVER[$key])) {
            return $_SERVER[$key];
        }

        return $default;
    }
}