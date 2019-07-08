<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 2018/6/14
 * Time: 11:27
 */
session_start();
//
header("Content-type:text/html;charset=utf-8");
$dbhost = 'localhost';  // mysql服务器主机地址
$dbuser = 'root';// mysql用户名
$dbpass = '';          // mysql用户名密码
$dbname = 'artstore';
$conn = mysqli_connect($dbhost, $dbuser, $dbpass);
if (!$conn) {
    die('连接错误: ' . mysqli_error($conn));
}
mysqli_set_charset($conn,'utf8'); //设定字符集
mysqli_select_db($conn, $dbname);

if($_REQUEST['artworkID']==='all'){
    $sql_cart = "SELECT * FROM carts WHERE userID = {$_SESSION['id']}";
    $result = mysqli_query($conn, $sql_cart);
    $totalMoney = 0;
    while ($row=$result->fetch_assoc()){
        GLOBAL $totalMoney;
        $sql_work = "SELECT price,artworkID FROM artworks WHERE artworkID = {$row['artworkID']}";
        $result2 = $conn->query($sql_work) or die($conn->error);
        $row2 = $result2->fetch_assoc();
        $totalMoney += $row2['price'];
    }


    if($totalMoney != intval($_REQUEST['total'])){
        echo "在这期间商品价格发生了变化，请先刷新确认";
    }else{
        echo "下单啦";
    }

}else{
    $sql_cart = "SELECT * FROM carts WHERE artworkID = {$_REQUEST['artworkID']} AND userID = {$_SESSION['id']}";
    $result = mysqli_query($conn, $sql_cart);
    $totalMoney = 0;
    while ($row=$result->fetch_assoc()){
        GLOBAL $totalMoney;
        $sql_work = "SELECT price,artworkID FROM artworks WHERE artworkID = {$_REQUEST['artworkID']}";
        $result2 = $conn->query($sql_work) or die($conn->error);
        $row2 = $result2->fetch_assoc();
        $totalMoney += $row2['price'];
    }

    if($totalMoney != intval($_REQUEST['thisPrice'])){
        echo "在这期间商品价格发生了变化，请先刷新确认";
    }else{
        echo "下单啦";
    }
}

?>