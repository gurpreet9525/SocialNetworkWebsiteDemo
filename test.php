<?php
/**
 * Created by IntelliJ IDEA.
 * User: Smiker
 * Date: 12/2/17
 * Time: 1:19 PM
 */
session_start();

if ($_SESSION['loggedin'] != 1) {
    header("Location:login.html");
    exit;
}

$uid = $_COOKIE['userId'];
$username = $_COOKIE['userName'];

require_once('MyConnection.php');

if ($_GET) {
    $postid = $_GET['postid'];
}
// get post time
$query_getTime = "select posttime from userpost where postid = '$postid'";
$time = mysqli_fetch_row(mysqli_query($mysqli, $query_getTime))[0];
$dcontent;
$dtitle;

$query_info = "select dtitle, tagid from diarytable where postid = '$postid'";
if ($query_result = mysqli_fetch_row(mysqli_query($mysqli, $query_info))) {
    $dtitle = $query_result[0];
    $tagid = $query_result[1];
} else  echo "<script>alert('Get diary info wrong!')</script>";

$query_content = "select DCONTENTPATH from diarytable where postid = '$postid'";

if ($fetch_content = mysqli_fetch_row(mysqli_query($mysqli, $query_content))) {
    $dcontent = $fetch_content[0];
} else echo "<script>alert('Get diary content wrong!')</script>";


// fetch tag
$query_getTag = "select tag from tag where tagid = '$tagid'";
$tag = mysqli_fetch_row(mysqli_query($mysqli, $query_getTag))[0];


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>Index</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/diy.css">
    <link href="/lib/fancybox/source/jquery.fancybox.css?v=2.1.5" rel="stylesheet" type="text/css"/>
    <link href="https://fonts.googleapis.com/css?family=Lato:300,300italic,400,400italic,700,700italic&subset=latin,latin-ext" rel="stylesheet" type="text/css">
    <link href="/lib/font-awesome/css/font-awesome.min.css?v=4.6.2" rel="stylesheet" type="text/css"/>
    <link href="/css/main.css?v=5.1.0" rel="stylesheet" type="text/css"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://unpkg.com/vue"></script>


    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
    <link href="/lib/fancybox/source/jquery.fancybox.css?v=2.1.5" rel="stylesheet" type="text/css" />
    <link href="//fonts.googleapis.com/css?family=Lato:300,300italic,400,400italic,700,700italic&subset=latin,latin-ext" rel="stylesheet" type="text/css">
    <link href="/lib/font-awesome/css/font-awesome.min.css?v=4.6.2" rel="stylesheet" type="text/css" />
    <link href="/css/main.css?v=5.1.0" rel="stylesheet" type="text/css" />
    <meta name="keywords" content="Hexo, NexT" />
    <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico?v=5.1.0" />
    <meta name="description" content="Welcome to Hexo! This is your very first post. Check documentation for more info. If you get any problems when using Hexo, you can find the answer in troubleshooting or you can ask me on GitHub. Quick">
    <meta name="keywords">
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="Hello World">
    <meta name="twitter:description" content="Welcome to Hexo! This is your very first post. Check documentation for more info. If you get any problems when using Hexo, you can find the answer in troubleshooting or you can ask me on GitHub. Quick">
    <script type="text/javascript" id="hexo.configurations">
        var NexT = window.NexT || {};
        var CONFIG = {
            root: '/',
            scheme: 'Pisces',
            sidebar: {"position":"left","display":"post","offset":12,"offset_float":0,"b2t":false,"scrollpercent":false},
            fancybox: true,
            motion: true,
            duoshuo: {
                userId: '0',
                author: 'Author'
            },
            algolia: {
                applicationID: '',
                apiKey: '',
                indexName: '',
                hits: {"per_page":10},
                labels: {"input_placeholder":"Search for Posts","hits_empty":"We didn't find any results for the search: ${query}","hits_stats":"${hits} results found in ${time} ms"}
            }
        };
    </script>




</head>

<body>

<div class="container sidebar-position-left page-post-detail ">

    <div class="row clearfix">
        <div class="col-md-12 column">
            <div class="page-header">
                <h1>
                    <small></small>
                </h1>
            </div>
            <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse"
                            data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span><span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="glyphicon glyphicon-user" aria-hidden="false"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="index.php">Home</a>
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
                            <input type="text" class="form-control"/>
                        </div>
                        <button type="submit" class="btn btn-default">Search</button>
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
        <div class="col-md-10 column">

            <h1 class="post-title">
                <?php echo $dtitle ?>
            </h1>
            <div class="post-body" itemprop="articleBody">
                <?php echo htmlspecialchars_decode($dcontent) ?>
            </div>
        </div>
        <div class="col-md-2 column">
        </div>
    </div>

</body>
</html>

