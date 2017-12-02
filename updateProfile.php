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
$originalUsername = $_COOKIE['userName'];

$firstName = htmlspecialchars($_POST['firstName']);
$lastName = htmlspecialchars($_POST['lastName']);
$birth = htmlspecialchars($_POST['birth']);
$gender = htmlspecialchars($_POST['gender']);
$residence = htmlspecialchars($_POST['residence']);
$status = htmlspecialchars($_POST['status']);
$title = htmlspecialchars($_POST['title']);
$username = htmlspecialchars($_POST['username']);



// check username
if($username != $originalUsername) {

    $query_checkUsername = "SELECT userid FROM UserInfo WHERE username = '$username'";

    if (mysqli_fetch_row(mysqli_query($mysqli, $query_checkUsername))[0]) {
        echo "<script>alert('Username already exists! Please try another one!')</script>";
        $username = $originalUsername;
        echo "<script type='text/javascript'>";
        echo "window.location.href='editprofile.php'";
        echo "</script>";
    }
}



$userPortraitPath = "img/{$uid}/";

if (is_uploaded_file($_FILES["file"]["tmp_name"])) {
    if ((($_FILES["file"]["type"] == "image/gif")
            || ($_FILES["file"]["type"] == "image/jpeg")
            || ($_FILES["file"]["type"] == "image/png")
            || ($_FILES["file"]["type"] == "image/jpg")
        )
        && ($_FILES["file"]["size"] < 5000000)) {
        if ($_FILES["file"]["error"] > 0) {
        } else {

            $userImageFolderPath = "/Applications/MAMP/htdocs/img/{$uid}";

            if (!file_exists($userImageFolderPath)) {
                mkdir("{$userImageFolderPath}", 0777, true);
            };

            $_FILES["file"]["name"] = "{$uid}_portrait";

            $uploadedFile = $_FILES['file']['tmp_name'];

            // Create an Image from it so we can do the resize

            $src;

            if ($_FILES["file"]["type"] == "image/jpeg" ||$_FILES["file"]["type"] == "image/jpg") {
                $src = imagecreatefromjpeg($uploadedFile);
            }

            if ($_FILES["file"]["type"] == "image/png") {
                $src = imagecreatefrompng($uploadedFile);
            }

            if ($_FILES["file"]["type"] == "image/gif") {
                $src = imagecreatefromgif($uploadedFile);
            }

            // Capture the original size of the uploaded image

            list($width,$height)=getimagesize($uploadedFile);

            // For our purposes, I have resized the image to be
            // 600 pixels wide, and maintain the original aspect
            // ratio. This prevents the image from being "stretched"
            // or "squashed". If you prefer some max width other than
            // 600, simply change the $newwidth variable

            $newWidth=140;

            $newHeight=($height/$width)*140;

            $tmp = imagecreatetruecolor($newWidth,$newHeight);

            // this line actually does the image resizing, copying from the original
            // image into the $tmp image

            imagecopyresampled($tmp,$src,0,0,0,0,$newWidth,$newHeight,$width,$height);

            // now write the resized image to disk. I have assumed that you want the
            // resized, uploaded image file to reside in the ./images subdirectory.

            $filename;
            $originalFilePath;

            if ($_FILES["file"]["type"] == "image/gif") {
                $filename = "{$userImageFolderPath}/" . $_FILES["file"]["name"] . ".gif";
                $originalFilePath = "{$userPortraitPath}" . $_FILES["file"]["name"] . "_original.gif";
                $userPortraitPath = "{$userPortraitPath}" . $_FILES["file"]["name"] . ".gif";
            }

            if ($_FILES["file"]["type"] == "image/jpeg") {
                $filename = "{$userImageFolderPath}/" . $_FILES["file"]["name"] . ".jpeg";
                $originalFilePath = "{$userPortraitPath}" . $_FILES["file"]["name"] . "_original.jpeg";
                $userPortraitPath = "{$userPortraitPath}" . $_FILES["file"]["name"] . ".jpeg";
            }
            if ($_FILES["file"]["type"] == "image/jpg") {
                $filename = "{$userImageFolderPath}/" . $_FILES["file"]["name"] . ".jpg";
                $originalFilePath = "{$userPortraitPath}" . $_FILES["file"]["name"] . "_original.jpg";
                $userPortraitPath = "{$userPortraitPath}" . $_FILES["file"]["name"] . ".jpg";
            }
            if ($_FILES["file"]["type"] == "image/png") {
                $filename = "{$userImageFolderPath}/" . $_FILES["file"]["name"] . ".png";
                $originalFilePath = "{$userPortraitPath}" . $_FILES["file"]["name"] . "_original.png";
                $userPortraitPath = "{$userPortraitPath}" . $_FILES["file"]["name"] . ".png";
            }

            imagejpeg($tmp,$filename,100);
            imagejpeg($src,$originalFilePath,100);

            imagedestroy($src);
            imagedestroy($tmp);

            $query_insertPortraitPath = "update userinfo set user_portrait_path = '$userPortraitPath' WHERE userid = '$uid'";
            mysqli_query($mysqli, $query_insertPortraitPath);
        }
    } else {
        echo "<script>alert('Invalided file! Accepted types: gif/jpg/jpeg/png. Size must less than 5MB')</script>";
        echo "<script type='text/javascript'>";
        echo "window.location.href='editprofile.php'";
        echo "</script>";
    }
}


// check whether city exists
$query_checkCity = "SELECT cityname from citytable WHERE cityname = '$residence'";
$result_checkCity = mysqli_query($mysqli, $query_checkCity);

if (mysqli_num_rows($result_checkCity) == 0) {
    $query_insertCity = "Insert into citytable(cityname) VALUES ('$residence')";
    mysqli_query($mysqli, $query_insertCity);
}

$query_getCityId = "select cityid from citytable where cityname = '$residence'";
$cityId = mysqli_fetch_row(mysqli_query($mysqli, $query_getCityId))[0];


$query_update = "UPDATE UserInfo SET FirstName = '$firstName', LastName= '$lastName', Birth = '$birth',
                  Gender = '$gender', cityid = '$cityId', user_status = '$status', user_title = '$title', username = '$username' 
                  WHERE userid = '$uid'";
if (mysqli_query($mysqli, $query_update)) {
    setcookie("userName","$username");
    echo "<script>alert('Update Successfully!')</script>";
    echo "<script type='text/javascript'>";
    echo "window.location.href='editprofile.php'";
    echo "</script>";
} else {
    echo "<script>alert('Edit wrong!')</script>";
    echo "<script type='text/javascript'>";
    echo "window.location.href='editprofile.php'";
    echo "</script>";
}
