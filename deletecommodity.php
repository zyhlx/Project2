<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 2018/6/14
 * Time: 19:13
 */
header("Content-type:text/html;charset=utf-8");
$dbhost = 'localhost';  // mysql服务器主机地址
$dbuser = 'root';// mysql用户名
$dbpass = '';          // mysql用户名密码
$dbname = 'artstore';
$conn = mysqli_connect($dbhost, $dbuser, $dbpass);

session_start();

if (!$conn) {
    die('连接错误: ' . mysqli_error($conn));
}

mysqli_select_db($conn, $dbname);
mysqli_query($conn, "set names utf8");
$sql_work = "DELETE FROM carts WHERE artworkID = {$_REQUEST['artworkID']} AND userID = {$_SESSION['id']}";
$result = $conn->query($sql_work) or die($conn->error);
if (!$result) {
    die('无法删除数据: ' . mysqli_error($conn));
} else {
    if(isset($_SESSION['cart'][$_REQUEST['artworkID']])){
        unset($_SESSION['cart'][$_REQUEST['artworkID']]);
    }
    exit;
}

?>