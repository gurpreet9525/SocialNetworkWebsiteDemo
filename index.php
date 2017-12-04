<?php

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

$query_user = "SELECT user_status, user_portrait_path FROM UserInfo  WHERE UserId = '$uid'";
$query_result_user = mysqli_fetch_row(mysqli_query($mysqli, $query_user));
$userStatus = $query_result_user[0];
$userPortrait = $query_result_user[1];


$query_recent = "SELECT PostId, UserId, PostType, PostTime, LocationId, PostAuthId FROM UserPost ORDER BY PostTime DESC LIMIT $newPage, 18";

$i = 0;
$recent_post = array();

if ($query_recent_result = mysqli_query($mysqli, $query_recent)){
    while ($row_recent = mysqli_fetch_row($query_recent_result)) {
        $recent_post[$i][0] = $row_recent[0];
        $recent_post[$i][1] = $row_recent[1];
        $recent_post[$i][2] = $row_recent[2];
        $recent_post[$i][3] = $row_recent[3];
        $recent_post[$i][4] = $row_recent[4];
        $recent_post[$i][5] = $row_recent[5];
        $i++;
    }
}
else {
    echo "<script>alert('Wrong result')</script>";
}


// PostType = 0: TalkTalk, 1: Diary 2: Image 3: Video

$recent_show = array();

// 0: userId 1: username, 2: talk/title, 3: postTime, 4: location 5: tag, 6: img or video/diaryContent 7: postType 8: userPortrait 9: postId

