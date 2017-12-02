<?php
session_start();

if($_SESSION['loggedin']!=1) {
    header("Location:login.html");
    exit;
}



require_once('MyConnection.php');
$uid = $_COOKIE['userId'];

$query = "SELECT Password, user_portrait_path FROM UserInfo WHERE UserId = '$uid'";
$query_ = mysqli_query($mysqli, $query);
$query_result = mysqli_fetch_row($query_);
$oldPassword = $query_result[0];
$portraitPath = $query_result[1];


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Index</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <!--    <script src="js/jquery.min.js"></script>-->
<!--    <link rel="stylesheet" href="css/bootstrap.min.css" >-->
    <link rel="stylesheet" href="css/diy.css">
    <link href="/lib/fancybox/source/jquery.fancybox.css?v=2.1.5" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Lato:300,300italic,400,400italic,700,700italic&subset=latin,latin-ext" rel="stylesheet" type="text/css">
    <link href="/lib/font-awesome/css/font-awesome.min.css?v=4.6.2" rel="stylesheet" type="text/css" />
    <link href="/css/main.css?v=5.1.0" rel="stylesheet" type="text/css" />


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

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
        </div>
    </div>
    <form action="updatePassword.php" method="post">

        <div class="row clearfix">
            <div class="col-md-2 column">
                <img alt="140x140" src=<?php echo ($portraitPath == null ? "img/defaultP.jpg" : $portraitPath);?> />
                <div class="form-group">
                    <br />
                    <a href="javascript:;" class="file">
                        <input type="file" name="file" id="file"> Choose file
                    </a>
                    <p class="help-block">Upload your portrait here.</p>
                </div>
            </div>
            <div class="col-md-8 column">
                <ul class="breadcrumb">
                    <li>
                        <a href="editprofile.php">General</a>
                    </li>
                    <li>
                        <a href="editprofile2.php">Change Password</a>
                    </li>
                </ul>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <label>Old Password *&nbsp;&nbsp;&nbsp;&nbsp;</label>
                        <input class="inp1" type="password" name="oldpassword" id="opw" placeholder="Old Password">
                    </div>
                    <div class="panel-body">
                        <label>New Password *&nbsp;&nbsp;&nbsp;</label>
                        <input class="inp1" type="password" name="newpassword" id="pw1" placeholder="New Password">
                    </div>

                    <div class="panel-body">
                        <label>New Password *&nbsp;&nbsp;&nbsp;</label>
                        <input class="inp1" type="password" id="pw2" placeholder="New Password" onkeyup="validate()">
                        <span id="warning"></span>
                    </div>
                    <div class="panel-body">
                        <button type="submit" id="submit" class="btn btn-primary" >Update</button>
                    </div>

                </div>
            </div>
            <div class="col-md-2 column">
            </div>
        </div>
    </form>
    <script>
        function validate() {
            var pw1 = document.getElementById("pw1").value;
            var pw2 = document.getElementById("pw2").value;
            if (pw1 == pw2){
                document.getElementById("warning").innerHTML="<font color = 'green'>Right</font>";
                document.getElementById("submit").disabled = false;
            }
            else{
                document.getElementById("warning").innerHTML="<font color = 'red'>Different new password</font>";
                document.getElementById("submit").disabled = true;
            }
        }
    </script>
</div>

</body>
</html>
