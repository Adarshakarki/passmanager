<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('Location: login.php'); // Redirect to login page if not logged in
    exit();
}
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="home.css">
    </head>
    <nav class="navbar">
        <div class="logo_item">
            <img src="https://i.ibb.co/89pRc76/Untitled-1-1-removebg-preview.png" alt="Logo">
        </div>
        <div class="parent">
            <div class="div1 grid-item" onclick="location.href='addpassword.php'">Add Password</div>
            <div class="div2 grid-item" onclick="location.href='vaultverification.php'">Vault</div>
            <div class="div3 grid-item" onclick="location.href='addnote.php'">Add Note</div>
            <div class="div4 grid-item" onclick="location.href='viewnote.php'">Notes</div>
            <div class="div5 grid-item" onclick="location.href='passgen.html'"> Passgen</div>
            <div class="div6 grid-item" onclick="location.href='faqs.html'">FAQs</div>
            <div class="div7 grid-item" onclick="window.location.href='https://github.com/Adarshakarki/passmanager'">Updates</div>
            <div class="div8 sign-out" onclick="location.href='signout.php'">Sign Out</div>
        </div>

        <?php
    if (!isset($_SESSION["email"])) {
        header("Location: login.php");
        exit();
    }?>
            </body>

    </html>