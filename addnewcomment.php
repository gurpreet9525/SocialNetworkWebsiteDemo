<?php

require_once('MyConnection.php');
session_start();


$comment = htmlspecialchars($_POST['comment']);
$postid = htmlspecialchars($_POST['postid']);
$userid = htmlspecialchars($_POST['userid']);
$uid = $_COOKIE['userId'];
$time = date("Y-m-d H-i-s");


$query_addcomment = "INSERT INTO CommentTable(userid,commentcontent,postid,commentdate) VALUES ('$uid','$comment','$postid','$time') ";

$query_countBefore = "select commentcount from userpost where postid = '$postid'";
$countBefore = mysqli_fetch_row(mysqli_query($mysqli, $query_countBefore))[0];
$countAfter = $countBefore + 1;
$query_update_countNumber = "update userpost set commentcount = '$countAfter' WHERE postid = '$postid'";
$query_insert_notification = "insert into notificationtable(postid, userid1, userid2, content, ntime) VALUES ('$postid', '$uid','$userid','$comment','$time')";

//echo "<script>alert('{$postid}')</script>";
//echo "<script>alert('{$uid}')</script>";
//echo "<script>alert('{$userid}')</script>";
//echo "<script>alert('{$comment}')</script>";
//echo "<script>alert('{$time}')</script>";


if (mysqli_query($mysqli,$query_addcomment)){
    mysqli_query($mysqli, $query_update_countNumber);
    mysqli_query($mysqli, $query_insert_notification);
    echo "<script>alert('Post successfully')</script>";
} else{
    echo "<script>alert('Post failed!')</script>";

}
?>