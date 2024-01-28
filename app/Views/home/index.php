<?php
$base_url = $_ENV["base_url"]; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" href="<?= $base_url ?>assets/css/index.css">
    <title>Simy Framework</title>
</head>
<body>
    <header>
        <div class="container">
            <h1>Welcome to Simy Framework <span style="color: red">V1</span></h1>
        </div>
    </header>
    <main>
        <div class="container">
            <h2>About Simy Framework</h2>
            <p>
Simy: Lightweight PHP Framework for Modern Web Development </p>
            <p>
                It is open source, and contributions to the framework's development are welcomed.
            </p>
            <p>
                GitHub Repository: <a href="https://github.com/almhdy24/simy-framework">https://github.com/almhdy24/simy-framework</a>
            </p>
            <hr/>
            <p>Running on PHP version <?= phpversion() ?></p>
            <p>Simy version: <strong>1.0</strong></p>
            <p>Base URL: <?= $_ENV["base_url"] ?></p>
            <p>Database Driver: <?= $_ENV["DB_CONNECTION"] ?></p>
            <p>
                For more information, run phpinfo() or <a href="phpinfo" target="_blank">click here</a>
            </p>
        </div>
    </main>
</body>
</html>