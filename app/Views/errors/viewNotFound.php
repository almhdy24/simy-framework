<?php
$base_url = $_ENV["base_url"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Internal Server Error</title>
    <link rel="stylesheet" href="<?= $base_url ?>assets/css/error.css">
</head>
<body>
    <div class="container">
        
        <h1>View was not found !</h1>
        
         <h3><strong>View</strong> : <code><?= $view ?></code></h3>
        <a href="/">Go to Homepage</a>
    </div>
</body>
</html>