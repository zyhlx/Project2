<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 2018/6/20
 * Time: 16:51
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


$name = $_REQUEST['receiver'];
$content = $_REQUEST['content'];

$sql_check = "select userID from users where `name`= '$name'";
$result = $conn->query($sql_check) or die($conn->error);
$row = $result->fetch_assoc();
if($row) {
    $time = date('Y-m-d H:i:s', time());
    $sql_upload = "insert into letters(receiverID,senderID,contents,status,timeReleased) values ('{$row['userID']}','{$_SESSION['id']}','{$content}',0,'{$time}')";
    $retval = mysqli_query($conn, $sql_upload);
    if (!$retval) {
        die('无法插入数据: ' . mysqli_error($conn));
    } else {
        echo "发送成功";
        exit;
    }
}else{
    echo "查无此人";
    exit;
}











?>