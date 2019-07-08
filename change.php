<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 2018/6/18
 * Time: 12:40
 */


header("Content-Type:text/plain;charset=utf-8");
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


$sql_view = "SELECT * FROM artworks WHERE artworkID = {$_REQUEST['artworkID']} AND ownerID = {$_SESSION['id']}";
$view = 0;
//            $sql_view = "SELECT `view`,imageFileName FROM artworks WHERE artworkID = {$_REQUEST['artworkID']}AND ownerID = {$_SESSION['id']}";
$result = mysqli_query($conn, $sql_view);
//            print_r($result);
$row = $result->fetch_assoc();
//            if( = $row['artworkID']){
//                echo "y";
//            }else{
//                echo "n";
//            };
$view = $row['view'];
$path = "img/" . $row['imageFileName'];
if($row['orderID'] != null){
    echo "有人购买不可修改";
    exit;
}else{



if ($_FILES["file"]["error"] > 0) {
//        echo "Error: " . $_FILES["file"]["error"] . "<br />";
    if ($_FILES["file"]["error"] = 4) {
        echo "请重新选择图片";
        exit;
    }
    echo "未知错误";
} else {


    /**
     * @param string $oldfile 需要更换的文件名（包含具体路径名）
     */

//    $oldfile = "img/" . $_FILES["file"]["name"];
//    if (file_exists($oldfile)) {
//        echo "请换一个名字的图片";
//        exit;
//    }

    $newfile = $_FILES['file']['name'];//获取上传文件名
    $fileclass = substr(strrchr($newfile, '.'), 1);//获取上传文件扩展名,做判断用
    $type = array("jpg", "gif", "bmp", "jpeg", "png");//设置允许上传文件的类型
    if (in_array(strtolower($fileclass), $type)) {


//            $result = mysqli_query($conn,$sql_view);


//        echo $path;

        unlink($path);
//        $sql_work = "DELETE FROM artworks WHERE artworkID = {$_REQUEST['artworkID']} AND ownerID = {$_SESSION['id']}";
//        $retval = mysqli_query($conn, $sql_work);
//        if (!$retval) {
//
//            die('无法插入数据: ' . mysqli_error($conn));
//        }

//        if (is_uploaded_file($_FILES['file']['tmp_name'])) {//必须通过 PHP 的 HTTP POST 上传机制所上传的
//            if (move_uploaded_file($_FILES['file']['tmp_name'], $oldfile)) {
////输出图片预览
////                    echo "您的文件已经上传完毕 上传图片预览: ";
//
//                $time = date('Y-m-d H:i:s', time());
//                $sql_upload = "insert into artworks(artist,imageFileName,title,description,yearOfWork,genre,width,height,price,`view`,ownerID,timeReleased) values ('{$_POST['artist']}','{$newfile}','{$_POST['title']}','{$_POST['description']}','{$_POST['year']}','{$_POST['genre']}','{$_POST['width']}','{$_POST['height']}','{$_POST['price']}','{$view}','{$_SESSION['id']}','{$time}')";
//                $retval = mysqli_query($conn, $sql_upload);
//                if (!$retval) {
//                    die('无法插入数据: ' . mysqli_error($conn));
//                } else {
//                    echo "上传成功";
//                }
//            }
//        } else {
//            echo "上传失败，请重新上传";
//        }


        $oldfile = "img/" .$row['artworkID'].".".$fileclass;
        if (is_uploaded_file($_FILES['file']['tmp_name'])) {//必须通过 PHP 的 HTTP POST 上传机制所上传的
            if (move_uploaded_file($_FILES['file']['tmp_name'], $oldfile)) {
                $width = intval($_REQUEST['width']); $height = intval($_REQUEST['height']);$price = intval($_REQUEST['price']);$year = intval($_REQUEST['year']);
                $insert_sql = "UPDATE artworks SET `view` ={$row['view']},artist ='{$_REQUEST['artist']}',genre ='{$_REQUEST['genre']}',title ='{$_REQUEST['title']}',width = {$width}, height ={$height},price ={$price},description ='{$_REQUEST['description']}',yearOfWork ={$year} WHERE artworkID = {$_REQUEST['artworkID']}";
                $retval = mysqli_query($conn, $insert_sql);
                if (!$retval) {
                    die('无法插入数据: ' . mysqli_error($conn));
                } else {
                    echo "修改成功";
                }
            }
        }


    } else {
        $text = implode(",", $type);
        echo "您只能上传以下类型文件：", $text;

    }
}
}


?>