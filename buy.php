<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 2018/6/15
 * Time: 21:47
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
mysqli_set_charset($conn, 'utf8'); //设定字符集
mysqli_select_db($conn, $dbname);


if ($_REQUEST['artworkID'] === 'all') {
    $sql_cart = "SELECT * FROM carts WHERE userID = {$_SESSION['id']}";
    $result = mysqli_query($conn, $sql_cart);
    $totalMoney = 0;
    while ($row = $result->fetch_assoc()) {
        GLOBAL $totalMoney;
        $sql_work = "SELECT price,artworkID,orderID FROM artworks WHERE artworkID = {$row['artworkID']}";
        $result2 = $conn->query($sql_work) or die($conn->error);
        $row2 = $result2->fetch_assoc();
        if ($row2['orderID'] !== null) {
            echo "有人抢先购买了商品，请刷新页面！";
            exit;
        } else {
            $totalMoney += $row2['price'];
        }
    }
    $sql_buyer = "SELECT * FROM users WHERE userID = {$_SESSION['id']}";
    $result3 = mysqli_query($conn, $sql_buyer);
    $row3 = $result3->fetch_assoc();
    if ($row3['balance'] < $totalMoney) {
        echo "余额不足";
        exit;
    }else{
        $row3['balance'] = $row3['balance'] - $totalMoney;
        $pay_sql = "UPDATE users SET balance ={$row3['balance']} WHERE userID = {$_SESSION['id']}";
        $retval = mysqli_query($conn, $pay_sql);
        if (!$retval) {
            die('无法插入数据: ' . mysqli_error($conn));
        }
//        扣费
    }

//    开始改数据
    $time=date('Y-m-d H:i:s', time());
    $sql_order ="insert into orders(ownerID,`sum`,timeCreated) values ('{$_SESSION['id']}','$totalMoney','{$time}')";
    $retval = mysqli_query( $conn, $sql_order);
    if(! $retval )
    {
        die('无法插入数据: ' . mysqli_error($conn));
    }

    $sql_orderID = "SELECT * FROM orders  ORDER BY  orderID DESC  LIMIT 1";
    $newOrderID = mysqli_query($conn, $sql_orderID);
    $newOrderID = $newOrderID->fetch_assoc();
//order

//art
    $sql_cart = "SELECT * FROM carts WHERE userID = {$_SESSION['id']}";
    $result = mysqli_query($conn, $sql_cart);
    while ($row = $result->fetch_assoc()) {

        $sql_work = "SELECT * FROM artworks WHERE artworkID = {$row['artworkID']}";
        $result2 = $conn->query($sql_work) or die($conn->error);
        $row2 = $result2->fetch_assoc();
        $row2['orderID'] = $newOrderID['orderID'];
//        标记购买

        $sql_seller = "SELECT * FROM users WHERE userID = {$row2['ownerID']}";
        $result_seller = $conn->query($sql_seller) or die($conn->error);
        $row_seller = $result_seller->fetch_assoc();
        $row_seller['balance'] += $row2['price'];
//        没有中间商



        $insert_sql = "UPDATE users SET balance ={$row_seller['balance']} WHERE userID = {$row2['ownerID']}";
        $retval = mysqli_query($conn, $insert_sql);
        if (!$retval) {
            die('无法插入数据: ' . mysqli_error($conn));
        }

        $insert_sql = "UPDATE artworks SET orderID ={$row2['orderID'] } WHERE artworkID = {$row['artworkID']}";
        $retval = mysqli_query($conn, $insert_sql);
        if (!$retval) {
            die('无法插入数据: ' . mysqli_error($conn));
        }


    }

    $sql_deleteCart = "DELETE FROM carts WHERE userID = {$_SESSION['id']}";
    $result4 = $conn->query($sql_deleteCart) or die($conn->error);
    if (!$result4) {
        die('无法删除数据: ' . mysqli_error($conn));
    } else {
        if (isset($_SESSION['cart'])) {
            unset($_SESSION['cart']);
        }
    }

} else {
    $sql_cart = "SELECT * FROM carts WHERE userID = {$_SESSION['id']} AND artworkID = {$_REQUEST['artworkID']}";
    $result = mysqli_query($conn, $sql_cart);
    $totalMoney = 0;
    while ($row = $result->fetch_assoc()) {
        GLOBAL $totalMoney;
        $sql_work = "SELECT price,artworkID,orderID FROM artworks WHERE artworkID = {$_REQUEST['artworkID']}";
        $result2 = $conn->query($sql_work) or die($conn->error);
        $row2 = $result2->fetch_assoc();
        if ($row2['orderID'] !== null) {
            echo "有人抢先购买了商品，请刷新页面！";
            exit;
        } else {
            $totalMoney += $row2['price'];
        }
    }
    $sql_buyer = "SELECT * FROM users WHERE userID = {$_SESSION['id']}";
    $result3 = mysqli_query($conn, $sql_buyer);
    $row3 = $result3->fetch_assoc();
    if ($row3['balance'] < $totalMoney) {
        echo "余额不足";
        exit;
    }else{
        $row3['balance'] = $row3['balance'] - $totalMoney;
        $pay_sql = "UPDATE users SET balance ={$row3['balance']} WHERE userID = {$_SESSION['id']}";
        $retval = mysqli_query($conn, $pay_sql);
        if (!$retval) {
            die('无法插入数据: ' . mysqli_error($conn));
        }

    }

//    开始改数据
    $time=date('Y-m-d H:i:s', time());
    $sql_order ="insert into orders(ownerID,`sum`,timeCreated) values ('{$_SESSION['id']}','$totalMoney','{$time}')";
    $retval = mysqli_query( $conn, $sql_order);
    if(! $retval )
    {
        die('无法插入数据: ' . mysqli_error($conn));
    }

    $sql_orderID = "SELECT * FROM orders  ORDER BY  orderID DESC  LIMIT 1";
    $newOrderID = mysqli_query($conn, $sql_orderID);
    $newOrderID = $newOrderID->fetch_assoc();
//order



    $sql_cart = "SELECT * FROM carts WHERE userID = {$_SESSION['id']} AND artworkID = {$_REQUEST['artworkID']}";
    $result = mysqli_query($conn, $sql_cart);
    while ($row = $result->fetch_assoc()) {
        $sql_work = "SELECT * FROM artworks WHERE artworkID = {$_REQUEST['artworkID']}";
        $result2 = $conn->query($sql_work) or die($conn->error);
        $row2 = $result2->fetch_assoc();
        $row2['orderID'] = $newOrderID['orderID'];


        $sql_seller = "SELECT * FROM users WHERE userID = {$row2['ownerID']}";
        $result_seller = $conn->query($sql_seller) or die($conn->error);
        $row_seller = $result_seller->fetch_assoc();
        $row_seller['balance'] =$row_seller['balance']+ $row2['price'];
//        没有中间商

        $insert_sql = "UPDATE users SET balance ={$row_seller['balance']} WHERE userID = {$row2['ownerID']}";
        $retval = mysqli_query($conn, $insert_sql);
        if (!$retval) {
            die('无法插入数据: ' . mysqli_error($conn));
        }

        $insert_sql = "UPDATE artworks SET orderID ={$row2['orderID'] } WHERE artworkID = {$row['artworkID']}";
        $retval = mysqli_query($conn, $insert_sql);
        if (!$retval) {
            die('无法插入数据: ' . mysqli_error($conn));
        }

    }

    $sql_deleteCart = "DELETE FROM carts WHERE userID = {$_SESSION['id']} AND artworkID = {$_REQUEST['artworkID']}";
    $result4 = $conn->query($sql_deleteCart) or die($conn->error);
    if (!$result4) {
        die('无法删除数据: ' . mysqli_error($conn));
    } else {
        if (isset($_SESSION['cart'][$_REQUEST['artworkID']])) {
            unset($_SESSION['cart'][$_REQUEST['artworkID']]);
        }
    }
}


?>