<?php
$base_url = $this->env("base_url");
if (
  $this->request()->has("phpinfo") &&
  $this->request->input("phpinfo") === "true"
) {
  exit(phpinfo());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" href="<?= $base_url ?>assets/css/index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>Simy Framework</title>
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="container">
                <h1>Simy Framework</h1>
                <ul class="nav-links">
                    <li><a href="#about">About</a></li>
                    <li><a href="#links">Links</a></li>
                    <li><a href="#info">Info</a></li>
                </ul>
            </div>
        </nav>
    </header>
    <main>
        <section id="about" class="container">
            <h2>About Simy Framework</h2>
            <p>
                Simy is a lightweight PHP framework designed for modern web development. It is open-source, and contributions are welcomed.
            </p>
        </section>
        
        <section id="links" class="container">
            <h2>Useful Links</h2>
            <p>
                GitHub Repository: <a href="https://github.com/almhdy24/simy-framework" target="_blank">https://github.com/almhdy24/simy-framework</a>
            </p>
        </section>

        <section id="info" class="container">
            <h2>Server Information</h2>
            <hr />
            <p>PHP Version: <span style="color:blue"><?= phpversion() ?></span></p>
            <p>Simy Version: <strong>1.0.0</strong></p>
            <p>Base URL: <span style="color:pink"><a href="<?= $_ENV[
              "base_url"
            ] ?>"><?= $this->env("base_url") ?></a></span></p>
            <p>Database Driver: <span style="color:green"><?= $_ENV[
              "DB_CONNECTION"
            ] ?></span></p>
            <p>
                For detailed PHP server information, run <code style="color:red">phpinfo()</code> or <a href="?phpinfo=true" target="_blank">click here</a>.
            </p>
        </section>
    </main>
    <footer>
        <div class="container">
            <p>&copy; <?= date("Y") ?> Simy Framework. All Rights Reserved. <body>
    <header>
        <nav class="navbar">
            <div class="container">
                <h1>Welcome to Simy Framework</h1>
                <ul class="nav-links">
                    <li><a href="#about">About</a></li>
                    <li><a href="#links">Links</a></li>
                    <li><a href="#info">Info</a></li>
                </ul>
            </div>
        </nav>
    </header>
    <main>
        <section id="about" class="container">
            <h2>About Simy Framework</h2>
            <p>
                Simy is a lightweight PHP framework designed for modern web development. It is open-source, and contributions are welcomed.
            </p>
        </section>
        
        <section id="links" class="container">
            <h2>Useful Links</h2>
            <p>
                GitHub Repository: <a href="https://github.com/almhdy24/simy-framework" target="_blank">https://github.com/almhdy24/simy-framework</a>
            </p>
        </section>

        <section id="info" class="container">
            <h2>Server Information</h2>
            <hr />
            <p>PHP Version: <span style="color:blue"><?= phpversion() ?></span></p>
            <p>Simy Version: <strong>1.0.0</strong></p>
            <p>Base URL: <span style="color:pink"><a href="<?= $_ENV['base_url'] ?>"><?= $this->env('base_url') ?></a></span></p>
            <p>Database Driver: <span style="color:green"><?= $_ENV['DB_CONNECTION'] ?></span></p>
            <p>
                For detailed PHP server information, run <code style="color:red">phpinfo()</code> or <a href="?phpinfo=true" target="_blank">click here</a>.
            </p>
        </section>
    </main>
    <footer>
        <div class="container">
            <p>&copy; <?= date('Y') ?> Simy Framework. All Rights Reserved. | <a href="https://github.com/almhdy24/simy-framework" target="_blank">GitHub</a></p>
        </div>
    </footer>
</body></p>
        </div>
    </footer>
</body>
</html>