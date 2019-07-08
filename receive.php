<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 2018/6/20
 * Time: 18:15
 */

session_start();
$dbhost = 'localhost';  // mysql服务器主机地址
$dbuser = 'root';// mysql用户名
$dbpass = '';          // mysql用户名密码
$dbname = 'artstore';
$conn = mysqli_connect($dbhost, $dbuser, $dbpass);
if (!$conn) {
    die('连接错误: ' . mysqli_error($conn));
}

mysqli_select_db($conn, $dbname);
mysqli_query($conn, "set names utf8");

$sql_check = "select * from letters where letterID = {$_REQUEST['letterID']}";
$result = $conn->query($sql_check) or die($conn->error);
$row = $result ->fetch_assoc();
if($row) {
    if(!isset($_REQUEST['isW'])){
    $sql_status = "UPDATE letters SET status = 1 WHERE letterID = {$_REQUEST['letterID']}";
    $r = mysqli_query($conn,$sql_status);
    if (!$r) {
        die('无法插入数据: ' . mysqli_error($conn));
    }
    }
    $sql_send = "select * from users where userID = {$row['senderID']}";
    $s = mysqli_query($conn,$sql_send);
    if(!$s){
        die('无法搜索数据: ' . mysqli_error($conn));
    }
    $s_row = $s->fetch_assoc();

    $arrs=array("{$s_row['name']}","{$_SESSION['username']}","{$row['contents']}","{$row['timeReleased']}");
    echo implode('$%^^&&', $arrs);
}else{
    echo "查无此人";
    exit;
}




?>