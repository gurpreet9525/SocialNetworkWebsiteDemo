<?php
/**
 * Created by IntelliJ IDEA.
 * User: Smiker
 * Date: 11/28/17
 * Time: 2:44 AM
 */


require_once('MyConnection.php');

$uid = $_COOKIE['userId'];
$time = date("Y-m-d H-i-s");
$title = htmlspecialchars($_POST['title']);
$content = htmlspecialchars($_POST['content']);
$tag = htmlspecialchars($_POST['tag']);
$tagId = 0;

// PostType = 0: TalkTalk, 1: Diary 2: Image 3: Video

$query_insertUserPost = "INSERT INTO UserPost(posttime, userid, posttype) VALUES ('$time','$uid',1)";

$query_insertUserPost_res = mysqli_query($mysqli, $query_insertUserPost);

if ( $query_insertUserPost_res) {

    $query_getPostId = "SELECT POSTID FROM USERPOST WHERE POSTTIME = '$time' AND userid = '$uid'";
    $postId = mysqli_fetch_row(mysqli_query($mysqli, $query_getPostId))[0];

    $query_getTagId = "select tagid from tag where tag = '$tag'";

    $fetch_tagId = mysqli_fetch_row(mysqli_query($mysqli, $query_getTagId));

    if ($fetch_tagId[0] == null) {

        $insertTagIdQuery = "INSERT INTO TAG(TAG) VALUES ('$tag')";

        $query_insertTagId = mysqli_query($mysqli, $insertTagIdQuery);

        if ($query_insertTagId) {
            $tagId = mysqli_fetch_row(mysqli_query($mysqli, $query_getTagId))[0];
        }

        else {
            echo "Insert Wrong";
        }
    } else
    {
        $tagId = $fetch_tagId[0];
    }

    $query_insertDiary = "INSERT INTO DIARYTABLE(dtitle, DCONTENTPATH, tagid, postid) VALUES ('$title','$content','$tagId','$postId')";
    $insertDiary = mysqli_query($mysqli, $query_insertDiary);
    echo "<script>alert('Post successfully')</script>";
    echo "<script type='text/javascript'>";
    echo "window.location.href='index.php'";
    echo "</script>";
}
else echo "Insert Post Wrong";










