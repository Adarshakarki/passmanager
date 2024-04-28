<?php
session_start();
include 'connection.php';
if (!isset($_SESSION['email'])) {
    header('Location: login.php'); // Redirect to login page if not logged in
    exit();
}



if (isset($_POST['submit'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $email  = $_SESSION['email'];
    $sql= "INSERT INTO `notes`(`email`, `title`, `content`) VALUES ('$email','$title','$content')";
    $result=mysqli_query($conn,$sql);
    if ($result) {
    echo("data inserted into notes");
    header('Location: addnote.php');
}
    else {echo("data not inserted into `notes`");}

}

else{
    echo("failed    " );
}