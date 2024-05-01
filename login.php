<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login.css">
    <title>Login</title>
</head>

<body>
    <div class="login-container">
        <a href="https://imgbb.com/" aria-label="Logo">
            <img src="https://i.ibb.co/89pRc76/Untitled-1-1-removebg-preview.png" alt="Logo" border="0">
        </a>
        <form id="loginForm" action="authenticator.php" method="post">
            <label for="email">Email:</label>
            <input type="email" id="useremail" name="email" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="passwd" required>
            <img src="eye.svg" id="eyeIcon" alt="Eye Icon" onclick="togglePassword()">
            <button type="submit" name="submit" value="submit">Login</button>
            <p class="center-text">Don't have an account? <a href="signup.php">Sign Up here</a>.</p>
        </form>
    </div>
    <script src="login.js"></script>
</body>

</html>