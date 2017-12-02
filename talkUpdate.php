<?php
/**
 * Created by IntelliJ IDEA.
 * User: Smiker
 * Date: 11/28/17
 * Time: 2:44 AM
 */


require_once('MyConnection.php');

$uid = $_COOKIE['userId'];

$time = date("Y-m-d H:i:s");
$talk = htmlspecialchars($_POST['talk']);

// PostType = 0: TalkTalk, 1: Diary 2: Image 3: Video

$query_insertUserPost = "INSERT INTO UserPost(posttime, userid, posttype) VALUES ('$time','$uid',0)";

$query_insertUserPost_res = mysqli_query($mysqli, $query_insertUserPost);

if ( $query_insertUserPost_res) {

    $query_getPostId = "SELECT POSTID FROM USERPOST WHERE POSTTIME = '$time' AND userid = '$uid'";
    $postId = mysqli_fetch_row(mysqli_query($mysqli, $query_getPostId))[0];

    $query_insertTalk = "INSERT INTO talktable(talk, postid) VALUES ('$talk','$postId')";
    if (mysqli_query($mysqli, $query_insertTalk)){
        echo "<script>alert('Post Successfully!')</script>";
        echo "<script type='text/javascript'>";
        echo "window.location.href='index.php'";
        echo "</script>";
    } else{
        echo "<script>alert('Post failed!')</script>";
        echo "<script type='text/javascript'>";
        echo "window.location.href='index.php'";
        echo "</script>";
    }
}
else   echo "<script>alert('Post talk wrong')</script>";
