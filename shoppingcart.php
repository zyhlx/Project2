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
    <title>ShoppingCart</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatitable" content="IE=edge,Chrome=1">

    <link rel="stylesheet" href="https://cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.css">
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/4.1.0/css/bootstrap.min.css">

    <script src="http://libs.baidu.com/jquery/1.7.1/jquery.js"></script>

    <script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdn.bootcss.com/popper.js/1.12.5/umd/popper.min.js"></script>
    <script src="https://cdn.bootcss.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>

    <link rel="stylesheet" type="text/css" href="css/simply-toast.min.css" />
    <link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
    <link rel="stylesheet" href="css/bootstrap-theme.css"/>
    <link rel="stylesheet" href="css/shoppingcart.css">
</head>
<body>
<?php include 'header.inc.php'?>
<?php
if (isset($_SESSION['id'])) {


    if(!isset($_SESSION['history'])){
        $_SESSION['history'] = array();
        $_SESSION['history']['cart'] = $_SERVER['REQUEST_URI'];
    }else if (!isset($_SESSION['history']['cart'])){
        $_SESSION['history']['cart'] = $_SERVER['REQUEST_URI'];
    }else{
        $new = array();
        foreach ($_SESSION['history'] as $key => $value) {
            if($key != "cart"){
                $new[$key] = $value;
            }else{
                break;
            }
        }
        $new['cart'] = $_SERVER['REQUEST_URI'];
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

        <h3>我的购物车</h3>
        <table class="table table-hover table-responsive-sm">
            <tbody>
            <tr class="row mx-0 text-center">
                <th class="col-md-7">商品</th>
                <th class="col-md-3">售卖金额</th>
                <th class="col-md-2">操作</th>
            </tr>
            </tbody>
        </table>
        <div>
            <table class="table table-hover table-responsive-sm">
                <tbody id="cartTable"><?php
                $id = $_SESSION['id'];
                mysqli_select_db($conn, $dbname);
                mysqli_query($conn, "set names utf8");
                $sql_buy = "SELECT * FROM carts WHERE userID = $id";
                //                    $sql_buy="select * from artworks INNER join orders on artworks.orderID = orders.ownerID";
                //                    $sql_upload = "SELECT * FROM artworks WHERE orderID = $id";      怎么找到
                $result = $conn->query($sql_buy) or die($conn->error);
                if (mysqli_num_rows($result) === 0) {
                    echo "<tr class=\"row mx-0\"><td>您还尚未添加购物车呦`</td></tr>";
                } else {
                    while ($row = $result->fetch_assoc()) {
                        $sql_work = "SELECT * FROM artworks WHERE artworkID = {$row['artworkID']}";
                        $result2 = $conn->query($sql_work) or die($conn->error);
                        $row2 = $result2->fetch_assoc();
                        if (isset($row['artworkID'])) {
                            echo "<tr class=\"row mx-0\" id=\"{$row['artworkID']}\">
                <td class=\"col-md-7 media p-3\">
                    <img src=\"img/{$row2['imageFileName']}\" class=\"w-25\">
                    <div class=\"media-body p-3\">
                        <h4><a href='details.php?artworkID={$row2['artworkID']}'>{$row2['title']}</a></h4>
                        <p class='text-leave'>{$row2['description']}</p>
                    </div></td>
                <td name='price' class=\"col-md-3 text-center\">{$row2['price']}";
                            if ($row2['price'] != $row['originalPrice']) {
                                echo "加入购物车时价格为：{$row['originalPrice']}";
                            }
                            echo "</td>
                <td class=\"col-md-2 text-center\">";
                            if ($row2['orderID'] === null) {
                                echo "<a href=\"#\" class=\"btn btn-primary m-1\" onclick=\"checkArtworks('{$row2['artworkID']}')\">购买</a>
                    <a href=\"#\" class=\"btn btn-primary m-1\" onclick=\"deleteCommodity('{$row['artworkID']}')\">删除</a></td>
            </tr>";

                            } else {
                                echo "<a href=\"#\" class=\"btn btn-primary m-1\" disabled=''>已被购买</a>
                    <a href=\"#\" class=\"btn btn-primary m-1\" onclick=\"deleteCommodity('{$row['artworkID']}')\">删除</a></td>
            </tr>";
                            }
                        }else{
                            $sql_work = "DELETE FROM carts WHERE artworkID = {$row['artworkID']} AND userID = {$_SESSION['id']}";
                            $result = $conn->query($sql_work) or die($conn->error);
                            if (!$result) {
                                die('无法删除数据: ' . mysqli_error($conn));
                            } else {
                                if(isset($_SESSION['cart'][$_REQUEST['artworkID']])){
                                    unset($_SESSION['cart'][$_REQUEST['artworkID']]);
                                }
                                exit;
                            }
                        }
                    }
                }
                ?></tbody>
            </table>
        </div>
        <div class="d-flex justify-content-end">
            <a class="btn btn-primary" href="#" onclick="checkArtworks('<?php echo "true" ?>')">结算 <span id="total"><?php
                    mysqli_query($conn, "set names utf8");
                    $sql_total = "SELECT * FROM carts WHERE userID = $id";
                    //                    $sql_buy="select * from artworks INNER join orders on artworks.orderID = orders.ownerID";
                    //                    $sql_upload = "SELECT * FROM artworks WHERE orderID = $id";      怎么找到
                    $result3 = $conn->query($sql_total) or die($conn->error);
                    $total = 0;
                    while ($row3 = $result3->fetch_assoc()) {
                        GLOBAL $total;
                        $sql_work = "SELECT price,artworkID FROM artworks WHERE artworkID = {$row3['artworkID']}";
                        $result4 = $conn->query($sql_work) or die($conn->error);
                        $row4 = $result4->fetch_assoc();
                        $total += $row4['price'];
                    }
                    echo "$total";
                    ?></span></a>

            <!--        <div class="alert alert-success alert-dismissable">-->
            <!--            <button type="button" class="close" data-dismiss="alert">&times;</button>-->
            <!--            <strong>成功!</strong>-->
            <!--        </div>-->
        </div>

    </main>
    <?php
}else {
    echo "  <script src=\"js/simply-toast.min.js\"></script><script>$.simplyToast('请先登录','warning');setTimeout(\"window.location='index.php'\",2000); </script>";
}


?>

<script src="js/simply-toast.min.js"></script>
<script src="js/commodity.js" type="text/javascript"></script>
</body>
</html>