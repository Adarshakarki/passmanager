<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Sign Up</title>
    <link rel="stylesheet" href="signup.css">
</head>

<body>
    <div class="signup-container">
        <a href="https://imgbb.com/" aria-label="Logo">
            <img src="https://i.ibb.co/89pRc76/Untitled-1-1-removebg-preview.png" alt="Logo" border="0">
        </a>
        <form id="signupForm" action="sign.php" method="post">
            <label for="name">Email:</label>
            <input type="email" id="email" name="email" required>
            <label for="password">Password:</label>
            <input type="password" id="passwd" name="passwd" required>
            <img src="eye.svg" id="eyeIcon" alt="Eye Icon" onclick="togglePassword()">
            <button type="submit">Sign Up</button>
        </form>
        <p class="center-text">Already have an account? <a href="login.php">Login</a></p>
    </div>
    <script src="signup.js"></script>
</body>

</html>