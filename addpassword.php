
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>add password</title>
    <link rel="stylesheet" href="addpassword.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body>
    <div>
        <form action="passhandeler.php" method="post">
            <h1>Add Password</h1>
            <div>Title <input type="text" name="title" placeholder="enter title"></div>
            <div>website<input type="text" name="website" placeholder="enter website"> </div>
            <div>Email<input type="text" name="webemail" placeholder="enter email"></div>
            <div>Password: <input type="password" name=" passwd" placeholder="enter password "></div>
            <button onclick="location.href='home.php'" type="button"><i class="fas fa-home"></i></button>
            <input type="submit" name="submit" value="submit" />
        </form>
    </div>


</body>

</html>