<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 2018/6/18
 * Time: 3:18
 */

header("Content-Type:text/html;charset=utf-8");
$id=$_REQUEST['artworkID'];
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
$sql_select = "SELECT * FROM artworks WHERE artworkID = $id";
$result = $conn->query($sql_select) or die($conn->error);
$row = $result->fetch_assoc();
$arrs=array("{$row['title']}","{$row['artist']}","{$row['genre']}","{$row['description']}","{$row['width']}","{$row['height']}","{$row['price']}","{$row['yearOfWork']}","{$row['imageFileName']}");
echo implode('$%^^&&', $arrs);

?>
