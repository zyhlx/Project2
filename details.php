<?php
function CheckURL(){
    $servername=$_SERVER['SERVER_NAME'];
    $sub_from=$_SERVER["HTTP_REFERER"];
    $sub_len=strlen($servername);
    $checkfrom=substr($sub_from,7,$sub_len);
    if($checkfrom!=$servername)die("警告！你正在从外部提交数据！请立即终止！");
};
CheckURL();
$id = $_REQUEST['artworkID'];

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
    <meta charset="utf-8">
    <title>Details</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatitable" content="IE=edge,Chrome=1">
<!--    <link href='http://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>-->
<!--    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>-->


<!--    <script src="https://code.jquery.com/jquery-2.2.4.min.js"-->
<!--            integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>-->
<!--    <script src="js/jquery.js" type="text/javascript"></script>-->
    <script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>


    <link rel="stylesheet" href="https://cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.css">
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/4.1.0/css/bootstrap.min.css">

    <script src="https://cdn.bootcss.com/popper.js/1.12.5/umd/popper.min.js"></script>
    <script src="https://cdn.bootcss.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="css/bootstrap-theme.css"/>
    <link rel="stylesheet" href="css/details.css">
    <link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
    <link href="css/modal.css" rel="stylesheet"><!--bootstrap自带问题-->
</head>

<body>
<?php include 'header.inc.php'; ?>
<main class="container">
    <div class="row">
        <?php

        if(!isset($_SESSION['history'])){
            $_SESSION['history'] = array();
            $_SESSION['history']['detail'] = $_SERVER['REQUEST_URI'];
        }else if (!isset($_SESSION['history']['detail'])){
            $_SESSION['history']['detail'] = $_SERVER['REQUEST_URI'];
        }else{
            $new = array();
            foreach ($_SESSION['history'] as $key => $value) {
                if($key != "detail"){
                    $new[$key] = $value;
                }else{
                    break;
                }
            }
            $new['detail'] = $_SERVER['REQUEST_URI'];
            $_SESSION['history'] = $new;
        }

        foreach ($_SESSION['history'] as $key => $value) {
            echo "<a href=\"{$value}\">$key&nbsp;›&nbsp;</a>";
        }

        ?>
    </div>

    <div class="row">

        <?php include 'aside.php' ?>

        <div class="col-sm-10">
            <div class="row">
                <div class="border card col-sm-7">
                    <div class="card-body">
                        <?php
                        mysqli_select_db($conn, $dbname);
                        mysqli_query($conn, "set names utf8");
                        $sql_artist = "SELECT * FROM artworks WHERE artworkID = $id";
                        $result = $conn->query($sql_artist) or die($conn->error);
                        while ($row = $result->fetch_assoc()) {
                            echo " <h2 class=\"card-title\"><a name=\"Title\">{$row['title']}</a></h2>
                        <p class=\"card-text\">By <a href=\"#\" onclick=\"window . location . href = 'search.php?input_text={$row['artist']}&search[]=artist'\">{$row['artist']}</a></p>
                        <figure>
                                <img src=\"img/{$row['imageFileName']}\" class=\"img-responsive\" alt=\"{$row['title']}\"/>
                        </figure>
                        <div>
                            <p class=\"card-text\">{$row['description']}</p>
                        </div>";
                        }
                        ?>
<!-- <a class=\"cloud-zoom\" id=\"zoom1\" href=\"img/{$row['imageFileName']}\"
                               rel=\"adjustX: 10, adjustY:-4, softFocus:true\">
                                <img src=\"img/{$row['imageFileName']}\" class=\"img-responsive\" alt=\"{$row['title']}\"/></a>-->
