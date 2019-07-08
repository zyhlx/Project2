<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 2018/6/6
 * Time: 22:50
 */
//session_start();换了一个入口
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

$name=$_POST['username'];

$pwd=$_POST['password'];

mysqli_select_db($conn, $dbname);
$sql_select="select users.name,password,userID from users where `name`= '$name'"; //从数据库查询信息 ?是个通配符,可以用在任何有文字的数据
//$stmt=mysqli_prepare($link,$sql_select);//准备语句创建
//mysqli_stmt_bind_param($stmt,'s',$name);//为准备语句绑定实际变量 好像这种写法要过时了
//mysqli_stmt_execute($stmt);//执行
//$result=mysqli_stmt_get_result($stmt);
$result = $conn->query($sql_select) or die($conn->error);
$row = $result->fetch_assoc();

if($row){

    if(!password_verify($pwd,$row['password'])|| $name !=$row['name']){
        echo "错误请重新输入";
        echo "<script>setTimeout(\"window . location . href = '{$_SERVER['HTTP_REFERER']}'\",3000); </script>";
        exit;
    }
    else{
        $_SESSION['username']=$row['name'];
        $_SESSION['id']=$row['userID'];

        if(isset($_SERVER['HTTP_REFERER'])){
            echo "登陆成功!（这边没有用Ajax在下单和注册那边用的Ajax是自动消失的提示框）";
            echo "<script>setTimeout(\"window.location.href='{$_SERVER['HTTP_REFERER']}'\",3000); </script>";
        }else {
            echo "登录成功！";
            echo "<script>setTimeout(\"window.location.href='index.php'\",3000);</script>";
           }
    }

}else{
    if(isset($_SERVER['HTTP_REFERER'])){
        echo "您输入的用户名不存在";
        echo "<body><script>setTimeout(\"window.location.href='{$_SERVER['HTTP_REFERER']}'\",3000);</script></body>";
        exit;
    }else {
        echo "您输入的用户不存在";
        echo "<script>setTimeout(\"window.location.href='index.php'\",3000);</script>";
    exit;}
};


?>