
<?php
session_start();

if($_SESSION['loggedin']!=1) {
    header("Location:login.html");
    exit;
}
$uid = $_COOKIE['userId'];
$username = $_COOKIE['userName'];

require_once('MyConnection.php');

$query_user = "SELECT user_status, user_portrait_path FROM UserInfo  WHERE UserId = '$uid'";
$query_result_user = mysqli_fetch_row(mysqli_query($mysqli, $query_user));
$userStatus = $query_result_user[0];
$userPortrait = $query_result_user[1];

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <title>Sign in</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<!--    <link rel="stylesheet" href="css/bootstrap.min.css" >-->
    <link rel="stylesheet" href="css/diy.css">
    <link href="/lib/fancybox/source/jquery.fancybox.css?v=2.1.5" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Lato:300,300italic,400,400italic,700,700italic&subset=latin,latin-ext" rel="stylesheet" type="text/css">
    <link href="/lib/font-awesome/css/font-awesome.min.css?v=4.6.2" rel="stylesheet" type="text/css" />
    <link href="/css/main.css?v=5.1.0" rel="stylesheet" type="text/css" />

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <script charset="UTF-8" src="editor/kindeditor-all.js"></script>
    <script CHARSET="UTF-8" src="editor/lang/zh-CN.js"></script>
    <script charset="UTF-8" src="editor/lang/en.js"></script>
    <script>
        KindEditor.ready(function (K) {
            window.editor = K.create('#editor_1');
        });

        function formSubmit() {
            x = document.getElementById("editor_1");
            x.innerHTML=editor.html();
            document.getElementById("diarySubmit").submit();
        }

    </script>

    <!-- include summernote css/js-->
    <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote.css" rel="stylesheet">
    <script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote.js"></script>




</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-2 column">
                <div class="page-header">
                    <h1>
                        <small> </small>
                    </h1>
                </div>
                <img alt="140x140" onclick="location='profile.php'" style="cursor: pointer" src=<?php echo ($userPortrait == null ? "img/defaultP.jpg" : $userPortrait);?> />
                <br />
                <dl>
                    <dt>
                        <p align="center"> <?php echo $username?></p>
                        <p align="center"><?php echo $userStatus?></p>
                    </dt>
                </dl>
            </div>

            <div class="col-md-8 column">
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
                                <a href="#">Notification</a>
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
                <form class="form-horizontal" id="diarySubmit" role="form" action="postUpdate.php", method="post">
                <h1 align="center">Title</h1>
                    <input type="text" class="form-control" align="center" name="title" required><br />
<!--                    <div id="summernote" class="summernote" ></div>-->
                    <textarea id="editor_1" class="form-control" name="content" style="height: 700px; width: 100%"></textarea>
                    <p><br /></p>
                    <div class="form-horizontal">
                        <!--<label class="sr-only" for="tag">Amount (in dollars)</label>-->
                        <div class="input-group">
                            <div class="input-group-addon">Tag</div>
                            <input type="text" class="form-control"  name="tag" id="tag" placeholder="Tag">
                        </div>
                    </div>
                <p><br />
                    <input type="button" onclick="formSubmit()" class="btn btn-primary btn-lg" value="Post"/>
                </p>
                </form>
            </div>
            <div class="col-md-2 column">占位</div>
        </div>
    </div>

</body>
</html>