<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 2018/6/17
 * Time: 14:27
 */
session_start();
header("Content-Type:text/plain;charset=utf-8");
$dbhost = 'localhost';  // mysql服务器主机地址
$dbuser = 'root';// mysql用户名
$dbpass = '';          // mysql用户名密码
$dbname = 'artstore';
$conn = mysqli_connect($dbhost, $dbuser, $dbpass);
if (!$conn) {
    die('连接错误: ' . mysqli_error($conn));
}

$money = intval($_POST['moneyCharge']);
mysqli_select_db($conn, $dbname);
$id = $_SESSION['id'];

$sql_select = "select users.name,balance,userID from users where userID = '$id'";
$result = $conn->query($sql_select) or die($conn->error);
$row = $result->fetch_assoc();
$row['balance'] = $row['balance'] + $money;

$insert_sql = "UPDATE users SET balance ={$row['balance']} WHERE userID = {$id}";
mysqli_select_db($conn, $dbname);
$retval = mysqli_query($conn, $insert_sql);
if (!$retval) {
    die('无法插入数据: ' . mysqli_error($conn));
} else {
    echo "充值成功";
}
?>