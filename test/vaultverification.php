<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify User</title>
    <link rel="stylesheet" href="verification.css">
</head>

<body>
    <?php
    session_start();
    ?>
    <form action="verify.php" method="POST" class="verify-container">
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" readonly value="<?php echo isset($_SESSION['email']) ? $_SESSION['email'] : ''; ?>"><br>
        <label for="password">Password:</label><br>
        <input type="password" id="passwd" name="passwd" required><br><br>
        <input type="submit" value="Verify">
    </form>
</body>

</html>
