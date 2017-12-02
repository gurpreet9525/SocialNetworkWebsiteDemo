<?php

//session_start();
//
////每个文件前都加上这么一段
//$logout=$_GET['logout'];
//if($logout ==1)
//    $_SESSION['loggedin']=0;
//
//if($_SESSION['loggedin']!=1)
//{
//    header("Location:login.php");
//    exit;
//}
require_once('MyConnection.php');

$uid = $_COOKIE['userId'];
$time = date("Y-m-d H-i-s");

$tag = htmlspecialchars($_POST['tag']);
$talk = htmlspecialchars($_POST['talk']);

if (is_uploaded_file($_FILES["img"]["tmp_name"]) || is_uploaded_file($_FILES["video"]["tmp_name"])) {

    $postId = 0;
    $tagId = 0;

    // get tagId
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


    if(is_uploaded_file($_FILES["img"]["tmp_name"])) {

        if (($_FILES["img"]["type"] == "image/gif")
            || ($_FILES["img"]["type"] == "image/jpeg")
            || ($_FILES["img"]["type"] == "image/png")
            || ($_FILES["img"]["type"] == "image/jpg")
        ) {
            $userImgPath = "img/{$uid}/";

            if ($_FILES["img"]["error"] > 0) {
            } else {

                // set file name
                $_FILES["img"]["name"] = $uid . "_img_" . $time;

                $imageName = $_FILES["img"]["name"];

                $userImageFolderPath = "/Applications/MAMP/htdocs/img/{$uid}";

                if (!file_exists($userImageFolderPath)) {
                    mkdir("{$userImageFolderPath}", 0777, true);
                };

                // PostType = 0: TalkTalk, 1: Diary 2: Image 3: Video

                $query_insertUserPost = "INSERT INTO UserPost(posttime, userid, posttype) VALUES ('$time','$uid',2)";

                $query_insertUserPost_res = mysqli_query($mysqli, $query_insertUserPost);

                if ($query_insertUserPost_res) {

                    // get postId
                    $query_getPostId = "SELECT POSTID FROM USERPOST WHERE POSTTIME = '$time' AND userid = '$uid'";
                    $postId = mysqli_fetch_row(mysqli_query($mysqli, $query_getPostId))[0];

                } else echo "Insert Post Wrong";


                // get imagePath
                if ($_FILES["img"]["type"] == "image/gif") {
                    move_uploaded_file($_FILES["img"]["tmp_name"],
                        "{$userImageFolderPath}/" . $_FILES["img"]["name"] . ".gif");
                    $userImgPath = "{$userImgPath}" . $imageName . ".gif";
                } if ($_FILES["img"]["type"] == "image/jpeg") {
                    move_uploaded_file($_FILES["img"]["tmp_name"],
                        "{$userImageFolderPath}/" . $_FILES["img"]["name"] . ".jpeg");
                    $userImgPath = "{$userImgPath}" . $imageName . ".jpeg";

                } if ($_FILES["img"]["type"] == "image/png") {

                    move_uploaded_file($_FILES["img"]["tmp_name"],
                        "{$userImageFolderPath}/" . $_FILES["img"]["name"] . ".png");
                    $userImgPath = "{$userImgPath}" . $imageName . ".png";

                } if ($_FILES["img"]["type"] == "image/jpg") {

                    move_uploaded_file($_FILES["img"]["tmp_name"],
                        "{$userImageFolderPath}/" . $_FILES["img"]["name"] . ".jpg");
                    $userImgPath = "{$userImgPath}" . $imageName . ".jpg";

                }

                // insert image to imageTable
                $query_insertImage = "insert into imagetable(tagid, imagepath, postid, imagename) VALUES ('$tagId','$userImgPath', '$postId', '$imageName')";

                if (mysqli_query($mysqli, $query_insertImage)) {

                    //get imgId
                    $query_getImageId = "select imageid from imagetable where postid = '$postId'";

                    $imageId = mysqli_fetch_row(mysqli_query($mysqli, $query_getImageId))[0];

                    // insert talkTable query
                    $query_insertTalkTable = "insert into talktable(talk, postid, imageid) VALUES ('$talk', '$postId', '$imageId')";

                    if (mysqli_query($mysqli, $query_insertTalkTable)) {
                        echo "<script>alert('Post Successfully!')</script>";
                        echo "<script type='text/javascript'>";
                        echo "window.location.href='index.php'";
                        echo "</script>";
                    } else echo "insert talk table wrong";

                } else echo "insert image query wrong";

            }
        } else {
            echo "<script>alert('Invalided file! Accepted types: gif/jpg/jpeg/png. Size must less than 20KB')</script>";
        }
    }

    if(is_uploaded_file($_FILES["video"]["tmp_name"])) {


        if ($_FILES["video"]["type"] == "video/mp4") {

            $userVideoPath = "video/{$uid}/";

            if ($_FILES["video"]["error"] > 0) {
            } else {

                // set file name
                $_FILES["video"]["name"] = $uid . "_video_" . $time;

                $videoName = $_FILES["video"]["name"];

                $userVideoFolderPath = "/Applications/MAMP/htdocs/video/{$uid}";

                if (!file_exists($userVideoFolderPath)) {
                    mkdir("{$userVideoFolderPath}", 0777, true);
                };

                // PostType = 0: TalkTalk, 1: Diary 2: Image 3: Video

                $query_insertUserPost = "INSERT INTO UserPost(posttime, userid, posttype) VALUES ('$time','$uid',3)";

                $query_insertUserPost_res = mysqli_query($mysqli, $query_insertUserPost);

                if ($query_insertUserPost_res) {

                    // get postId
                    $query_getPostId = "SELECT POSTID FROM USERPOST WHERE POSTTIME = '$time' AND userid = '$uid'";
                    $postId = mysqli_fetch_row(mysqli_query($mysqli, $query_getPostId))[0];

                } else echo "Insert Post Wrong";


                // get videoPath
                move_uploaded_file($_FILES["video"]["tmp_name"],
                    "{$userVideoFolderPath}/" . $_FILES["video"]["name"] . ".mp4");
                $userVideoPath = "{$userVideoPath}" . $_FILES["video"]["name"] . ".mp4";

                // insert video to videoTable
                $query_insertVideo = "insert into videotable(tagid, videopath, postid, videoname) VALUES ('$tagId','$userVideoPath', '$postId', '$videoName')";


                if (mysqli_query($mysqli, $query_insertVideo)) {

                    //get videoId
                    $query_getVideoId = "select videoid from videotable where postid = '$postId'";

                    $videoId = mysqli_fetch_row(mysqli_query($mysqli, $query_getVideoId))[0];

                    // insert talkTable query
                    $query_insertTalkTable = "insert into talktable(talk, postid, videoid) VALUES ('$talk', '$postId', '$videoId')";

                    if (mysqli_query($mysqli, $query_insertTalkTable)) {
                        echo "<script>alert('Post Successfully!')</script>";
                        echo "<script type='text/javascript'>";
                        echo "window.location.href='index.php'";
                        echo "</script>";
                    } else echo "insert talk table wrong";


                } else echo "insert video query wrong";


            }
        } else {
            echo "<script>alert('Invalided file! Accepted types: gif/jpg/jpeg/png. Size must less than 20KB')</script>";
        }
    }


}
else{
    echo "<script>alert('No file selected!')</script>";
    echo "<script type='text/javascript'>";
    echo "window.location.href='index.php'";
    echo "</script>";
}

