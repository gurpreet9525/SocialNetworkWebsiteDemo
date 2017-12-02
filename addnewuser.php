<?php

require_once('MyConnection.php');
session_start();

$_SESSION['loggedin'] = 0;

$email = htmlspecialchars($_POST['EmailAdd']);
$password = htmlspecialchars($_POST['Password']);
$username = htmlspecialchars($_POST['Username']);
$a = "You have successfully registered.";
$b = "This email address has been registered, please sign in.";
$c = "This username has been used, please change another one.";
$url = "login.html";
$url1 = "index.php";

$query_checkEmail = "SELECT EmailAdd FROM UserInfo WHERE EmailAdd = '$email'";
$checkEmail_result = mysqli_query($mysqli, $query_checkEmail);
$checkEmail_row = mysqli_fetch_row($checkEmail_result);
if ($checkEmail_row[0] != null){
    echo "<script>alert('{$b}')</script>";
    echo "<script type='text/javascript'>";
    echo "window.location.href='$url'";
    echo "</script>";
}

$query_checkUsername = "SELECT UserName FROM UserInfo WHERE UserName = '$username'";
$checkUsername_result = mysqli_query($mysqli, $query_checkUsername);
$checkUsername_row = mysqli_fetch_row($checkUsername_result);
if ($checkUsername_row[0] != null){
    echo "<script>alert('{$c}')</script>";
    echo "<script type='text/javascript'>";
    echo "window.location.href='register.php'";
    echo "</script>";
}

$portraitPath = "img/defaultP.jpg";
$insertnew = "INSERT INTO UserInfo (EmailAdd,Password,UserName,user_portrait_path) VALUES('$email','$password','$username','$portraitPath')";
$result_insertnew = mysqli_query($mysqli,$insertnew);

$query_userId = "select userid from userinfo where emailadd = '$email'";
$userId = mysqli_fetch_row(mysqli_query($mysqli, $query_userId))[0];

$_SESSION['loggedin'] = 1;
setcookie("userId","$userId");
setcookie("userName","$username");

echo "<script>alert('{$a}')</script>";
echo "<script type='text/javascript'>";
echo "window.location.href='$url1'";
echo "</script>";




