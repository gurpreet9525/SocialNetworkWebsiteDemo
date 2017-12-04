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

        <div class="headband"></div>

        <header id="header" class="header">
            <div class="header-inner"><div class="site-brand-wrapper">
                    <div class="site-meta ">

                        <div class="custom-logo-site-title">
                            <a href="/"  class="brand" rel="start">
                                <span class="logo-line-before"><i></i></span>
                                <span class="site-title">Not A Big Deal</span>
                                <span class="logo-line-after"><i></i></span>
                            </a>
                        </div>
                        <p class="site-subtitle">Just Kidding, it matters!</p>
                    </div>

                    <div class="site-nav-toggle">
                        <button>
                            <span class="btn-bar"></span>
                            <span class="btn-bar"></span>
                            <span class="btn-bar"></span>
                        </button>
                    </div>
                </div>
            </div>
        </header>

    <main id="main" class="main">
        <div class="main-inner">
            <div class="content-wrap">
                <div id="content" class="content">
                    <div id="posts" class="posts-expand">
                        <article class="post post-type-normal ">
                            <span hidden itemprop="author">
                                <header class="post-header">
                                    <h1 class="post-title">
                                        <?php echo $dtitle ?>
                                    </h1>
                                    <div class="post-meta">
                                        <span class="post-time">
                                            <span class="post-meta-item-icon">
                                                <i class="fa fa-calendar-o"></i>
                                            </span>
                                            <span class="post-meta-item-text">Posted on</span>
                                            <time title="Post created">
                                                <?php echo $time ?>
                                            </time>
                                        </span>
                                    </div>
                                </header>
                                <div class="post-body" itemprop="articleBody">
                                    <?php echo htmlspecialchars_decode($dcontent) ?>
                                </div>
                                <div></div><div></div><div></div>
                                <footer class="post-footer">

                                </footer>
                            </span>
                        </article>
                        <div class="post-spread"></div>
                    </div>
                </div>
                <div class="comments" id="comments">

                </div>
            </div>
            <div class="sidebar-toggle">
                <div class="sidebar-toggle-line-wrap">
                    <span class="sidebar-toggle-line sidebar-toggle-line-first"></span>
                    <span class="sidebar-toggle-line sidebar-toggle-line-middle"></span>
                    <span class="sidebar-toggle-line sidebar-toggle-line-last"></span>
                </div>
            </div>
            <aside id="sidebar" class="sidebar">
                <div class="sidebar-inner">
                    <ul class="sidebar-nav motion-element">
                        <li class="sidebar-nav-toc sidebar-nav-active" data-target="post-toc-wrap">
                            Table of Contents
                        </li>
                        <li class="sidebar-nav-overview" data-target="site-overview">
                            Overview
                        </li>
                    </ul>
                    <section class="site-overview sidebar-panel">
                        <div class="site-author motion-element" itemprop="author" itemscope
                             itemtype="http://schema.org/Person">
                            <img class="site-author-image" itemprop="image"
                                 src="/uploads/avatar.png"
                                 alt="Ucm"/>
                            <p class="site-author-name" itemprop="name">Ucm</p>
                            <p class="site-description motion-element" itemprop="description"></p>
                        </div>
                        <nav class="site-state motion-element">
                            <div class="site-state-item site-state-posts">
                                <a href="/archives">
                                    <span class="site-state-item-count">1</span>
                                    <span class="site-state-item-name">posts</span>
                                </a>
                            </div>
                        </nav>
                        <div class="links-of-author motion-element">
                        </div>
                    </section>
                </div>
            </aside>
        </div>
    </main>
    <footer id="footer" class="footer">
        <div class="footer-inner">
            <div class="copyright">
                &copy;
                <span>2017</span>
                <span class="with-love">
                    <i class="fa fa-heart"></i>
                </span>
                <span class="author" style="cursor: pointer"><a href="https://github.com/ucmucm">喵喵喵</a></span>
            </div>
            <div class="author">
                Made by <a class="theme-link" href="https://github.com/ucmucm">Ucm</a>
            </div>
        </div>
    </footer>
    <div class="back-to-top">
        <i class="fa fa-arrow-up"></i>
    </div>
</div>

<script type="text/javascript">
    if (Object.prototype.toString.call(window.Promise) !== '[object Function]') {
        window.Promise = null;
    }
</script>
<script type="text/javascript" src="/lib/jquery/index.js?v=2.1.3"></script>
<script type="text/javascript" src="/lib/fastclick/lib/fastclick.min.js?v=1.0.6"></script>
<script type="text/javascript" src="/lib/jquery_lazyload/jquery.lazyload.js?v=1.9.7"></script>
<script type="text/javascript" src="/lib/velocity/velocity.min.js?v=1.2.1"></script>
<script type="text/javascript" src="/lib/velocity/velocity.ui.min.js?v=1.2.1"></script>
<script type="text/javascript" src="/lib/fancybox/source/jquery.fancybox.pack.js?v=2.1.5"></script>
<script type="text/javascript" src="/lib/canvas-ribbon/canvas-ribbon.js"></script>
</body>
</html>

