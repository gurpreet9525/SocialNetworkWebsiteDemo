<?php
/**
 * Created by IntelliJ IDEA.
 * User: Smiker
 * Date: 12/2/17
 * Time: 1:41 AM
 */
require_once('MyConnection.php');
session_start();


$type = htmlspecialchars($_POST['type']);
$postid = htmlspecialchars($_POST['postid']);

// PostType = 0: TalkTalk, 1: Diary 2: Image 3: Video

// 先删掉所有comment
// 顺序 先删talktable 再删image/video 最后post
// 先删 diarytable 再删post
// DELETE FROM `imagetable` WHERE `imagetable`.`IMAGEID` = 34"
//"DELETE FROM `talktable` WHERE `talktable`.`TalkId` = 29"
//"DELETE FROM `diarytable` WHERE `diarytable`.`DIARYID` = 28"
//"DELETE FROM `userpost` WHERE `userpost`.`PostId` = 157"

$query_deleteComment = "delete from commenttable where commenttable.postid = '$postid'";
if (mysqli_query($mysqli, $query_deleteComment)) {
    if ($type == 0) {
        $query_deleteTalkTable = "delete from talktable where `talktable`.`postid` = '$postid'";
        if (mysqli_query($mysqli, $query_deleteTalkTable)) {
            $query_deletePost = "delete from userpost where `userpost`.`postid` = '$postid'";
            if (mysqli_query($mysqli, $query_deletePost)) {
                echo "<script>alert('Delete successfully')</script>";
                echo "<script type='text/javascript'>";
                echo "window.location.href='index.php'";
                echo "</script>";
            } else {
                echo "<script>alert('Delete post table fail!')</script>";
            }
        } else {
            echo "<script>alert('Delete talkTable fail!')</script>";
        };

    } else if ($type == 1) {
        $query_deleteDiary = "DELETE FROM `diarytable` WHERE `diarytable`.`postid` = '$postid'";
        if (mysqli_query($mysqli, $query_deleteDiary)) {
            $query_deletePost = "delete from userpost where `userpost`.`postid` = '$postid'";
            if (mysqli_query($mysqli, $query_deletePost)) {
                echo "<script>alert('Delete successfully')</script>";
                echo "<script type='text/javascript'>";
                echo "window.location.href='index.php'";
                echo "</script>";
            } else {
                echo "<script>alert('Delete post table fail!')</script>";
            }
        } else {
            echo "<script>alert('Delete diary fail!')</script>";
        };
    } else if ($type == 2) {
        $query_deleteImage = "DELETE FROM `imagetable` WHERE `imagetable`.`postid` = '$postid'";
        if (mysqli_query($mysqli, $query_deleteImage)) {
            $query_deleteTalkTable = "delete from talktable where `talktable`.`postid` = '$postid'";
            if (mysqli_query($mysqli, $query_deleteTalkTable)) {
                $query_deletePost = "delete from userpost where `userpost`.`postid` = '$postid'";
                if (mysqli_query($mysqli, $query_deletePost)) {
                    echo "<script>alert('Delete successfully')</script>";
                    echo "<script type='text/javascript'>";
                    echo "window.location.href='index.php'";
                    echo "</script>";
                } else {
                    echo "<script>alert('Delete post table fail!')</script>";
                }
            } else {
                echo "<script>alert('Delete image talkTable fail!')</script>";
            };
        } else {
            echo "<script>alert('Delete image fail!')</script>";
        }
    } else {
        $query_deleteVideo = "DELETE FROM `videotable` WHERE `videotable`.`postid` = '$postid'";
        if (mysqli_query($mysqli, $query_deleteVideo)) {
            $query_deleteTalkTable = "delete from talktable where `talktable`.`postid` = '$postid'";
            if (mysqli_query($mysqli, $query_deleteTalkTable)) {
                $query_deletePost = "delete from userpost where `userpost`.`postid` = '$postid'";
                if (mysqli_query($mysqli, $query_deletePost)) {
                    echo "<script>alert('Delete successfully')</script>";
                    echo "<script type='text/javascript'>";
                    echo "window.location.href='index.php'";
                    echo "</script>";
                } else {
                    echo "<script>alert('Delete post table fail!')</script>";
                }
            } else {
                echo "<script>alert('Delete Video talkTable fail!')</script>";
            };
        } else {
            echo "<script>alert('Delete Video fail!')</script>";
        }
    }
} else{
    echo "<script>alert('Delete comment failed')</script>";
    echo "<script type='text/javascript'>";
    echo "window.location.href='index.php'";
    echo "</script>";
}