<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">Dashboard</h2>
    <p>Welcome, <?= $_SESSION['user'] ?>!</p>
    <a href="/logout" class="btn btn-danger">Logout</a>
</div>
</body>
</html>