<?php
    session_start();
    //需要用isset来检测变量，不然php可能会报错。
    $_SESSION['loggedin'] = 0;

    require_once('MyConnection.php');

    $email = $_POST['EmailAdd'];
    $password = $_POST['Password'];

    $b = "This email has not been registered, please sign up!";
    $a = "Wrong password, please try again";

    $query_cz = "SELECT userid FROM UserInfo WHERE EmailAdd = '$email'";

    $result_cz = mysqli_query($mysqli,$query_cz);
    $result_cz_row = mysqli_fetch_row($result_cz);


    if($result_cz_row[0] == null){
        echo "<script>alert('{$b}')</script>";
        echo "<script type='text/javascript'>";
        echo "window.location.href='register.php'";
        echo "</script>";
    }

    $query_pw = "SELECT Password FROM UserInfo WHERE EmailAdd = '$email'";
    $result_pw = mysqli_query($mysqli,$query_pw);
    $result_pw_row = mysqli_fetch_row($result_pw);

    if ($password != $result_pw_row[0]){
        echo "<script>alert('{$a}')</script>";
        echo "<script type='text/javascript'>";
        echo "window.location.href='login.html'";
        echo "</script>";
    }

    $row = mysqli_fetch_row($result);

    $query2 = "SELECT UserId,UserName FROM UserInfo WHERE EmailAdd = '$email'";
    $result2 = mysqli_query($mysqli, $query2);

    $row2 = mysqli_fetch_row($result2);
    $userId = $row2[0];
    $userName = $row2[1];

    //数据库中不应该使用多个相同的用户，所以这里返回的只能是 0或者1

    $_SESSION['loggedin'] = 1;
    setcookie("userId","$userId");
    setcookie("userName","$userName");
    exit(header("Location:index.php"));

