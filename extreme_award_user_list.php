<?php

/**
 * 获取提交的数据
 *
 */

$act       = $_POST['act'];
$id        = $_POST['id'];
$user_id   = (int)$_POST['user_id'];
$form_data = $_POST['form_data'];
$param_arr = array();


// 获取到的数据格式为 “foo=bar&baz=boom&cow=milk&php=hypertext+processor”
// http_build_query 的数据形式用parse_str解析为数组格式
parse_str($form_data, $param_arr);

// 备注中文处理
$param_arr['remark']  = iconv("utf-8", "gbk", trim($param_arr['remark']));


switch($act)
{
    case "add":

        // 添加入库操作
        // ...
        // ...
        break;

    case "edit":

        // 编辑操作
        $user_id = $param_arr['user_id'];

        // ...
        break;

    case "get":

        // 返回详细的用户信息
        // get($user_id);
        echo $ret;
        exit();
        break;
    case "del":
        // 删除
        // delete();
        break;
}

echo $ret > 0 ? 1 : 0;
