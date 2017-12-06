<?php

session_start();
require_once('MyConnection.php');

if($_SESSION['loggedin']!=1) {
    header("Location:login.html");
    exit;
}

$uid = $_COOKIE['userId'];
$username = $_COOKIE['userName'];

$searchContent = htmlspecialchars($_POST['searchContent']);

// search users

// search diary


// search talk


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
                    <form action="search.php" method="post" class="navbar-form navbar-left" role="search">
                        <div class="form-group">
                            <input type="text" class="form-control" name="searchContent" />
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

            <ul class="nav nav-tabs">
                <li><a href="#users" data-toggle="tab">Users</a></li>
                <li><a href="#talk" data-toggle="tab">Talk talk</a></li>
                <li><a href="#diary" data-toggle="tab">Diary</a></li>
            </ul>


            <div class="tab-content">
                <div class="tab-pane active" id="users">

                    <table class="table table-striped">

                <?php
                //search
                $query_select_users = "SELECT username, firstname, lastname, user_portrait_path,userid FROM userinfo WHERE Username LIKE '%$searchContent%'";
                if ($query_result_users = mysqli_query($mysqli, $query_select_users)){
                    while ($fetch_users = mysqli_fetch_row($query_result_users)){
                        $username_s = $fetch_users[0];
                        $firstname_s = $fetch_users[1];
                        $lastname_s = $fetch_users[2];
                        $userportrait_s = $fetch_users[3];
                        $userid_s = $fetch_users[4];
                        if ($userid_s == $uid) continue;
                        ?>
                        <tbody>
                        <tr>
                        <td>
                            <b><img height="50px" width="50px" class="pull-left" src=<?php echo $userportrait_s?>>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;@<?php echo $username_s?><br/></b>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo "$firstname_s $lastname_s"?>

                            <?php
                            // is friend?
                            $user1;
                            $user2;
                            if ($userid_s < $uid){
                                $user1 = $userid_s;
                                $user2 = $uid;
                            }
                            else{
                                $user1 = $uid;
                                $user2 = $userid_s;
                            }

                            $query_isFriend = "select Relation from friends where userid1 = '$user1' and userid2 = '$user2'";
                            $query_friend_result = mysqli_fetch_row(mysqli_query($mysqli, $query_isFriend));
                            // no friend request
                            if ($query_friend_result == null){
                                ?>

                                <form action="addfriends" method="post">
                                    <input type="hidden" name="userid1" value=<?php echo $user1?>>
                                    <input type="hidden" name="userid2" value=<?php echo $user2?>>
                                    <button class="btn btn-sm pull-right" type="submit">Add friend</button>
                                </form>

                                <?php
                            }

                            // have request
                            else if ($query_friend_result[0] == 0){

                                ?>
                                <form action="addfriends" method="post">
                                    <input type="hidden" name="userid1" value=<?php echo $user1?>>
                                    <input type="hidden" name="userid2" value=<?php echo $user2?>>
                                    <button class="btn btn-primary pull-right" type="submit">Sent request</button>
                                </form>

                                <?php
                            }
                            ?>


                        </td>
                        </tr>
                        </tbody>
                        <?php
                    }
                } else echo"<h5>No such users!</h5>"

                ?>

                    </table>

                </div>
                <div class="tab-pane" id="talk">...</div>
                <div class="tab-pane" id="diary">...</div>
            </div>

        </div>
        <div class="col-md-2 column">
        </div>
    </div>
</div>
</body>
</html>

