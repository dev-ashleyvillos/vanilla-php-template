# Simple PHP Routing System

A lightweight but powerful PHP routing system with environment configuration, friendly URLs, and helper functions.

## Features

- **Simple routing** - Map URLs to views with a clean, simple syntax
- **Environment configuration** - Manage different settings across environments using `.env` files
- **Pretty URLs** - Use clean, SEO-friendly URLs with Apache's mod_rewrite
- **Helper functions** - Generate URLs and handle redirects easily
- **Project isolation** - Support for multiple projects in the same domain

## Directory Structure

```
your-project/
├── .env                  # Environment variables (not in version control)
├── .env.example          # Example environment file (in version control)
├── .gitignore            # Git ignore file
├── .htaccess             # Apache URL rewriting rules
├── config/
│   └── config.php        # Configuration loaded from .env
├── includes/
│   ├── DotEnv.php        # Environment loader
│   └── url_helpers.php   # URL helper functions
├── public/               # Web accessible files
│   ├── assets/           # CSS, JS, images
│   └── index.php         # Front controller
├── views/                # View files
│   ├── home.php
│   ├── landing.php
│   └── error.php
└── README.md             # This file
```

## Installation

1. Clone or download this repository
2. Copy `.env.example` to `.env` and update the values
3. Ensure Apache's `mod_rewrite` module is enabled
4. Update your virtual host configuration to enable `.htaccess` if needed
5. Point your web server to the `public` directory

## Configuration

### Environment Variables (.env)

The `.env` file stores environment-specific configuration:

```
# Base URL - Change this for each environment
BASE_URL=http://localhost/myapp/

# Database Configuration
DB_HOST=localhost
DB_NAME=myapp
DB_USER=root
DB_PASS=password
```

### Apache Configuration (.htaccess)

The main `.htaccess` file in your public directory handles URL rewriting:

```apache
# Enable URL rewriting
RewriteEngine On
RewriteBase /

# Handle existing projects with their own .htaccess
RewriteCond %{REQUEST_URI} ^/([^/]+)
RewriteCond %{DOCUMENT_ROOT}/$1 -d
RewriteCond %{DOCUMENT_ROOT}/$1/.htaccess -f
RewriteRule ^([^/]+) $1 [L]

# Handle non-existent projects - redirect to index.html
RewriteCond %{REQUEST_URI} ^/([^/]+)/?$
RewriteCond %{DOCUMENT_ROOT}/$1 !-d
RewriteRule ^ /index.html [L]

# For all other requests that aren't files or directories
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php [L]
```

This configuration:
- Allows sub-projects with their own `.htaccess` files
- Redirects requests for non-existent projects to `index.html`
- Routes all other URLs through the main router

## Routing System

### Defining Routes

Routes are defined in `config/routes.php`:

```php
$routes = [
    'home' => 'home.php',
    'landing' => 'landing.php',
    'about' => 'about.php',
    'contact' => 'contact.php'
];
```

### How Routing Works

1. A request comes in (e.g., `http://localhost/about`)
2. The `.htaccess` file routes it to `index.php`
3. The Router extracts the route name ("about")
4. It looks up the view file from `$routes`
5. It includes the appropriate view file

## Helper Functions

### URL Generation

```php
// Generate a URL to a route
echo url('about'); // http://localhost/myapp/about

// With query parameters
echo url('products', ['id' => 123]); // http://localhost/myapp/products?id=123

// Generate a URL to an asset
echo asset('css/style.css'); // http://localhost/myapp/assets/css/style.css
```

### Navigation

```php
// Redirect to another route
redirect('dashboard');
```

## Multiple Projects

This system supports multiple projects in the same domain:

1. Create project folders in your web root (e.g., `net-text/`)
2. Each project should have its own `.htaccess` file
3. The main `.htaccess` will detect these projects and delegate to their own routing

## Usage Examples

### Creating a View

```php
<!-- views/contact.php -->
<?php require_once 'helpers/url_helpers.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Contact Us</title>
    <link rel="stylesheet" href="<?php echo asset('css/style.css'); ?>">
</head>
<body>
    <header>
        <nav>
            <a href="<?php echo url('home'); ?>">Home</a>
            <a href="<?php echo url('about'); ?>">About</a>
            <a href="<?php echo url('contact'); ?>">Contact</a>
        </nav>
    </header>
    <main>
        <h1>Contact Us</h1>
        <form action="<?php echo url('process-contact'); ?>" method="post">
            <!-- Form fields -->
            <button type="submit">Send</button>
        </form>
    </main>
</body>
</html>
```

### Adding a New Route

1. Add the route in `config/routes.php`:
```php
$routes = [
    // Existing routes...
    'new-page' => 'new-page.php'
];
```

2. Create the view file at `views/new-page.php`

3. Access it at `http://localhost/myapp/new-page`

## Security Considerations

- Keep sensitive information in `.env` files and exclude them from version control
- Ensure proper directory permissions
- Consider additional security headers in your `.htaccess` file
- Sanitize user input in your application logic

## License

[MIT License](LICENSE)
