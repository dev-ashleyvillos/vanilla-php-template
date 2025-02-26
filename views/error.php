<?php
// Include URL helper functions
require_once 'helpers/url_helpers.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error - Page Not Found</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <style>
        .error-container {
            text-align: center;
            padding: 50px 20px;
        }
        .error-code {
            font-size: 72px;
            color: #e74c3c;
            margin: 0;
        }
    </style>
</head>
<body>
<header>
    <nav>
        <ul>
            <li><a href="<?php echo url('home'); ?>">Home</a></li>
            <li><a href="<?php echo url('landing'); ?>">Landing</a></li>
            <li><a href="<?php echo url('about'); ?>">About</a></li>
            <li><a href="<?php echo url('contact'); ?>">Contact</a></li>
        </ul>
    </nav>
</header>
<main>
    <div class="error-container">
        <h1 class="error-code">404</h1>
        <h2>Page Not Found</h2>
        <p><?php echo isset($message) ? $message : 'The requested page could not be found.'; ?></p>
        <p><a href="/">Return to Home Page</a></p>
    </div>
</main>
<footer>
    <p>&copy; <?php echo date('Y'); ?> Your Website</p>
</footer>
</body>
</html>