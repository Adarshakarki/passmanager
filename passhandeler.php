<?php
session_start();
include 'connection.php';
if (!isset($_SESSION['email'])) {
    header('Location: login.php'); // Redirect to login page if not logged in
    exit();
}



if (isset($_POST['submit'])) {
    $title = $_POST['title'];
    $website = $_POST['website'];
    $webemail = $_POST['webemail'];
    $email  = $_SESSION['email'];
    $passwd = $_POST['passwd'];
    $encryptionKey = "qwertyuiop123456"; 
$encryptedPasswd = openssl_encrypt($passwd, "aes-256-cbc", $encryptionKey, 0, $encryptionKey);
   $sql="INSERT INTO `userpassword`(`useremail`, `title`, `webemail`, `passwd`, `website`) VALUES ('$email','$title','$webemail','$encryptedPasswd','$website')";
    $result=mysqli_query($conn,$sql);
    if ($result) {
    echo("password addded");
header("Location:addpassword.php");}
    else {echo("data not inserted into password");}

}

else{
    echo("failed    " );
}