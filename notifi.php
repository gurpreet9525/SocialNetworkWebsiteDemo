<?php
/**
 * Created by IntelliJ IDEA.
 * User: Smiker
 * Date: 12/1/17
 * Time: 10:52 PM
 */
session_start();

if($_SESSION['loggedin']!=1) {
    header("Location:login.html");
    exit;
}

//到这里为止
//下面就可以写保护页面的内容了，使用get方法传参数来log out

$uid = $_COOKIE['userId'];
$username = $_COOKIE['userName'];
$isLastPage = false;

require_once('MyConnection.php');

if ($_GET){
    $page = $_GET['page'];
    if ($page < 0) $page = 0;
}
$newPage = $page * 18;


$query_recent_msg = "select userid1, content, notificationtype, notificationid, ntime, postid from notificationtable where userid2 = '$uid' ORDER BY ntime DESC LIMIT $newPage, 18";

$i = 0;
$recent_not = array();

// 0: userId From 1: content, 2: type, 3: notification id, 4: time 5: postId

if ($query_recent_not_result = mysqli_query($mysqli, $query_recent_msg)){
    while ($row_recent = mysqli_fetch_row($query_recent_not_result)) {
        $recent_not[$i][0] = $row_recent[0];
        $recent_not[$i][1] = $row_recent[1];
        $recent_not[$i][2] = $row_recent[2];
        $recent_not[$i][3] = $row_recent[3];
        $recent_not[$i][4] = $row_recent[4];
        $recent_not[$i][5] = $row_recent[5];
        $i++;
    }
}
else {
    echo "<script>alert('Wrong result')</script>";
}


// PostType = 0: comment, 1: msg

$recent_msg = array();

// 0: userId From 1: content, 2: type, 3: notification id, 4: time, 5: postId, 6: portrait path, 7: username

$k = 0;
for ($j = 0; $j <= count($recent_not); $j++){

    $userId = $recent_not[$j][0];
    $recent_msg[$j][0] = $recent_not[$j][0];
    $recent_msg[$j][1] = $recent_not[$j][1];
    $recent_msg[$j][2] = $recent_not[$j][2];
    $recent_msg[$j][3] = $recent_not[$j][3];
    $recent_msg[$j][4] = $recent_not[$j][4];
    $recent_msg[$j][5] = $recent_not[$j][5];


    // fetch original content

    // type


    // set portrait path and username;
    $query_other = "select username, user_portrait_path from userinfo where userid = '$userId'";
    $query_other_result = mysqli_fetch_row(mysqli_query($mysqli, $query_other));
    $recent_msg[$j][6] = $query_other_result[1];
    $recent_msg[$j][7] = $query_other_result[0];
}




?>



<!DOCTYPE html>
<html lang="en">
<head>
    <title>Index</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <!--        <script src="js/jquery.min.js"></script>-->
    <!--    <link rel="stylesheet" href="css/bootstrap.min.css" >-->
    <link rel="stylesheet" href="css/diy.css">
    <link href="/lib/fancybox/source/jquery.fancybox.css?v=2.1.5" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Lato:300,300italic,400,400italic,700,700italic&subset=latin,latin-ext" rel="stylesheet" type="text/css">
    <link href="/lib/font-awesome/css/font-awesome.min.css?v=4.6.2" rel="stylesheet" type="text/css" />
    <link href="/css/main.css?v=5.1.0" rel="stylesheet" type="text/css" />


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!--    <script src="js/bootstrap.min.js"></script>-->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://unpkg.com/vue"></script>

</head>
<body>
<div class="container">
    <div class="row clearfix">
        <div class="col-md-12 column">
            <div class="page-header">
                <h1>
                    <small> </small>
                </h1>
            </div>
            <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span><span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="glyphicon glyphicon-user" aria-hidden="false"></span>
                        <span class="icon-bar"></span>
                    </button> <a class="navbar-brand" href="index.php">Home</a>
                </div>

                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li>
                            <a href="notifi.php">Notification</a>
                        </li>
                        <li>
                            <a href="#">Message</a>
                        </li>
                    </ul>
                    <form class="navbar-form navbar-left" role="search">
                        <div class="form-group">
                            <input type="text" class="form-control" />
                        </div> <button type="submit" class="btn btn-default">Search</button>
                    </form>
                    <ul class="nav navbar-nav navbar-right">
                        <ul class="nav navbar-nav">
                            <li>
                                <a href="editprofile.php">Settings</a>
                            </li>
                            <li>
                                <a href="logout.php">Log out &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>
                            </li>
                        </ul>
                    </ul>
                </div>

            </nav>
        </div>
    </div>
    <div class="row clearfix">
        <div class="col-md-2 column">
        </div>
        <div class="col-md-8 column">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title" align="center">Notifications</h3>
                </div>
                    <ul class="list-group">

                    <?php
                    if (!$row_recent){
                        echo "<li class=\"list-group-item\"><p align='center'>No notifications yet!</p></li>";
                    }
            for ($i = 0; $i<18; $i++){
                // 0: userId From 1: content, 2: type, 3: notification id, 4: time, 5: postId, 6: portrait path, 7: username
            if ($recent_msg[$i][1] != null){

                ?>
                <li class="list-group-item">
                    <div class="row">
                    <div class="col-xs-2 col-sm-2">
                        <img src=<?php echo $recent_msg[$i][6]?>>
                    </div>
                    <div class="col-xs-10 col-sm-10">
                        <b style="cursor: pointer" onclick="location='profile.php?uid=<?php echo $recent_msg[$i][0]?>'"><?php echo $recent_msg[$i][7] ?></b>&nbsp;&nbsp;
                        <span class="post-time">
<!--                            <span class="post-meta-item-icon">-->
<!--                                <i class="fa fa-calendar-o"></i>-->
<!--                            </span>-->
                            <span class="post-meta-item-text">Comments your <a href="#"><b>talk talk</b></a>&nbsp;</span>
                            <time class="post-meta-item-text">
                                <?php echo $recent_msg[$i][4]?>
                            </time>
                        </span>
                        <p>
                            <?php echo $recent_msg[$i][1]?>
                        </p>
                    </div>
                </div>
                </li>
            <?php }}?>
                    </ul>
            </div>
        </div>


        </div>
        <div class="col-md-2 column">
        </div>
    </div>
</div>
</body>
</html>
