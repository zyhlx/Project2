<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 2018/6/7
 * Time: 20:32
 */
//$id = 1;
//$id=$_REQUEST['userId'];

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
        <title>User</title>

        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatitable" content="IE=edge,Chrome=1">

        <link href="https://cdn.bootcss.com/limonte-sweetalert2/7.21.1/sweetalert2.min.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="css/simply-toast.min.css"/>

        <link rel="stylesheet" href="https://cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.css">
        <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/4.1.0/css/bootstrap.min.css">

        <link rel="stylesheet" href="css/bootstrap-theme.css"/>
        <link rel="stylesheet" href="css/User.css">
        <link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
        <link href="css/modal.css" rel="stylesheet"><!--bootstrap自带问题-->

        <script src="http://libs.baidu.com/jquery/1.7.1/jquery.js"></script>
        <script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
        <!--        <script src="https://cdn.bootcss.com/popper.js/1.12.5/umd/popper.min.js"></script>-->
        <script src="https://cdn.bootcss.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>


    </head>


<body>
<?php include 'header.inc.php'; ?>
<?php
if (isset($_SESSION['id'])) {

    if (!isset($_SESSION['history'])) {
        $_SESSION['history'] = array();
        $_SESSION['history']['user'] = $_SERVER['REQUEST_URI'];
    } else if (!isset($_SESSION['history']['user'])) {
        $_SESSION['history']['user'] = $_SERVER['REQUEST_URI'];
    } else {
        $new = array();
        foreach ($_SESSION['history'] as $key => $value) {
            if ($key != "user") {
                $new[$key] = $value;
            } else {
                break;
            }
        }
        $new['user'] = $_SERVER['REQUEST_URI'];
        $_SESSION['history'] = $new;
    }


    ?>
    <main class="container">
        <div class="row">
            <?php
            foreach ($_SESSION['history'] as $key => $value) {
                echo "<a href=\"{$value}\">$key&nbsp;›&nbsp;</a>";
            }

            ?>
        </div>

        <div>
            <div class="line_100"></div>
            <ul class="nav nav-tabs ul" role="tablist" id="move">

                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#home">个人信息</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#menu1">我的艺术品</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#menu2">我的订单</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#menu3">我的卖出</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#menu4">我的发信</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#menu5">我的收信</a>
                </li>
            </ul>
        </div>

        <!-- Tab panes -->
        <div class="tab-content">

            <div id="home" class="container tab-pane active"><br>
                <h3>用户信息</h3>
                <div>
                    <ul class="list-group">
                        <?php
                        $id = $_SESSION['id'];
                        mysqli_select_db($conn, $dbname);
                        mysqli_query($conn, "set names utf8");
                        $sql_user = "SELECT * FROM users WHERE userID = $id";
                        $result = $conn->query($sql_user) or die($conn->error);
                        while ($row = $result->fetch_assoc()) {
                            echo " <li class=\"list-group-item\">用户：{$row['name']}</li>
                    <li class=\"list-group-item\">电话：{$row['tel']}</li>
                    <li class=\"list-group-item\">住址：{$row['address']}</li>
                    <li class=\"list-group-item\">邮箱：{$row['email']}</li>
                    <li class=\"list-group-item d-flex justify-content-between\"><span>余额：<span
                                    id=\"wallet\">{$row['balance']}</span></span>
                        <button type=\"button\" class=\"btn btn-primary\" data-toggle=\"modal\" data-target=\"#charge\">充值信仰</button>
                    </li>";
                        }
                        ?>

                    </ul>

                </div>
            </div>
            <div id="menu1" class="container tab-pane fade"><br>
                <div class="d-flex justify-content-between"><h3>我上传的艺术品</h3><a href="" data-toggle="modal" data-target="#upload" class="btn btn-primary m-1 " onclick="review()">上传</a>
                </div>
                <table class="table table-hover table-responsive-sm">
                    <tbody>
                    <tr class="row mx-0 text-center">
                        <th class="col-md-6">商品</th>
                        <th class="col-md-3">上传时间</th>
                        <th class="col-md-2">售卖金额</th>
                        <th class="col-md-1">操作</th>
                    </tr>
                    </tbody>
                </table>
                <div>
                    <table class="table table-hover table-responsive-sm">
                        <tbody>
                        <?php
                        mysqli_select_db($conn, $dbname);
                        mysqli_query($conn, "set names utf8");
                        $sql_upload = "SELECT * FROM artworks WHERE ownerID = $id";
                        $result = $conn->query($sql_upload) or die($conn->error);
                        //                    $row = $result->fetch_assoc();
                        if (mysqli_num_rows($result) === 0) {
                            echo "  <tr class=\"row mx-0\"><td>您还尚未上传艺术品呦`</td></tr>";
                        } else {
                            while ($row = $result->fetch_assoc()) {
                                echo " <tr class=\"row mx-0\" id='{$row['artworkID']}'>
                        <td class=\"col-md-6 media p-3\">
                            <img src=\"img/{$row['imageFileName']}\" class=\"w-25\">
                            <div class=\"media-body p-3\">
                                <h4><a href='details.php?artworkID={$row['artworkID']}'>{$row['title']}</a></h4>
                                <p>{$row['description']}</p>
                            </div>
                        </td>
                        <td class=\"col-md-3 text-center\">{$row['timeReleased']}</td>
                        <td class=\"col-md-2 text-center\">{$row['price']}</td>
                        <td class=\"col-md-1 text-center\">";
                                if ($row['orderID'] != NULL) {
                                    echo " <a href=\"#\" class=\"btn btn-primary m-1\">不可修改</a></td></tr>";
                                } else {
                                    echo " <a href=\"\" data-toggle=\"modal\" data-target=\"#change\" class=\"btn btn-primary m-1 \" onclick=\"change('{$row['artworkID']}')\">修改</a>
                            <a href=\"#\" class=\"btn btn-primary m-1\" onclick=\"delete_conform('{$row['artworkID']}')\">删除</a></td>
                    </tr>";
                                }

                            }
                        }
                        ?>

                        </tbody>
                    </table>
                </div>

            </div>
            <div id="menu2" class="container tab-pane fade"><br>
                <h3>我购买的艺术品</h3>
                <table class="table table-hover table-responsive-sm">
                    <tbody>
                    <tr class="row mx-0 text-center">
                        <th class="col-md-6">商品</th>
                        <th class="col-md-3">订单时间</th>
                        <th class="col-md-3">购买金额</th>
                    </tr>
                    </tbody>
                </table>
                <div>
                    <table class="table table-hover table-responsive-sm">
                        <tbody>
                        <?php
                        mysqli_select_db($conn, $dbname);
                        mysqli_query($conn, "set names utf8");
                        $sql_buy = "SELECT * FROM orders WHERE ownerID = $id";
                        //                    $sql_buy="select * from artworks INNER join orders on artworks.orderID = orders.ownerID";
                        //                    $sql_upload = "SELECT * FROM artworks WHERE orderID = $id";      怎么找到
                        $result = $conn->query($sql_buy) or die($conn->error);
                        //                    $row = $result->fetch_assoc();
                        if (mysqli_num_rows($result) === 0) {
                            echo "  <tr class=\"row mx-0\"><td>您还尚未购买艺术品呦`</td></tr>";
                        } else {
                            while ($row = $result->fetch_assoc()) {
                                $sql_work = "SELECT * FROM artworks WHERE orderID = {$row['orderID']}";
                                $result2 = $conn->query($sql_work) or die($conn->error);
                                $row2 = $result2->fetch_assoc();
                                echo " <tr>
                        <th><span class=\"list-inline m-1\">订单编号：{$row['timeCreated']}{$row['orderID']}</span><span class=\"list-inline m-2\">商品名称：<a href='details.php?artworkID={$row2['artworkID']}'>{$row2['title']}</a></span>
                        </th>
                    </tr>
                    <tr class=\"row mx-0\">
                        <td class=\"col-md-6 media p-3\">
                            <img src=\"img/{$row2['imageFileName']}\" class=\"w-25\">
                            <div class=\"media-body p-3\">
                                <p>{$row2['description']}</p>
                            </div>
                        </td>
                        <td class=\"col-md-3 text-center\">{$row['timeCreated']}</td>
                        <td class=\"col-md-3 text-center\">{$row2['price']}</td>
                    </tr>";
                            }
                        }
                        ?>
                        <!--                    <tr>-->
                        <!--                        <th><span class="list-inline m-1">订单编号：20160526060</span><span class="list-inline m-2">商品名称：Sunflowers</span>-->
                        <!--                        </th>-->
                        <!--                    </tr>-->
                        <!--                    <tr class="row mx-0">-->
                        <!--                        <td class="col-md-6 media p-3">-->
                        <!--                            <img src="images/works/099060.jpg" class="w-25">-->
                        <!--                            <div class="media-body p-3">-->
                        <!--                                <p>商品描述</p>-->
                        <!--                            </div>-->
                        <!--                        </td>-->
                        <!--                        <td class="col-md-3 text-center">2018.4.06</td>-->
                        <!--                        <td class="col-md-3 text-center">$4000</td>-->
                        <!--                    </tr>-->
                        </tbody>
                    </table>
                </div>

            </div>
            <div id="menu3" class="container tab-pane fade"><br>
                <h3>我卖出的艺术品</h3>
                <table class="table table-hover table-responsive-sm">
                    <tbody>
                    <tr class="row mx-0 text-center">
                        <th class="col-md-4">商品</th>
                        <th class="col-md-1">卖出时间</th>
                        <th class="col-md-1">购买金额</th>
                        <th class="col-md-1">购买者</th>
                        <th class="col-md-1">电话</th>
                        <th class="col-md-2">邮箱</th>
                        <th class="col-md-2">地址</th>
                    </tr>
                    </tbody>
                </table>
                <div>
                    <table class="table table-hover table-responsive-sm">
                        <tbody>
                        <!--                    --><?php
                        //                    mysqli_select_db($conn, $dbname);
                        //                    mysqli_query($conn, "set names utf8");
                        //                    //                    $sql_upload = "SELECT * FROM artworks WHERE orderID = $id";      怎么找到
                        //                    $result = $conn->query($sql_upload) or die($conn->error);
                        //                    if ($result) {
                        //                        echo "  <tr class=\"row mx-0\"><td>您还尚未卖出艺术品呦`</td></tr>";
                        //                    } else {
                        //                        while ($row = $result->fetch_assoc()) {
                        //                            echo " <tr>
                        //                        <th><span class=\"list-inline m-1\">订单编号：{$row['orderID']}</span><span class=\"list-inline m-2\">商品名称：Sunflowers</span>
                        //                        </th>
                        //                    </tr>
                        //                    <tr class=\"row mx-0\">
                        //                        <td class=\"col-md-6 media p-3\">
                        //                            <img src=\"images/works/099060.jpg\" class=\"w-25\">
                        //                            <div class=\"media-body p-3\">
                        //                                <p>商品描述</p>
                        //                            </div>
                        //                        </td>
                        //                        <td class=\"col-md-3 text-center\">2018.4.06</td>
                        //                        <td class=\"col-md-3 text-center\">$4000</td>
                        //                    </tr>";
                        //                        }
                        //                    }
                        //
                        ?>
                        <?php
                        mysqli_select_db($conn, $dbname);
                        mysqli_query($conn, "set names utf8");
                        $sql_buy = "SELECT * FROM artworks WHERE ownerID = $id AND orderID IS NOT NULL ";
                        //                    $sql_buy="select * from artworks INNER join orders on artworks.orderID = orders.ownerID";
                        //                    $sql_upload = "SELECT * FROM artworks WHERE orderID = $id";      怎么找到
                        $result = $conn->query($sql_buy) or die($conn->error);
                        //                    $row = $result->fetch_assoc();
                        if (mysqli_num_rows($result) === 0) {
                            echo "  <tr class=\"row mx-0\"><td>您还尚未卖出艺术品呦`</td></tr>";
                        } else {
                            while ($row = $result->fetch_assoc()) {
                                $sql_work = "SELECT * FROM orders WHERE orderID = {$row['orderID']}";

                                $result2 = $conn->query($sql_work) or die($conn->error);
                                while ($row2 = $result2->fetch_assoc()) {
                                    $sql_buyer = "SELECT * FROM users WHERE userID = {$row2['ownerID']}";
                                    $result_buyer = $conn->query($sql_buyer) or die($conn->error);
                                    $row_buyer = $result_buyer->fetch_assoc();
                                    echo " <tr>
                        <th><span class=\"list-inline m-1\">订单编号：{$row2['timeCreated']}{$row2['orderID']}</span><span class=\"list-inline m-2\">商品名称：<a href='details.php?artworkID={$row['artworkID']}'>{$row['title']}</a></span>
                        </th>
                    </tr>
                    <tr class=\"row mx-0\">
                        <td class=\"col-md-4 media p-3\">
                            <img src=\"img/{$row['imageFileName']}\" class=\"w-25\">
                            <div class=\"media-body p-3\">
                                <p>{$row['description']}</p>
                            </div>
                        </td>
                        <td class=\"col-md-1 text-center\">{$row2['timeCreated']}</td>
                        <td class=\"col-md-1 text-center\">{$row['price']}</td>
                        <td class=\"col-md-1 text-center\">{$row_buyer['name']}</td>
                        <td class=\"col-md-1 text-center\">{$row_buyer['tel']}</td>
                        <td class=\"col-md-2 text-center\">{$row_buyer['email']}</td>
                        <td class=\"col-md-2 text-center\">{$row_buyer['address']}</td>
                    </tr>";
                                }

                            }
                        }
                        ?>
                        <!--                    <tr>-->
                        <!--                        <th><span class="list-inline m-1">订单编号：20160526060</span><span class="list-inline m-2">商品名称：Sunflowers</span>-->
                        <!--                        </th>-->
                        <!--                    </tr>-->
                        <!--                    <tr class="row mx-0">-->
                        <!--                        <td class="col-md-6 media p-3">-->
                        <!--                            <img src="images/works/099060.jpg" class="w-25">-->
                        <!--                            <div class="media-body p-3">-->
                        <!--                                <p>商品描述</p>-->
                        <!--                            </div>-->
                        <!--                        </td>-->
                        <!--                        <td class="col-md-3 text-center">2018.4.06</td>-->
                        <!--                        <td class="col-md-3 text-center">$4000</td>-->
                        <!--                    </tr>-->
                        </tbody>
                    </table>
                </div>

            </div>
            <div id="menu4" class="container tab-pane"><br>
                <div class="d-flex justify-content-between"><h3>发信箱</h3><a href="" data-toggle="modal" data-target="#write" class="btn btn-primary m-1">发信</a></div>
                <div>
                    <ul class="list-group">
                        <?php
                        $id = $_SESSION['id'];
                        mysqli_select_db($conn, $dbname);
                        mysqli_query($conn, "set names utf8");
                        $sql_user = "SELECT * FROM letters WHERE senderID = $id ORDER BY timeReleased";
                        $result = $conn->query($sql_user) or die($conn->error);
                        if (mysqli_num_rows($result) === 0) {
                            echo "<li class=\"list-group - item\"><span>您还没有发过信息呦~</span>";
                        }
                        while ($row = $result->fetch_assoc()) {

                            $sql_send = "select * from users where userID = {$row['receiverID']}";
                            $s = mysqli_query($conn,$sql_send);
                            if(!$s){
                                die('无法搜索数据: ' . mysqli_error($conn));
                            }
                            $s_row = $s->fetch_assoc();
                            echo " <li class=\"list-group-item row\"><span class='col-sm-1'>收件人：{$s_row['name']};</span><span class='col-sm-1'>发送时间：{$row['timeReleased']};</span>";
                            if ($row['status'] == 0) {
                                echo "<span class='col-sm-1'>接收状态：未查收;</span>";
                            } else {
                                echo "<span class='col-sm-1'>接收状态：已阅;</span>";
                            }
                            echo "<span class='col-sm-7 oneLeave'>{$row['contents']}</span><span class='col-sm-1'><button type=\"button\" class=\"btn btn-primary\" data-toggle=\"modal\" data-target=\"#receive\" onclick=\"resee({$row['letterID']})\">查看详情</button></span>
                    </li>";
                        }
                        ?>

                    </ul>

                </div>
            </div>
            <div id="menu5" class="container tab-pane"><br>
                <h3>收信箱</h3>
                <div>
                    <ul class="list-group">
                        <?php
                        $id = $_SESSION['id'];
                        mysqli_select_db($conn, $dbname);
                        mysqli_query($conn, "set names utf8");
                        $sql_user = "SELECT * FROM letters WHERE receiverID = $id ORDER BY timeReleased";
                        $result = $conn->query($sql_user) or die($conn->error);
                        if (mysqli_num_rows($result) === 0) {
                            echo "<li class=\"list-group - item\"><span>您还没有收到信息呦~</span>";
                        }
                        while ($row = $result->fetch_assoc()) {
                            $sql_send = "select * from users where userID = {$row['senderID']}";
                            $s = mysqli_query($conn,$sql_send);
                            if(!$s){
                                die('无法搜索数据: ' . mysqli_error($conn));
                            }
                            $s_row = $s->fetch_assoc();


                            echo " <li class=\"list-group-item row\"><span class='col-sm-1'>发件人：{$s_row['name']};</span><span class='col-sm-1'>发送时间：{$row['timeReleased']};</span>";
                            if ($row['status'] == 0) {
                                echo "<span class='col-sm-1' id='status{$row['letterID']}'>接收状态：未查收;</span>";
                            } else {
                                echo "<span class='col-sm-1' id='status{$row['letterID']}'>接收状态：已阅;</span>";
                            }
                            echo "<span class='col-sm-7 oneLeave'>{$row['contents']}</span><span class='col-sm-1'><button type=\"button\" class=\"btn btn-primary\" data-toggle=\"modal\" data-target=\"#receive\" onclick=\"receiveLetter({$row['letterID']})\">点击阅读</button></span>
                    </li>";
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>

    </main>
    <!-- 模态框 -->
    <div class="modal fade" id="upload">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- 模态框头部 -->
                <div class="modal-header">
                    <h4 class="modal-title">上传艺术品</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- 模态框主体 -->
                <div class="modal-body">
                    <div class="border card">
                        <section class="card-body">
                            <form method="post" action="upload.php" name="upload_form" id="upload_form"
                                  class="form-group" enctype="multipart/form-data">
                                <fieldset>
                                    <legend>PHOTO DETAILS</legend>

                                    <div class="col-sm-12 row">
                                        <label for="title">Title:</label>
                                        <input type="text" placeholder="Give your photo a descriptive name" id="title"
                                               name="title"
                                               class="form-control" required>
                                    </div>
                                    <br>
                                    <div class="col-sm-12 row">
                                        <label for="artist">Artist:</label>
                                        <input type="text" placeholder="artist" name="artist" id="artist"
                                               class="form-control" required>
                                    </div>
                                    <br>
                                    <div class="col-sm-12 row">
                                        <label for="genre">Genre</label>
                                        <input type="text" id="genre" class="form-control" name="genre"
                                               placeholder="genre" required>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label for="width">Width:</label>
                                            <input type="text" placeholder="Width" id="width" name="width"
                                                   class="form-control" onkeyup="onlyNonNegative(this)" required>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="height">Height:</label>
                                            <input type="text" placeholder="Height" id="height" name="height"
                                                   class="form-control" onkeyup="onlyNonNegative(this)" required>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="col-sm-12 row">
                                        <label for="description">Description:</label>
                                        <textarea placeholder="Adding a description will help with search results"
                                                  id="description" name="description"
                                                  class="form-control" required></textarea>
                                    </div>
                                    <br>

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label for="price">Price:</label>
                                            <input type="text" name="price" id="price" placeholder="Enter Price"
                                                   class="form-control"
                                                   onkeyup="if(this.value.length==1){this.value=this.value.replace(/[^1-9]/g,'')}else{this.value=this.value.replace(/\D/g,'')}"
                                                   onafterpaste="if(this.value.length==1){this.value=this.value.replace(/[^1-9]/g,'')}else{this.value=this.value.replace(/\D/g,'')}"
                                                   required>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="year">YearOFWork:</label>
                                            <input type="number" name="year" id="year" class="form-control" min="-10000"
                                                   max="2018" onkeyup="value=value.replace(/[^\d]/g,'')" required>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row col-sm-12">
                                        <label for="picture">艺术品图片：</label>
                                        <input name="file" id="picture" type="file" class="form-control" required>
                                        <div class="row col-sm-12" id="div">
                                            <img/>
                                        </div>
                                    </div>
                                    <br>
                                    <div class=" d-flex justify-content-end">

                                        <p class="btn-group">
                                            <button class="btn btn-secondary" type="button" onclick="uploadArtworks()">
                                                Submit
                                            </button>
                                            <button class="btn btn-secondary" type="reset">Clear</button>
                                        </p>

                                    </div>
                                </fieldset>
                            </form>
                        </section>
                    </div>
                </div>

                <!-- 模态框底部 -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">关闭</button>
                </div>

            </div>
        </div>
    </div>
    <!-- 模态框 -->
    <div class="modal fade" id="charge">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- 模态框头部 -->
                <div class="modal-header">
                    <h4 class="modal-title">充值</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- 模态框主体 -->
                <div class="modal-body">
                    <div class="border card">
                        <section class="card-body">
                            <form method="post" action="charge.php" class="form-group" id="recharge">
                                <div class="col-sm-12 row">
                                    <label for="moneyCharge">输入充值金额:</label>
                                    <input type="number" id="moneyCharge" name="moneyCharge" class="form-control"
                                           min="1"
                                           onkeyup="if(this.value.length==1){this.value=this.value.replace(/[^1-9]/g,'')}else{this.value=this.value.replace(/\D/g,'')}"
                                           onafterpaste="if(this.value.length==1){this.value=this.value.replace(/[^1-9]/g,'')}else{this.value=this.value.replace(/\D/g,'')}"">
                                </div>
                                <br>
                                <div class="d-flex justify-content-end">

                                    <p class="btn-group">
                                        <button class="btn btn-secondary" type="button" onclick="recharge()">Submit
                                        </button>
                                        <button class="btn btn-secondary" type="reset">Clear</button>
                                    </p>

                                </div>
                            </form>
                        </section>
                    </div>
                </div>

                <!-- 模态框底部 -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">关闭</button>
                </div>

            </div>
        </div>
    </div>
    <!-- 模态框 -->
    <div class="modal fade" id="change">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- 模态框头部 -->
                <div class="modal-header">
                    <h4 class="modal-title">上传艺术品</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- 模态框主体 -->
                <div class="modal-body">
                    <div class="border card">
                        <section class="card-body">
                            <form method="post" action="upload.php" name="change_form" id="change_form"
                                  class="form-group" enctype="multipart/form-data">
                                <fieldset>
                                    <legend>PHOTO DETAILS</legend>

                                    <div class="col-sm-12 row">
                                        <label for="title">Title:</label>
                                        <input type="text" placeholder="Give your photo a descriptive name"
                                               id="title_change" name="title"
                                               class="form-control" required>
                                    </div>
                                    <br>
                                    <div class="col-sm-12 row">
                                        <label for="artist">Artist:</label>
                                        <input type="text" placeholder="artist" name="artist" id="artist_change"
                                               class="form-control" required>
                                    </div>
                                    <br>
                                    <div class="col-sm-12 row">
                                        <label for="genre">Genre</label>
                                        <input type="text" id="genre_change" class="form-control" name="genre"
                                               placeholder="genre" required>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label for="width">Width:</label>
                                            <input type="text" placeholder="Width" id="width_change" name="width"
                                                   class="form-control" onkeyup="onlyNonNegative(this)" required>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="height">Height:</label>
                                            <input type="text" placeholder="Height" id="height_change" name="height"
                                                   class="form-control" onkeyup="onlyNonNegative(this)" required>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="col-sm-12 row">
                                        <label for="description">Description:</label>
                                        <textarea placeholder="Adding a description will help with search results"
                                                  id="description_change" name="description"
                                                  class="form-control" required></textarea>
                                    </div>
                                    <br>

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label for="price">Price:</label>
                                            <input type="text" name="price" id="price_change" placeholder="Enter Price"
                                                   class="form-control"
                                                   onkeyup="if(this.value.length==1){this.value=this.value.replace(/[^1-9]/g,'')}else{this.value=this.value.replace(/\D/g,'')}"
                                                   onafterpaste="if(this.value.length==1){this.value=this.value.replace(/[^1-9]/g,'')}else{this.value=this.value.replace(/\D/g,'')}"
                                                   required>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="year">YearOFWork:</label>
                                            <input type="number" name="year" id="year_change" class="form-control"
                                                   min="-10000"
                                                   max="2018" onkeyup="value=value.replace(/[^\d]/g,'')" required>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row col-sm-12">
                                        <label for="picture">艺术品图片：</label>
                                        <input name="file" id="picture_change" type="file" class="form-control"
                                               required>
                                        <div class="row col-sm-12" id="div_change">
                                            <img/>
                                        </div>
                                    </div>
                                    <br>
                                    <div class=" d-flex justify-content-end">

                                        <p class="btn-group">
                                            <button class="btn btn-secondary" type="button" onclick="changeArtworks()">
                                                Submit
                                            </button>
                                            <button class="btn btn-secondary" type="reset">Clear</button>
                                        </p>

                                    </div>
                                </fieldset>
                            </form>
                        </section>
                    </div>
                </div>

                <!-- 模态框底部 -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">关闭</button>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="write">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- 模态框头部 -->
                <div class="modal-header">
                    <h4 class="modal-title">写信</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- 模态框主体 -->
                <div class="modal-body">
                    <div class="border card">
                        <section class="card-body">
                            <form method="post" action="write.php" class="form-group" id="write-form">
                                <div class="row col-sm-12"><label for="receiver">收信人：</label>
                                <input class="form-control" name="receiver" id="receiver"></div>
                                <div class="row col-sm-12">
                                    <label for="content">内容：</label>
                                    <textarea rows="20" cols="60" class="form-control" name="content" id="content"></textarea>
                                </div>
                                <br>
                                <div class="d-flex justify-content-end">

                                    <p class="btn-group">
                                        <button class="btn btn-secondary" type="button" onclick="writeLetter()">Submit
                                        </button>
                                        <button class="btn btn-secondary" type="reset">Clear</button>
                                    </p>

                                </div>
                            </form>
                        </section>
                    </div>
                </div>

                <!-- 模态框底部 -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">关闭</button>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="receive">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- 模态框头部 -->
                <div class="modal-header">
                    <h4 class="modal-title">信件</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- 模态框主体 -->
                <div class="modal-body">
                    <div class="border card">
                        <section class="card-body">
                            <form method="post" action="receive.php" class="form-group" id="receive-form">
                                <div class="row col-sm-12"><label for="sender">发信人：</label>
                                    <input class="form-control" name="sender" id="sender" readonly="readonly"></div>
                                <div class="row col-sm-12"><label for="rece">收信人：</label>
                                    <input class="form-control" name="receiver" id="rece" readonly="readonly"></div>
                                <div class="row col-sm-12"><label for="tim">发送时间：</label><input class="form-control" name="time" id="tim" readonly="readonly"></div>
                                <div class="row col-sm-12">
                                    <label for="cont">内容：</label>
                                    <textarea rows="20" cols="60" class="form-control" name="content" id="cont" readonly="readonly"></textarea>
                                </div>
                                <br>
                            </form>
                        </section>
                    </div>
                </div>

                <!-- 模态框底部 -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">关闭</button>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.bootcss.com/limonte-sweetalert2/7.21.1/sweetalert2.min.js"></script>


    <script src="js/simply-toast.min.js"></script>
    <script type="text/javascript" src="js/checkLength.js"></script>
    <script type="text/javascript" src="js/uploadArtworks.js"></script>
    <script type="text/javascript" src="js/letter.js"></script>
    <!--下面后面是放大的引入-->
<!--    <script src="http://www.daiwei.org/global/js/jquery.js"></script>-->
    <script src="http://www.daiwei.org/global/js/jquery.easing.js"></script>
    <script src="http://www.daiwei.org/components/toast/js/toast.js"></script>
    <script src="js/moveline.js"></script>
    <script>
        $('#move').moveline({
            color: '#EC378F',
            position: 'inner',
            click: function (ret) {
                ret.ele.addClass('active').siblings().removeClass('active');
            }
        });
    </script>


    </body>
    </html>
    <?php
} else {
    echo "  <script src=\"js/simply-toast.min.js\"></script><script>$.simplyToast('请先登录','warning');setTimeout(\"window.location='index.php'\",2000); </script>";

}


?>