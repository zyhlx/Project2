<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 2018/6/6
 * Time: 23:16
 */
session_start();
//换了一个入口
header("Content-Type:text/plain;charset=utf-8");
//header("Content-type:text/html;charset=utf-8");
$dbhost = 'localhost';  // mysql服务器主机地址
$dbuser = 'root';// mysql用户名
$dbpass = '';          // mysql用户名密码
$dbname = 'artstore';
$conn = mysqli_connect($dbhost, $dbuser, $dbpass);
if (!$conn) {
    die('连接错误: ' . mysqli_error($conn));
}
//$link = mysqli_connect('localhost','root','','artstore');
mysqli_set_charset($conn,'utf8'); //设定字符集
$name=$_POST['username-register'];
$pwd=$_POST['password-register'];
$pwdconfirm=$_POST['pwdconfirm-register'];
$email = $_POST['email'];
$tel = $_POST['tel'];
$add = $_POST['address'];
//    if($name==''){
//        echo"<script>alert('你的用户名不能为空，请重新输入');</script>";
//        exit;
//
//    }
//    if($pwd==''){
//
//        echo"<script>alert('你的密码不能为空，请重新输入');location='".$_SERVER['HTTP_REFERER']. "'</script>";
//        exit;
//
//    }
//    if($pwd != $pwdconfirm){
//
//        echo"<script>alert('你输入的两次密码不一致，请重新输入');location='".$_SERVER['HTTP_REFERER']. "'</script>";
//        exit;
//
//    }
//修改
mysqli_select_db($conn, $dbname);
$sql_check ="SELECT * FROM users WHERE `name` = '$name'";
$result=mysqli_query($conn,$sql_check);

if(mysqli_num_rows($result) ===0){
    $passwordHash = password_hash(
        $pwd,
        PASSWORD_DEFAULT,
        ['cost' => 12]
    );
//    密码、哈希算法、选项

//PASSWORD_DEFAULT使用bcrypt加密算法生成加密字符串，目前测试生成的加密字符串长度固定在60个字节，
//    但是由于PASSWORD_DEFAULT这个常量值代表的加密算法可能会随着后期php加密算法的不断升级而发生变化，
//所以在文档上有指出建议用>60个字节的字符长度的字段进行存储（建议255个字节）







    $insert_sql="insert into users(users.name,password,email,tel,address,balance) values ('$name','$passwordHash','$email','$tel','$add',0)";
    mysqli_select_db($conn, $dbname);
    $retval = mysqli_query( $conn, $insert_sql);
    if(! $retval )
    {
        die('无法插入数据: ' . mysqli_error($conn));
    }else{
        mysqli_select_db($conn, $dbname);
        $sql_select="select users.name,password,userID from users where `name`= '$name'";
        $result1 = $conn->query($sql_select) or die($conn->error);
        $row = $result1->fetch_assoc();
        if(isset($_SERVER['HTTP_REFERER'])){
            echo "您已注册成功，自动登录";
            $_SESSION['username']=$row['name'];
            $_SESSION['id']=$row['userID'];
            exit;
        }else {
            echo "您已注册成功，由于没有上一页返回首页";
            $_SESSION['username']=$row['name'];
            $_SESSION['id']=$row['userID'];
            exit;
        }
    }

}else{
    if(isset($_SERVER['HTTP_REFERER'])){
//        原来不是ajax所以写了这个
        echo "您输入的用户名已存在,请重新注册！";
        exit;
    }else {
        echo "您输入的用户名已存在,请重新注册！";
        exit;
    }
}


//
//    $stmt=mysqli_prepare($link,$insert_sql);
//
//    mysqli_stmt_bind_param($stmt,'ss',$name,$pwd);
//
//    $result_insert=mysqli_stmt_execute($stmt);


?>