<?php
// Include URL helper functions
require_once 'helpers/url_helpers.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page</title>
    <link rel="stylesheet" href="<?php echo asset('css/style.css'); ?>">
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
    <h1>Landing Page</h1>
    <p>This is the landing page that loads when the URL is /landing.</p>
</main>
<footer>
    <p>&copy; <?php echo date('Y'); ?> Your Website</p>
</footer>
</body>
</html>