$k = 0;
for ($j = 0; $j <= count($recent_post); $j++){

    $tagId;
    $postId = $recent_post[$j][0];
    $recent_show[$j][9] = $postId;
    $userId = $recent_post[$j][1];
    // set userId
    $recent_show[$j][0] = $userId;

    // set username;
    $query_username = "select username from userinfo where userid = '$userId'";
    $recent_show[$j][1] = mysqli_fetch_row(mysqli_query($mysqli, $query_username))[0];

    // set userPortrait;

    $query_userPortrait = "select user_portrait_path from userinfo where userid = '$userId'";
    $recent_show[$j][8] = mysqli_fetch_row(mysqli_query($mysqli, $query_userPortrait))[0];

    // set postTime;
    $recent_show[$j][3] = $recent_post[$j][3];

    // set location
    $recent_show[$j][4] = $recent_post[$j][4];


    if ($recent_post[$j][2] == 0){

        // set talk
        $query_selectTalk = "select talk from talktable WHERE postid = '$postId'";
        $recent_show[$j][2] = mysqli_fetch_row(mysqli_query($mysqli, $query_selectTalk))[0];
        $recent_show[$j][7] = 0;

    }
    else if ($recent_post[$j][2] == 1) {

        $recent_show[$j][7] = 1;
        $query_selectDiary = "select tagid, dtitle, dcontentpath from diarytable where postid = '$postId'";
        $query_selectDiary_result = mysqli_fetch_row(mysqli_query($mysqli, $query_selectDiary));
        $tagId = $query_selectDiary_result[0];
        $recent_show[$j][2] = $query_selectDiary_result[1];
        $recent_show[$j][6] = $query_selectDiary_result[2];

     }

    else if ($recent_post[$j][2] == 2){

        $recent_show[$j][7] = 2;
        $query_selectImage = "select talk, imageid from talktable WHERE postid = '$postId'";

        if ($selectImage_result = mysqli_query($mysqli, $query_selectImage)){
            $query_selectImage_result = mysqli_fetch_row($selectImage_result);
            $recent_show[$j][2] = $query_selectImage_result[0];
            $imageId = $query_selectImage_result[1];
            $query_selectImage = "select IMAGEPATH, tagid from imagetable where imageid = {$imageId}";

            if ($s1 = mysqli_query($mysqli, $query_selectImage)) {
                $image_result = mysqli_fetch_row($s1);
                $recent_show[$j][6] = $image_result[0];
                $tagId = $image_result[1];
            }
        }
        else echo "<script>alert('select image query wrong')</script>";


    }

    else {

        $recent_show[$j][7] = 3;
        $query_selectVideo = "select talk, videoId from talktable WHERE postid = '$postId'";

        if ($selectVideo_result = mysqli_query($mysqli, $query_selectVideo)){
            $query_selectVideo_result = mysqli_fetch_row($selectVideo_result);
            $recent_show[$j][2] = $query_selectVideo_result[0];
            $videoId = $query_selectVideo_result[1];
            $query_selectVideo = "select VIDEOPATH, tagid from videotable where videoid = {$videoId}";

            if ($s1 = mysqli_query($mysqli, $query_selectVideo)) {
                $video_result = mysqli_fetch_row($s1);
                $recent_show[$j][6] = $video_result[0];
                $tagId = $video_result[1];
//                echo "<script>alert('{$recent_show[$j][6]}')</script>";
            }
        }
        else echo "<script>alert('select image query wrong')</script>";

    }

    $query_selectTag = "select tag from tag where tagid = '$tagId'";
    $recent_show[$j][5] = mysqli_fetch_row(mysqli_query($mysqli, $query_selectTag));

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

    <script type="text/javascript">

        $(document).ready(function () {
            $(document.getElementById("iii")).click(function () {
                var v4 = <?php echo $userPortrait?>;
                var v1 = <?php echo $username ?>;
                var v2 = "time";
                var v3 = "content";
                $(document.getElementById("tail")).append("<div class='row'><br /><div class='col-xs-2 col-sm-2'><p><img src="+v4+"></p></div><div class='col-xs-10 col-sm-10'> <b style='cursor: pointer'>"+v1+"</b>&nbsp;&nbsp;&nbsp; <span class='post-time'> <span class='post-meta-item-icon'> <i class='fa fa-calendar-o'></i> </span> <span class='post-meta-item-text'>Posted on</span> <time title='Post created' >"+v2+"</time> </span> <br /> <p>"+v3+"</p> </div> </div>");
            });
        });
    </script>
    <script>
        function deletePostT() {
            document.getElementById("deleteFT").submit();
        }
    </script>
    <script>
        function deletePostD() {
            document.getElementById("deleteFD").submit();
        }
    </script>


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
            <img alt="140x140" onclick="location='index.php'" style="cursor: pointer" src=<?php echo ($userPortrait == null ? "img/defaultP.jpg" : $userPortrait);?> />
            <br />
            <dl>
                <dt>
                    <p onclick="location='profile.php'" style="cursor: pointer" align="center"> <?php echo $username?></p>
                    <p align="center"><?php echo $userStatus?></p>
                </dt>
            </dl>
        </div>
        <div class="col-md-7 column">
            <form action="talkUpdate.php" method="post">
                <div class="form-group">
                    <textarea class="form-control" id="tear" rows="3" placeholder="Talk Talk" name="talk" required="required"></textarea>
                </div>
                <div class="form-group">
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary pull-right">Post</button>
                    </div>
                </div>
            </form>
            <button class="btn btn-primary" data-toggle="modal" data-target="#uploadImg">
                <span class="glyphicon glyphicon-picture" aria-hidden="true"></span>
            </button>
            <button class="btn btn-primary" data-toggle="modal" data-target="#uploadVideo">
                <span class="glyphicon glyphicon-facetime-video" aria-hidden="true"></span>
            </button>
            <button class="btn btn-primary" data-toggle="modal" data-target="#uploadVideo" onclick="location='diarypost.php'">
                <span class="glyphicon glyphicon-book"></span>
            </button>
            <div class="modal fade" id="uploadImg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                &times;
                            </button>
                            <h4 class="modal-title" id="myModalLabel">
                                Please upload your image
                            </h4>
                        </div>
                        <form id="form_data" action="updateIndex.php" method="post" enctype="multipart/form-data">
                            <div class="modal-body">
                                <div class="form-group">
                                    <textarea class="form-control" id="tear" rows="3" placeholder="Talk Talk" name="talk"></textarea>
                                </div>
                                <div class="form-group">
                                    <a href="javascript:;" class="file">
                                        <span class="glyphicon glyphicon-picture" aria-hidden="true"></span>
                                        <input type="file" name="img" id="img">
                                    </a>
                                    <div class="input-group">
                                        <div class="input-group-addon">Tag</div>
                                        <input type="text" class="form-control"  name="tag" id="tag" placeholder="Tag">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <div class="form-group">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    Post
                                </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="uploadVideo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                &times;
                            </button>
                            <h4 class="modal-title" id="myModalLabel">
                                Please upload your video
                            </h4>
                        </div>
                        <form id="form_data" action="updateIndex.php" method="post" enctype="multipart/form-data">
                            <div class="modal-body">
                                <div class="form-group">
                                    <textarea class="form-control" id="tear" rows="3" placeholder="Talk Talk" name="talk"></textarea>
                                </div>
                                <div>
                                    <a href="javascript:;" class="file">
                                        <span class="glyphicon glyphicon-facetime-video" aria-hidden="true"></span>
                                        <input type="file" name="video" id="video" accept="video/mp4"/>
                                    </a>
                                    <div class="input-group">
                                        <div class="input-group-addon">Tag</div>
                                        <input type="text" class="form-control"  name="tag" id="tag" placeholder="Tag">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    Post
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <p><br /></p>



<!--   try-->
<!--post 1-->



           <?php
//               PostType = 0: TalkTalk, 1: Diary 2: Image 3: Video
//               0: userId 1: username, 2: talk/title, 3: postTime, 4: location 5: tag, 6: img or video/diaryContent 7: postType

           for ($i = 0; $i < 18; $i++){

               if ($recent_show[$i][2] != null || $recent_show[$i][6] != null){
              // is diary
               if ($recent_show[$i][7] == 1){ ?>
                   <div class="row">
                       <div class="col-xs-2 col-sm-2">
                           <p><img style="cursor: pointer" onclick="location='userTimeLine.php?uid=<?php echo $recent_show[$i][0]?>'"
                                       src= <?php echo ($recent_show[$i][8] == null) ? "img/defaultP.jpg" : $recent_show[$i][8] ?>></p>
                       </div>

                       <div class="col-xs-10 col-sm-10">
                           <p><b style="cursor: pointer" onclick="location='profile.php?uid=<?php echo $recent_show[$i][0]?>'"><?php echo $recent_show[$i][1] ?></b>&nbsp;&nbsp;&nbsp;
                               <span class="post-time">
                                   <span class="post-meta-item-icon">
                                       <i class="fa fa-calendar-o"></i></span>
                                   <span class="post-meta-item-text">Posted on</span>
                                   <time title="Post created" >
                                       <?php echo $recent_show[$i][3]?>
                                   </time>
                               </span>

                               <span class="post-category" >
                                   <span class="post-meta-divider">|</span>
                                   <span class="post-meta-item-icon">
                                       <i class="fa fa-folder-o"></i>
                                   </span>
                                   <span class="post-meta-item-text">In</span>
                                   <span itemprop="about"">
                                   <a href="#" itemprop="url" rel="index">
                                       <span itemprop="name"><?php echo $recent_post[$i][5]?></span>
                                   </a>
                               </span>
                               <span class="post-comments-count">
                                   <span class="post-meta-divider">|</span>
                                   <span class="post-meta-item-icon">
                                       <i class="fa fa-comment-o"></i>
                                   </span>
                                   <a data-toggle="collapse" href="#comment<?php echo $recent_show[$i][9]?>">
                                  <?php
                                  // comment count
                                  $query_comment_count = "select commentcount from userpost where postid = {$recent_show[$i][9]}";
                                  $comment_count = mysqli_fetch_row(mysqli_query($mysqli, $query_comment_count))[0];
                                  echo $comment_count;

                                  ?>
                                   </a>
                                   <span class="post-meta-divider">|</span>
                               </span>

                               <?php
                               if ($uid == $recent_show[$i][0]) {
                               // PostType = 0: TalkTalk, 1: Diary 2: Image 3: Video

                               // 顺序 先删talktable 再删image/video 最后post
                               // 先删 diarytable 再删post
                               // DELETE FROM `imagetable` WHERE `imagetable`.`IMAGEID` = 34"
                               //"DELETE FROM `talktable` WHERE `talktable`.`TalkId` = 29"
                               //"DELETE FROM `diarytable` WHERE `diarytable`.`DIARYID` = 28"
                               //"DELETE FROM `userpost` WHERE `userpost`.`PostId` = 157"
                               ?>

                               <span style="cursor: pointer" class='label label-danger' onclick="deletePostD()">Delete</span>
                           <form id="deleteFD" action="deletepost.php" method="post">
                               <input type="hidden" name="type" value=<?php echo $recent_show[$i][7]?>>
                               <input type="hidden" name="postid" value=<?php echo $recent_show[$i][9]?>>
                           </form>

                           <?php } ?>

                           </p>
                           <h1 class="post-title" align="center">
                           <a class="post-title-link" href="test.php?postid=<?php echo $recent_show[$i][9]?>">
                               <?php echo $recent_show[$i][2] ?>
                           </a>
                           </h1><?php  ?>
                           <br />
 <!--  0: userId 1: username, 2: talk/title, 3: postTime, 4: location 5: tag, 6: img or video/diaryContent 7: postType 8: userPortrait 9: postId-->
                           <div class="post-body">
                               <?php echo
                               htmlspecialchars_decode($recent_show[$i][6])?>
                           </div>
                           <br />

                           <footer class="post-footer">
                               <a class="btn btn-info" data-toggle="collapse" href="#comment<?php echo $recent_show[$i][9]?>" id="comments<?php echo $recent_show[$i][9]?>" aria-expanded="false" aria-controls="comment">
                                   <span class="post-meta-item-icon">
                                       <i class="fa fa-comment-o"></i>
                                   </span>
                               </a>
                               <div class="post-eof"></div>

                               <div class="collapse" id="comment<?php echo $recent_show[$i][9]?>">
                                   <div class="card card-block">

                                       <?php

                                       $query_comment = "select userid, commentcontent, commentdate from commenttable where postid = {$recent_show[$i][9]} ORDER by commentdate";
                                       if ($comment_result = mysqli_query($mysqli, $query_comment)){
                                           while ($comment_row = mysqli_fetch_row($comment_result)){

                                               // find username and portrait path
                                               $query_comment_userInfo = "select username, user_portrait_path  from userinfo where userid = '$comment_row[0]'";
                                               $fetch_comment_userInfo = mysqli_fetch_row(mysqli_query($mysqli, $query_comment_userInfo));
                                               $comment_username = $fetch_comment_userInfo[0];
                                               $comment_user_portrait = $fetch_comment_userInfo[1];

                                               $comment_date = $comment_row[2];
                                               $comment_content = $comment_row[1];
                                               ?>
                                               <div class="row">
                                                   <br />
                                                   <div class="col-xs-2 col-sm-2">
                                                       <p><img src=<?php echo $comment_user_portrait?>></p>
                                                   </div>
                                                   <div class="col-xs-10 col-sm-10">
                                                       <b style="cursor: pointer" onclick="location='profile.php?uid=<?php echo $comment_row[0]?>'"><?php echo $comment_username ?></b>&nbsp;&nbsp;&nbsp;
                                                       <span class="post-time">
                                        <span class="post-meta-item-icon">
                                            <i class="fa fa-calendar-o"></i>
                                        </span>
                                        <span class="post-meta-item-text">Posted on</span>
                                        <time title="Post created" >
                                            <?php echo $comment_date?>
                                        </time>
                                    </span>

                                                       <br />
                                                       <p><?php echo $comment_content?></p>
                                                   </div>
                                               </div>
                                               <?php
                                           }
                                       }

                                       ?>
                                   </div>
                                   <div class="card card-block">
                                       <iframe style="display:none;" id="hiddenPost" name="hiddenPost"></iframe>

                                       <form action="addnewcomment.php" method="post" target="hiddenPost">
                                           <div class="form-group">
                                               <textarea class="form-control" rows="3" placeholder="Add your comment..." name="comment" required="required"></textarea>
                                               <input type="hidden" name = "postid" value= <?php echo $recent_show[$i][9]?>>
                                               <input type="hidden" name = "userid" value= <?php echo $recent_show[$i][0]?>>
                                           </div>
                                           <div class="form-group">
                                               <div class="form-group">
                                                   <button type="submit" class="btn btn-primary pull-right">Comment</button>
                                               </div>
                                           </div>
                                       </form> <br />
                                   </div>
                               </div>
                           </footer>
                           <br />
                       </div>
                   </div>

                 <?php }

               // is talk
                  if ($recent_show[$i][7] != 1){ ?>

            <div class="row">
                <div class="col-xs-2 col-sm-2">
                    <p><img style="cursor: pointer" onclick="location='userTimeLine.php?uid=<?php echo $recent_show[$i][0]?>'"
                            src= <?php echo ($recent_show[$i][8] == null) ? "img/defaultP.jpg" : $recent_show[$i][8] ?>></p>
                </div>
                <div class="col-xs-10 col-sm-10">
                    <b style="cursor: pointer" onclick="location='profile.php?uid=<?php echo $recent_show[$i][0]?>'"><?php echo $recent_show[$i][1] ?></b>&nbsp;&nbsp;&nbsp;
                          <span class="post-time">
                              <span class="post-meta-item-icon">
                                  <i class="fa fa-calendar-o"></i></span>
                              <span class="post-meta-item-text">Posted on</span>
                              <time title="Post created" >
                                  <?php echo $recent_show[$i][3]?>
                              </time>
                          </span>

                          <?php
                          // If only talk, delete tag icon.
                          if ($recent_show[$i][7] != 0){?>
                          <span class="post-category" >
                              <span class="post-meta-divider">|</span>
                              <span class="post-meta-item-icon">
                                  <i class="fa fa-folder-o"></i>
                              </span>
                              <span class="post-meta-item-text">In</span>
                              <span>
                                  <a href="#" itemprop="url" rel="index">
                                      <span><?php echo $recent_post[$i][5]?></span>
                                  </a>
                              </span>
                          </span>
                          <?php } ?>

                          <span class="post-comments-count">
                              <span class="post-meta-divider">|</span>
                              <span class="post-meta-item-icon">
                                  <i class="fa fa-comment-o"></i>
                              </span>


                              <a  data-toggle="collapse" href="#comment<?php echo $recent_show[$i][9]?>">
                                  <?php

                                  // comment count
                                  $query_comment_count = "select commentcount from userpost where postid = {$recent_show[$i][9]}";
                                  $comment_count = mysqli_fetch_row(mysqli_query($mysqli, $query_comment_count))[0];
                                  echo $comment_count;

                                  ?>
                              </a>
                              <span class="post-meta-divider">|</span>
                          </span>

                    <?php
                    if ($uid == $recent_show[$i][0]) {
                        // PostType = 0: TalkTalk, 1: Diary 2: Image 3: Video

                        // 顺序 先删talktable 再删image/video 最后post
                        // 先删 diarytable 再删post
                        // DELETE FROM `imagetable` WHERE `imagetable`.`IMAGEID` = 34"
                        //"DELETE FROM `talktable` WHERE `talktable`.`TalkId` = 29"
                        //"DELETE FROM `diarytable` WHERE `diarytable`.`DIARYID` = 28"
                        //"DELETE FROM `userpost` WHERE `userpost`.`PostId` = 157"
                        ?>

                        <span style="cursor: pointer" class='label label-danger' onclick="deletePostT()">Delete</span>
                        <form id="deleteFT" action="deletepost.php" method="post">
                            <input type="hidden" name="type" value=<?php echo $recent_show[$i][7]?>>
                            <input type="hidden" name="postid" value=<?php echo $recent_show[$i][9]?>>
                        </form>

                    <?php } ?>


<!--       0: userId 1: username, 2: talk/title, 3: postTime, 4: location 5: tag, 6: img or video/diaryContent 7: postType 8: userPortrait 9: postId-->
                      <div class="post-body newFontSize">
                          <?php echo $recent_show[$i][2]?><br />
                          <?php
                          // if img
                          if ($recent_show[$i][7] == 2){
                              echo '<img src = "'.$recent_show[$i][6].'">';
                          }?>
                          <?php
                          // if video
                          if ($recent_show[$i][7] == 3){?>
                              <?php echo '<video width=100% height=100% controls="controls" src = "'.$recent_show[$i][6].'"></video>'; ?>
                          <?php }?>
                      </div>
                    <br />
                    <footer class="post-footer">
                        <a class="btn btn-info" data-toggle="collapse" href="#comment<?php echo $recent_show[$i][9]?>" id="comments<?php echo $recent_show[$i][9]?>" aria-expanded="false" aria-controls="comment">
                            <span class="post-meta-item-icon">
                                  <i class="fa fa-comment-o"></i>
                            </span>
                        </a>
                        <div class="post-eof"></div>

                        <div class="collapse" id="comment<?php echo $recent_show[$i][9]?>">
                            <div class="card card-block" id="tail">

                                <?php

                                $query_comment = "select userid, commentcontent, commentdate from commenttable where postid = {$recent_show[$i][9]} ORDER by commentdate";
                                if ($comment_result = mysqli_query($mysqli, $query_comment)){
                                    while ($comment_row = mysqli_fetch_row($comment_result)){

                                        // find username and portrait path
                                        $query_comment_userInfo = "select username, user_portrait_path  from userinfo where userid = '$comment_row[0]'";
                                        $fetch_comment_userInfo = mysqli_fetch_row(mysqli_query($mysqli, $query_comment_userInfo));
                                        $comment_username = $fetch_comment_userInfo[0];
                                        $comment_user_portrait = $fetch_comment_userInfo[1];

                                        $comment_date = $comment_row[2];
                                        $comment_content = $comment_row[1];
                                        ?>
                                        <div class="row">
                                            <br />
                                            <div class="col-xs-2 col-sm-2">
                                                <p><img src=<?php echo $comment_user_portrait?>></p>
                                            </div>
                                            <div class="col-xs-10 col-sm-10">
                                                <b style="cursor: pointer" onclick="location='profile.php?uid=<?php echo $comment_row[0]?>'"><?php echo $comment_username ?></b>&nbsp;&nbsp;&nbsp;
                                                <span class="post-time">
                                        <span class="post-meta-item-icon">
                                            <i class="fa fa-calendar-o"></i>
                                        </span>
                                        <span style="cursor: pointer" class="post-meta-item-text">Posted on</span>
                                        <time title="Post created" >
                                            <?php echo $comment_date?>
                                        </time>
                                    </span>
                                                <br />
                                                <p><?php echo $comment_content?></p>
                                            </div>
                                        </div>
                                        <?php

                                    }
                                }
                                ?>

                            </div>
                            <div class="card card-block">
                                <iframe style="display:none;" id="hiddenPost" name="hiddenPost"></iframe>

                                <form action="addnewcomment.php" method="post" target="hiddenPost">

                                    <div class="form-group">
                                        <textarea class="form-control" rows="3" placeholder="Add your comment..." name="comment" required="required"></textarea>
                                        <input type="hidden" name = "postid" value= <?php echo $recent_show[$i][9]?>>
                                        <input type="hidden" name = "userid" value= <?php echo $recent_show[$i][0]?>>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-group">
                                            <button id="iii" type="submit" class="btn btn-primary pull-right">Comment</button>
                                        </div>
                                    </div>
                                </form><br />


                            </div>
                        </div>

                    </footer>

                    <br />
                </div>
            </div>


                  <?php }}
                  else {
                   $isLastPage = true;
                   break;
                  }
           } ?>
            <form action="index.php" method="post">
                <ul class="pager">
                    <li class="previous"><a href="<?php
                        $page--;
                        if ($page < 0){
                            $page = 0;
                            echo "index.php?page=".$page;
                        }
                        else echo "index.php?page=".$page ?>">&larr; Older</a></li>
                    <li class="next"><a href="<?php
                        if ($isLastPage){
                            echo "index.php?page=".$page;
                        }
                        else echo "index.php?page=".($page+1) ?>">Newer &rarr;</a></li>
                </ul>
            </form>
        </div>
        <div class="col-md-3 column">
            <dl>
                <dt>
                    Description lists
                </dt>
                <dd>
                    A description list is perfect for defining terms.
                </dd>
                <dt>
                    Euismod
                </dt>
                <dd>
                    Vestibulum id ligula porta felis euismod semper eget lacinia odio sem nec elit.
                </dd>
                <dd>
                    Donec id elit non mi porta gravida at eget metus.
                </dd>
                <dt>
                    Malesuada porta
                </dt>
                <dd>
                    Etiam porta sem malesuada magna mollis euismod.
                </dd>
                <dt>
                    Felis euismod semper eget lacinia
                </dt>
                <dd>
                    Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.
                </dd>
            </dl>
        </div>
    </div>

    <footer id="footer" class="footer">
        <div class="footer-inner">
            <div class="copyright" >
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



</div>
</body>
</html>

