<?php

session_start();

if($_SESSION['loggedin']!=1) {
    header("Location:login.html");
    exit;
}


require_once('MyConnection.php');
$uid = $_COOKIE['userId'];

$query = "SELECT FirstName, LastName, CityName, user_title, birth, user_status , gender, user_portrait_path, username FROM UserInfo NATURAL JOIN CityTable WHERE UserId = '$uid'";
$query_ = mysqli_query($mysqli, $query);
$query_result = mysqli_fetch_row($query_);
$FirstName = $query_result[0];
$LastName = $query_result[1];
$city = $query_result[2];
$title = $query_result[3];
$birth = $query_result[4];
$status = $query_result[5];
$gender = $query_result[6];
$portraitPath = $query_result[7];
$username = $query_result[8];


if ($_GET){
    $uid = $_GET['uid'];
    $query = "SELECT FirstName, LastName, CityName, user_title, birth, user_status , gender, user_portrait_path, username FROM UserInfo NATURAL JOIN CityTable WHERE UserId = '$uid'";
    $query_ = mysqli_query($mysqli, $query);
    $query_result = mysqli_fetch_row($query_);
    $FirstName = $query_result[0];
    $LastName = $query_result[1];
    $city = $query_result[2];
    $title = $query_result[3];
    $birth = $query_result[4];
    $status = $query_result[5];
    $gender = $query_result[6];
    $portraitPath = $query_result[7];
    $username = $query_result[8];
}



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit profile</title>
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

</head>
<body>
<div class="container">
    <div class="row clearfix">
        <div class="col-md-1 column">
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
        <div class="col-md-10 column">
            <br /><br /><br /><br />
            <div class="panel panel-info">
                <div class="panel-heading"><h4>&nbsp;&nbsp;Profile</h4></div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-8 col-sm-6">
                                <br />
                                <p align="center" >
                                    <img alt="140x140" src=<?php echo ($portraitPath == null ? "img/defaultP.jpg" : $portraitPath);?> />
                                </p>
                                <p>
                                <h5 align="center">
                                    <?php echo $username;?> <br /><br />
                                    <?php echo $status;?><br />
                                </h5>
                                </p>
                            </div>
                            <div class="col-xs-4 col-sm-6"><br />
                                <h5>
                                    Name:   &nbsp;&nbsp;&nbsp;<font color="#4286f4" ><?php echo $FirstName;?>  <?php echo $LastName;?> </font><br /><br />
                                </h5>
                                <h5>
                                    Title:   &nbsp;&nbsp;&nbsp;<font color="#4286f4" ><?php echo $title;?> </font><br /><br />
                                </h5>
                                <h5>
                                    Gender: &nbsp;&nbsp;&nbsp;<font color="#4286f4" ><?php echo $gender;?> </font><br /><br />
                                </h5>
                                <h5>
                                    City of residence:   &nbsp;&nbsp;&nbsp;<font color="#4286f4" ><?php echo $city;?> </font><br /><br />
                                </h5>
                                <h5>
                                    Name:   &nbsp;&nbsp;&nbsp;<font color="#4286f4" ><?php echo $FirstName;?>  <?php echo $LastName;?> </font><br /><br />
                                </h5>
                                <h5>
                                    Name:   &nbsp;&nbsp;&nbsp;<font color="#4286f4" ><?php echo $FirstName;?>  <?php echo $LastName;?> </font><br /><br />
                                </h5>
                                <h5>
                                    Name:   &nbsp;&nbsp;&nbsp;<font color="#4286f4" ><?php echo $FirstName;?>  <?php echo $LastName;?> </font><br /><br />
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-1 column">
        </div>

    </div>
</div>

</body>
</html>