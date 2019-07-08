<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 2018/6/14
 * Time: 16:37
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

//$_FILES["file"]["name"] - 被上传文件的名称
//$_FILES["file"]["type"] - 被上传文件的类型
//$_FILES["file"]["size"] - 被上传文件的大小，以字节计
//$_FILES["file"]["tmp_name"] - 存储在服务器的文件的临时副本的名称


//$imgname = $_FILES['picture']['name'];

//
//if ((($_FILES["file"]["type"] == "image/gif")
//    || ($_FILES["file"]["type"] == "image/jpeg")
//    || ($_FILES["file"]["type"] == "image/pjpeg"))
////    && ($_FILES["file"]["size"] < 60000)
//) {
    if ($_FILES["file"]["error"] > 0) {
        echo "Error: " . $_FILES["file"]["error"] . "<br />";
    } else {
//        echo "Upload: " . $_FILES["file"]["name"] . "<br />";
//        echo "Type: " . $_FILES["file"]["type"] . "<br />";
//        echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
//        echo "Stored in: " . $_FILES["file"]["tmp_name"];


        /**
         * @param string $oldfile 需要更换的文件名（包含具体路径名）
         */
//        $oldfile = "img/" . $_FILES["file"]["name"];
        $newfile = $_FILES['file']['name'];//获取上传文件名
        $fileclass = substr(strrchr($newfile, '.'), 1);//获取上传文件扩展名,做判断用
        $type = array("jpg", "gif", "bmp", "jpeg", "png");//设置允许上传文件的类型

        if (in_array(strtolower($fileclass), $type)) {
//            $view = 0;
//            echo file_exists($oldfile);
//            if (file_exists($oldfile)) {
//                unlink($oldfile);
//                $sql_view = "SELECT `view` FROM artworks WHERE imageFileName = {$oldfile}";
//                $result = mysqli_query($conn,$sql_view);
//                $row=$result->fetch_assoc();
//                $view= $row['view'];
//                $sql_upload = "DELETE FROM artworks WHERE imageFileName = {$oldfile}";
//                $retval = mysqli_query($conn, $sql_upload);
//                if (!$retval) {
//                    die('无法插入数据: ' . mysqli_error($conn));
//                }
//                echo "请换一个名字的图片";
//                exit;
//            }
            $sql_ID = "SELECT * FROM artworks  ORDER BY  artworkID DESC  LIMIT 1";
            $newID = mysqli_query($conn, $sql_ID);
            $newID = $newID->fetch_assoc();
            $newfileID = $newID['artworkID']+1;

            $oldfile = "img/" . $newfileID.".".$fileclass;
            if (is_uploaded_file($_FILES['file']['tmp_name'])) {//必须通过 PHP 的 HTTP POST 上传机制所上传的
                if (move_uploaded_file($_FILES['file']['tmp_name'], $oldfile)) {
//输出图片预览
//                    echo "您的文件已经上传完毕 上传图片预览: ";


//                    move_uploaded_file($_FILES["file"]["tmp_name"],
//                        "img/" . $_FILES["file"]["name"]);
//            echo "Stored in: " . "img/" . $_FILES["file"]["name"];
//            $view=0;


                    $time = date('Y-m-d H:i:s', time());
                    $sql_upload = "insert into artworks(artworkID,artist,imageFileName,title,description,yearOfWork,genre,width,height,price,`view`,ownerID,timeReleased) values ('$newfileID','{$_POST['artist']}','{$newfileID}.{$fileclass}','{$_POST['title']}','{$_POST['description']}','{$_POST['year']}','{$_POST['genre']}','{$_POST['width']}','{$_POST['height']}','{$_POST['price']}',0,'{$_SESSION['id']}' ,'{$time}')";
                    $retval = mysqli_query($conn, $sql_upload);
                    if (!$retval) {
                        die('无法插入数据: ' . mysqli_error($conn));
                    } else {
                        echo "上传成功";
                        exit;
                    }
                }



            } else {
                echo "上传失败，请重新上传";
            }
        } else {
            $text = implode(",", $type);
            echo "您只能上传以下类型文件：", $text;
// echo "<script>alert('您只能上传以下类型文件：$text')</script>";
        }


//        if (file_exists("img/" . $_FILES["file"]["name"])) {
//            $file = "img/" . $_FILES["file"]["name"];
//            unlink($file);
//            $sql_upload = "DELETE FROM artworks WHERE imageFileName = {$_REQUEST['imageFileName']}";
//            $retval = mysqli_query($conn, $sql_upload);
//            if (!$retval) {
//                die('无法插入数据: ' . mysqli_error($conn));
//            }
//        }
//        else
//        {
//        move_uploaded_file($_FILES["file"]["tmp_name"],
//            "img/" . $_FILES["file"]["name"]);
//            echo "Stored in: " . "img/" . $_FILES["file"]["name"];
//            $view=0;
//        $time = date('Y-m-d H:i:s', time());
//        $sql_upload = "insert into artworks(artist,imageFileName,title,description,yearOfWork,genre,width,height,price,`view`,ownerID,orderID,timeReleased) values ('{$_POST['artist']}','{$imgname}','{$_POST['title']}','{$_POST['description']}','{$_POST['genre']}','{$_POST['width']}','{$_POST['height']}','{$_POST['price']}',0,'{$_SESSION['id']}',NULL ,$time)";
//        $retval = mysqli_query($conn, $insert_sql);
//        if (!$retval) {
//            die('无法插入数据: ' . mysqli_error($conn));
//        } else {
//            echo "上传成功！";
//        }

//        }
    }
//}
//else {
//    echo "Invalid file";
//}


//
//if(move_uploaded_file($tmp,$filepath.$imgname.".png")){
//    echo "上传成功";
//}else{
//    echo "上传失败";
//}
//


?>