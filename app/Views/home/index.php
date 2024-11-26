<?php
$base_url = $_ENV["base_url"];
if (isset($_GET["phpinfo"]) && $_GET["phpinfo"] === "true") {
  exit(phpinfo());
}
?>
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
            <h1>Welcome to Simy Framework </h1>
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
                GitHub Repository: <i> <a href="https://github.com/almhdy24/simy-framework">https://github.com/almhdy24/simy-framework</a></i>
            </p>
            <hr/>
            <p>PHP version <span style="color:blue"><?= phpversion() ?> </span></p>
            <p>Simy version: <strong><b>1.0.0</b></strong></p>
            <p>Base URL: <span style="color:pink"><a href="<?= $_ENV[
              "base_url"
            ] ?>"><?= $_ENV["base_url"] ?> </a></span></p>
            <p>Database Driver: <span style="color:green"><?= $_ENV[
              "DB_CONNECTION"
            ] ?> </span></p>
            <p>
                For more information about your php server , run <code style="color:red">phpinfo()</code> or <a href="?phpinfo=true" target="_blank">click here</a>
            </p>
        </div>
    </main>
</body>
</html>