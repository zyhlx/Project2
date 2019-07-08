<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 2018/6/5
 * Time: 14:59
 */
//include 'functions.index.php';
//session_start();
$dbhost = 'localhost';  // mysql服务器主机地址
$dbuser = 'root';// mysql用户名
$dbpass = '';          // mysql用户名密码
$dbname = 'artstore';
$conn = mysqli_connect($dbhost, $dbuser, $dbpass);
if (!$conn) {
    die('连接错误: ' . mysqli_error($conn));
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta http-equiv="X-UA-Compatitable" content="IE=edge,Chrome=1">

    <title>Art Store</title>
    <link rel="stylesheet" type="text/css" href="css/simply-toast.min.css" />
<!--    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css"-->
<!--          integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">-->
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/4.1.0/css/bootstrap.min.css">

    <link href="css/index.css" rel="stylesheet">

    <link href="css/modal.css" rel="stylesheet"><!--bootstrap自带问题-->


    <script src="http://libs.baidu.com/jquery/1.7.1/jquery.js"></script>
    <script src="https://cdn.bootcss.com/jquery/3.3.1/jquery.min.js"></script>
<!--    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"-->
<!--            integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T"-->
<!--            crossorigin="anonymous"></script>-->
    <script src="https://cdn.bootcss.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
    <!--<script src="https://cdn.jsdelivr.net/npm/vue@2.5.16/dist/vue.js"></script>-->
    <!--<script rel="script" src="js/vue.js"></script>-->
    <!--<script rel="script" src="js/vue.min.js"></script>-->
</head>
<body>
<div class="container-fluid">

    <?php include 'index-header.php';
    if(!isset($_SESSION['history'])){
        $_SESSION['history'] = array();
        $_SESSION['history']['index'] = "index.php";
    }else if (!isset($_SESSION['history']['index'])){
        $_SESSION['history']['index'] = "index.php";
    }else{
        $new = array();
        foreach ($_SESSION['history'] as $key => $value) {
            if($key != "index"){
                $new[$key] = $value;
            }else{
                break;
            }
        }
        $new['index'] =$_SERVER['REQUEST_URI'];
        $_SESSION['history'] = $new;
    }


    ?>

    <main class="d-flex flex-column">
        <div class="border card">
            <div class="card-body">
                <div id="demo" class="carousel slide mb-3 mr-3 ml-3" data-ride="carousel">

                    <!-- 指示符 -->
                    <ul class="carousel-indicators">
                        <li data-target="#demo" data-slide-to="0" class="active"></li>
                        <li data-target="#demo" data-slide-to="1"></li>
                        <li data-target="#demo" data-slide-to="2"></li>
                    </ul>

                    <!-- 轮播图片 -->

                    <div class="carousel-inner">
                        <?php
                        mysqli_select_db($conn, $dbname);
                        mysqli_query($conn, "set names utf8");
                        $sql_active = "SELECT artworkID,artist,imageFileName,title,`view`,description,orderID FROM artworks  WHERE artworks.orderID <=> NULL ORDER BY `view` desc LIMIT 0 , 1";
                        $result1 = $conn->query($sql_active) or die($conn->error);
                        while ($row = $result1->fetch_assoc()) {
                        echo " <div class=\"carousel-item active media border p-1\">
                                    <img src=\"img/".$row['imageFileName']."\" class=\"img-responsive center-block mr-3 mt-1\" height='600px'>
                                    <div class=\"carousel-caption-reset\">
                                        <a href=\"details.php?artworkID={$row['artworkID']}\"><h3>".$row['title']."</h3></a>
                                        <p>".$row['description']."</p>
                                    </div>
                                </div>";

                        $sql_notactive = "SELECT artworkID,artist,imageFileName,title,`view`,description,orderID FROM artworks  WHERE artworks.orderID <=> NULL ORDER BY `view` desc LIMIT 1 , 2";
                        $result2 = $conn->query($sql_notactive) or die($conn->error);
                        while ($row = $result2->fetch_assoc()) {
                            echo " <div class=\"carousel-item media border p-1\">
                                    <img src=\"img/".$row['imageFileName']."\" class=\"img-responsive center-block mr-3 mt-1\" height='600px'>
                                    <div class=\"carousel-caption-reset\">
                                        <a href=\"details.php?artworkID={$row['artworkID']}\"><h3>".$row['title']."</h3></a>
                                        <p>".$row['description']."</p>
                                    </div>
                                </div>";}

                        }
                        ?>

                    </div>

                    <!-- 左右切换按钮 -->
                    <a class="carousel-control-prev" href="#demo" data-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </a>
                    <a class="carousel-control-next" href="#demo" data-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </a>
                </div>
            </div>
        </div>

        <div class="card recommend-border">
            <div class="card-body row">
                <?php

                mysqli_select_db($conn, $dbname);
                mysqli_query($conn, "set names utf8");
                $sql_newarts = "SELECT artworkID,artist,imageFileName,title,timeReleased,description,orderID FROM artworks  WHERE artworks.orderID <=> NULL ORDER BY timeReleased desc LIMIT 0 , 3";
                $result = $conn->query($sql_newarts) or die($conn->error);

                while ($row = $result->fetch_assoc()) {
                   echo " <div class=\"p-3 col-sm-4 d-flex flex-column\">
                    <div class=\"d-flex justify-content-center\">
                        <img src=\"img/".$row['imageFileName']."\" class=\"rounded-circle border-3\" height='250px'>
                    </div>
                    <div class=\"text-center mt-3\">
                        <h4 class=\"card-title\">".$row['title']."</h4>
                        <p class=\"card-text\">".$row['description']."</p>
                        <a href='details.php?artworkID=".$row['artworkID']."' class=\"btn btn-primary\">See Profile</a>
                    </div>
                </div>";
                }

                ?>

            </div>
        </div>

    </main>

    <footer class="footer navbar-fixed-bottom">produced and maintained by zyh at 2018.3</footer>
</div>
<script src="js/simply-toast.min.js"></script>
<script type="text/javascript" rel="script" src="js/registe.js"></script>
<script type="text/javascript" rel="script" src="js/login.js"></script>
</body>
</html>