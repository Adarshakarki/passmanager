
<?php
session_start();
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>addnotes</title>
        <link rel="stylesheet" href="addnote.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    </head>

    <body>
        <div>
            <form action="submitnote.php" method="post">
                <h1>Add note</h1>
                <input type="text" name="title" placeholder="enter title">
                <textarea id="text" name="content" placeholder="enter content" style="height:150px"></textarea>
                <?php
        $email = $_SESSION['email'];
        ?>
                    <button onclick="location.href='home.php'" type="button"><i class="fas fa-home"></i></button>
                    <input type="submit" name="submit" value="submit" />
            </form>
        </div>
    </body>

    </html>