<?php
$base_url = $_ENV["base_url"]; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>404 Not Found</title>
    <link rel="stylesheet" href="<?= $base_url ?>assets/css/error.css">
</head>
<body>

    <div class="container">
        <h1>404 - Not Found</h1>
        <p>The page you are looking for could not be found.</p>
        <a href="/">Go to Homepage</a>
    </div>
</body>
</html>