<!--                        不做放大了-->
                    </div>
                </div>
                <div class="border card col-sm-5">
                    <div class="card-body table-responsive">
                        <table class="table table-hover">
                            <?php
                            mysqli_select_db($conn, $dbname);
                            mysqli_query($conn, "set names utf8");
                            $sql_artist = "SELECT * FROM artworks WHERE artworkID = $id";
                            $result = $conn->query($sql_artist) or die($conn->error);
                            while ($row = $result->fetch_assoc()) {
                                $row['view']=$row['view']+1;
                                $insert_sql = "UPDATE artworks SET view ={$row['view']} WHERE artworkID = {$id}";
                                mysqli_select_db($conn, $dbname);
                                $retval = mysqli_query($conn, $insert_sql);
                                if (!$retval) {
                                    die('无法更新view: ' . mysqli_error($conn));
                                }
                                $sql_username = "SELECT * FROM users WHERE userID = {$row['ownerID']}";
                                $reuser = mysqli_query($conn, $sql_username);
                                $rowuser = $reuser->fetch_assoc();
                                echo " <thead>
                            <tr>
                                <th colspan=\"2\">Product Details</th>
                            </tr>
                            </thead>
                            <tr>
                                <th>Date:</th>
                                <td>{$row['yearOfWork']}</td>
                            </tr>
                            <tr>
                                <th>Width:</th>
                                <td>{$row['width']}</td>
                            </tr>
                            <tr>
                                <th>Height:</th>
                                <td>{$row['height']}</td>
                            </tr>
                            <tr>
                                <th>Genres:</th>
                                <td>{$row['genre']}</td>
                            </tr>
                            <tr>
                                <th>View:</th>
                                <td>{$row['view']}</td>
                            </tr>
                            <tr>
                                <th>上传者:</th>
                                <td>{$rowuser['name']}</td>
                            </tr>
                        </table>
                        <div class=\"mt-3 text-center\">
                            <div class=\"alert alert-info\">价格：{$row['price']}</div>";

                               if($row['orderID']===null) {
                                   if (isset($_SESSION['id'])) {
                                       $sql_cart = "SELECT * FROM carts WHERE userID = {$_SESSION['id']}";
                                       $result2 = $conn->query($sql_cart) or die($conn->error);
                                       while ( $row2 = $result2->fetch_assoc()){
                                           if ($row2['artworkID'] === $_REQUEST['artworkID']) {
                                               echo " <button type=\"button\" class=\"btn btn-primary mr-3\" disabled><i class=\"fa fa-plus-circle\"></i>已添加</button>
                             <button type=\"button\" class=\"btn btn-primary mr-3\" disabled><i class=\"fa fa-heart\"></i>加入心愿单</button>
                        </div>";
                                               goto a;
                                           }

                                           }
                                             echo
                                               "<button type=\"button\" id='addInCart' class=\"btn btn-primary mr-3\" onclick=\"addCommodity('{$_REQUEST['artworkID']}')\"><i class=\"fa fa-plus-circle\"></i>加入购物车</button>
                            <button type=\"button\" class=\"btn btn-primary mr-3\" disabled><i class=\"fa fa-heart\"></i>加入心愿单</button>
                        </div>";


                                   }else{
                                       echo
                                       "
                            <button type=\"button\" id='addInCart' class=\"btn btn-primary mr-3\" disabled><i class=\"fa fa-plus-circle\"></i>请先登录</button>
                            <button type=\"button\" class=\"btn btn-primary mr-3\" disabled><i class=\"fa fa-heart\"></i>加入心愿单</button>
                        </div>";
                                   }
                               }else{
                                   echo " <button type=\"button\" class=\"btn btn-primary mr-3\" disabled><i class=\"fa fa-plus-circle\"></i>已销售
                            </button>
                             <button type=\"button\" class=\"btn btn-primary mr-3\" disabled><i class=\"fa fa-heart\"></i>加入心愿单</button>
                        </div>";
                               }
                            }
                            a:
                            ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

</main>

<script type="text/javascript" src="./js/cloud-zoom.1.0.2.min.js"></script>
<script type="text/javascript" src="js/simply-toast.min.js"></script>
<script type="text/javascript" src="js/commodity.js"></script>
<script type="text/javascript" rel="script" src="js/registe.js"></script>
<script type="text/javascript" rel="script" src="js/login.js"></script>


<!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"-->
<!--        integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS"-->
<!--        crossorigin="anonymous"></script>-->
</body>

</html>