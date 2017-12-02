<?php
/**
 * Created by IntelliJ IDEA.
 * User: Smiker
 * Date: 11/28/17
 * Time: 2:01 PM
 */


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

$postOldPassword = htmlspecialchars($_POST['oldpassword']);
$newPassword = htmlspecialchars($_POST['newpassword']);


$userPortraitPath = "img/{$uid}/";

if (is_uploaded_file($_FILES["file"]["tmp_name"])) {
    if ((($_FILES["file"]["type"] == "image/gif")
            || ($_FILES["file"]["type"] == "image/jpeg")
            || ($_FILES["file"]["type"] == "image/png"))
        && ($_FILES["file"]["size"] < 100000)) {
        if ($_FILES["file"]["error"] > 0) {
        } else {
            $_FILES["file"]["name"] = "{$uid}_portrait";

            $userImageFolderPath = "/Applications/MAMP/htdocs/img/{$uid}";

            if (!file_exists($userImageFolderPath)) {
                mkdir("{$userImageFolderPath}", 0777, true);
            };

//                if (!file_exists($userImageFolderPath."/".$_FILES["file"]["name"].".gif")) {
//                    unlink($userImageFolderPath."/".$_FILES["file"]["name"].".gif");
//                };
//                if (!file_exists($userImageFolderPath."/".$_FILES["file"]["name"].".jpeg")) {
//                    unlink($userImageFolderPath."/".$_FILES["file"]["name"].".jpeg");
//                };
//                if (!file_exists($userImageFolderPath."/".$_FILES["file"]["name"].".png")) {
//                    unlink($userImageFolderPath."/".$_FILES["file"]["name"].".png");
//                };
//                if (!file_exists($userImageFolderPath."/".$_FILES["file"]["name"].".jpg")) {
//                    unlink($userImageFolderPath."/".$_FILES["file"]["name"].".jpg");
//                };


            if ($_FILES["file"]["type"] == "image/gif") {
                move_uploaded_file($_FILES["file"]["tmp_name"],
                    "{$userImageFolderPath}/" . $_FILES["file"]["name"] . ".gif");
                $userPortraitPath = "{$userPortraitPath}/" . $_FILES["file"]["name"] . ".gif";
            } else if ($_FILES["file"]["type"] == "image/jpeg") {
                move_uploaded_file($_FILES["file"]["tmp_name"],
                    "{$userImageFolderPath}/" . $_FILES["file"]["name"] . ".jpeg");
                $userPortraitPath = "{$userPortraitPath}/" . $_FILES["file"]["name"] . ".jpeg";

            } else if ($_FILES["file"]["type"] == "image/png") {

                move_uploaded_file($_FILES["file"]["tmp_name"],
                    "{$userImageFolderPath}/" . $_FILES["file"]["name"] . ".png");
                $userPortraitPath = "{$userPortraitPath}/" . $_FILES["file"]["name"] . ".png";

            } else if ($_FILES["file"]["type"] == "image/jpg") {

                move_uploaded_file($_FILES["file"]["tmp_name"],
                    "{$userImageFolderPath}/" . $_FILES["file"]["name"] . ".jpg");
                $userPortraitPath = "{$userPortraitPath}/" . $_FILES["file"]["name"] . ".jpg";

            }
            $query_insertPortraitPath = "update userinfo set user_portrait_path = '$userPortraitPath' WHERE userid = '$uid'";
            mysqli_query($mysqli, $query_insertPortraitPath);
        }
    } else {
        echo "<script>alert('Invalided file! Accepted types: gif/jpg/jpeg/png. Size must less than 20KB')</script>";
    }
}






$query = "SELECT Password FROM UserInfo WHERE UserId = '$uid'";
$query_ = mysqli_query($mysqli, $query);
$query_result = mysqli_fetch_row($query_);
$oldPassword = $query_result[0];

if ($postOldPassword != $oldPassword){
    echo "<script>alert('Wrong password! Please try again')</script>";
    echo "<script type='text/javascript'>";
    echo "window.location.href='editprofile2.php'";
    echo "</script>";
}

$query_changePassword = "update userinfo set password = '$newPassword' WHERE userid = '$uid'";
mysqli_query($mysqli, $query_changePassword);
echo "<script>alert('Password change successfully!')</script>";
echo "<script type='text/javascript'>";
echo "window.location.href='editprofile2.php'";
echo "</script>";


