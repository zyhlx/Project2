<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 2018/6/14
 * Time: 11:23
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

if (isset($_REQUEST['artworkID'])) {
    mysqli_query($conn, "set names utf8");
    mysqli_select_db($conn, $dbname);

    $sql_artist = "SELECT * FROM artworks WHERE artworkID = {$_REQUEST['artworkID']}";
    $result = $conn->query($sql_artist) or die($conn->error);
    $row = $result->fetch_assoc();
    if($row['orderID'] ==null){



    if (isset($_SESSION['id'])) {
        $new = $_REQUEST['artworkID'];
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = array();
            $_SESSION['total_price'] = '0.00';
        }

        //添加购物车

        $sql_artist = "SELECT price FROM artworks WHERE artworkID = $new";
        $result = $conn->query($sql_artist) or die($conn->error);
        $row = $result->fetch_assoc();


        if (!isset($_SESSION['cart'][$new])) {
            $_SESSION['cart'][$new] = $row['price'];
            $_SESSION['total_price'] += $row['price'];
//        直接就插入数据了 不再最后
            $id = intval($_SESSION['id']);
            $artwork = intval($_REQUEST['artworkID']);
            $insert_sql = "insert into carts(userID,artworkID,originalPrice) values ($id,$artwork,{$row['price']})";
            mysqli_query($conn, "set names utf8");
            mysqli_select_db($conn, $dbname);
            $retval = mysqli_query($conn, $insert_sql);
            if (!$retval) {
                die('无法插入数据: ' . mysqli_error($conn));
            } else {
//                echo "<script>alert('添加成功!');location='{$_SERVER['HTTP_REFERER']}'</script>";
                exit;
            }
        }else{
//            echo "<script>alert('已经添加！');location='{$_SERVER['HTTP_REFERER']}'</script>";
            exit;
        }
    } else {
        echo "<p>未登录不能加入购物车</p><script>location='{$_SERVER['HTTP_REFERER']}'</script>";
    }
    }else{
        echo "已被购买";
    }
} else {
    echo "<script>location='{$_SERVER['HTTP_REFERER']}'</script>";
}

?>