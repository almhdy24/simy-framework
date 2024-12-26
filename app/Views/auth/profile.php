<!DOCTYPE html>
<html>
<head>
    <title>Profile</title>
</head>
<body>
    <h2>Profile</h2>
    <p>Email: <?php echo htmlspecialchars($user->email); ?></p>
    <p>Name: <?php echo htmlspecialchars($user->name); ?></p>
    <!-- Add other user information as needed -->
    <p><a href="/auth/logout">Logout</a></p>
</body>
</html>