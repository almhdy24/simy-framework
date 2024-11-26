<?php
$base_url = $_ENV["base_url"];
$env = $_ENV["ENV"];
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
        <h1>500 - Internal Server Error</h1>
        <h3><?php echo $message; ?></h3>
        <?php if ($env == "development") { ?>
        <details><?php echo $details; ?></details>
        <?php } ?>
        <a href="/">Go to Homepage</a>
    </div>
</body>
</html>