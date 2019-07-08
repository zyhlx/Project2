<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 2018/6/13
 * Time: 16:44
 */

session_start();
//
header("Content-type:text/html;charset=utf-8");
//$dbhost = 'localhost';  // mysql服务器主机地址
//$dbuser = 'root';// mysql用户名
//$dbpass = '';          // mysql用户名密码
//$dbname = 'artstore';
//$conn = mysqli_connect($dbhost, $dbuser, $dbpass);
//if (!$conn) {
//    die('连接错误: ' . mysqli_error($conn));
//}

if(isset($_GET['action'])){
    if($_GET['action'] == "logout"){
        session_unset();
        session_destroy();
        echo "注销登录成功！点击此处 <a href=\"{$_SERVER['HTTP_REFERER']}\">返回上一页</a>";
        exit;
    }else{
        echo "注销登录失败！点击此处 <a href=\"{$_SERVER['HTTP_REFERER']}\">返回上一页</a>";
        exit;
    }

}else{
    echo "注销登录失败！点击此处 <a href=\"{$_SERVER['HTTP_REFERER']}\">返回上一页</a>";
    exit;
}





?>