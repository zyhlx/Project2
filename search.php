<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 2018/6/7
 * Time: 20:32
 */


function CheckURL(){
    $servername=$_SERVER['SERVER_NAME'];
    $sub_from=$_SERVER["HTTP_REFERER"];
    $sub_len=strlen($servername);
    $checkfrom=substr($sub_from,7,$sub_len);
    if($checkfrom!=$servername)die("警告！你正在从外部提交数据！请立即终止！");
};
//CheckURL();


//$id=$_REQUEST['userId'];
$dbhost = 'localhost';  // mysql服务器主机地址
$dbuser = 'root';// mysql用户名
$dbpass = '';          // mysql用户名密码
$dbname = 'artstore';
$conn = mysqli_connect($dbhost, $dbuser, $dbpass);
if (!$conn) {
    die('连接错误: ' . mysqli_error($conn));
}
//print_r( $_REQUEST['search']);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatitable" content="IE=edge,Chrome=1">

    <link rel="stylesheet" href="https://cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.css">
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/4.1.0/css/bootstrap.min.css">

    <script src="http://libs.baidu.com/jquery/1.7.1/jquery.js"></script>
    <script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdn.bootcss.com/popper.js/1.12.5/umd/popper.min.js"></script>
    <script src="https://cdn.bootcss.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>

    <link rel="stylesheet" type="text/css" href="css/simply-toast.min.css" />
    <link rel="stylesheet" href="css/bootstrap-theme.css"/>
    <link rel="stylesheet" href="css/Search.css">
    <link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
    <link href="css/modal.css" rel="stylesheet"><!--bootstrap自带问题-->
</head>
<body>
<?php include 'header.inc.php';



if(!isset($_SESSION['history'])){
    $_SESSION['history'] = array();
    $_SESSION['history']['search'] = $_SERVER['REQUEST_URI'];
}else if (!isset($_SESSION['history']['search'])){
    $_SESSION['history']['search'] = $_SERVER['REQUEST_URI'];
}else{
    $new = array();
    foreach ($_SESSION['history'] as $key => $value) {
        if($key != "search"){
            $new[$key] = $value;
        }else{
            break;
        }
    }
    $new['search'] = $_SERVER['REQUEST_URI'];
    $_SESSION['history'] = $new;
}


?>
<main class="container">
    <div class="d-flex justify-content-between">
        <div>
            <?php
            foreach ($_SESSION['history'] as $key => $value) {
                echo "<a href=\"{$value}\">$key&nbsp;›&nbsp;</a>";
            }

            ?>
        </div>
        <form class="d-flex form-group" id="sequence_form">
            <select name="sequence" id="sequence" class="form-control ml-2"
                    onchange="seqChange(<?php if(isset($_REQUEST['input_text'])){echo "'{$_REQUEST['input_text']}'";} ?><?php if(isset($_REQUEST['search'])&&(isset($_REQUEST['input_text']))) echo ',';?><?php if(isset($_REQUEST['search'])){ $search_content = http_build_query($_REQUEST['search']);
            echo "'{$search_content}'";} ?>)">
                <?php

                $sel = isset($_REQUEST['sel'])? $_REQUEST['sel'] :'view';
                if($sel ==="price"){
                ?>
                    <option value="price" selected>价格</option>
                    <option value="view">热度</option>
                    <option value="timeReleased">时间</option>
                <?php
                }else if($sel==="view"){
                ?>
                <option value="price">价格</option>
                <option value="view" selected>热度</option>
                <option value="timeReleased">时间</option>
                <?php
                }else if($sel==="timeReleased"){
                ?>
                    <option value="price">价格</option>
                    <option value="view" >热度</option>
                    <option value="timeReleased" selected>时间</option>
                <?php
                }

                ?>
            </select>
        </form>


    </div>
    <div class="row" id="search_result">

    <?php

//    $search = isset($_REQUEST['search'])? $_REQUEST['search'] : 'title';

    $sel = isset($_REQUEST['sel'])? $_REQUEST['sel'] :'view';

    mysqli_select_db($conn, $dbname);
    mysqli_query($conn, "set names utf8");
    $sql_total = "select * from artworks WHERE artworks.orderID <=> NULL ";
    if (isset($_REQUEST['input_text'])) {
       $search = isset($_REQUEST['search'])? $_REQUEST['search'] : array('title');
        $search_content = implode(' LIKE \'%'.$_REQUEST['input_text'].'%\' OR ',$search);
        GLOBAL  $sql_total;
        $sql_total = "select * from artworks where {$search_content}  LIKE '%{$_REQUEST['input_text']}%' AND artworks.orderID <=> NULL ";
    } else {
        $sql_total = "select * from artworks  WHERE artworks.orderID <=> NULL";
    }

    $result = mysqli_query($conn, $sql_total);

    if ($result)
        $totalCount = $result->num_rows;
    else
        $totalCount = 0;

    if ($totalCount == 0)
        echo "No artworks";
    else {
    $pageSize = 6;
    $totalPage = (int)(($totalCount % $pageSize == 0) ? ($totalCount / $pageSize) : ($totalCount / $pageSize + 1));

    if (!isset($_GET['page']))
        $currentPage = 1;
    else if ($_GET['page'] <= 0 || $_GET['page'] > $totalPage)
        $currentPage = 1;
    else
        $currentPage = $_GET['page'];


    $mark = ($currentPage - 1) * $pageSize;
    $firstPage = 1;
    $lastPage = $totalPage;
    $prePage = ($currentPage > 1) ? $currentPage - 1 : 1;
    $nextPage = ($totalPage - $currentPage > 0) ? $currentPage + 1 : $totalPage;

    if ($mark < $pageSize * ($totalPage - 1)) {
        $sql_show = "select * from artworks  WHERE artworks.orderID <=> NULL ORDER BY artworks.".$sel." DESC limit " . $mark . "," . $pageSize;

        if (isset($_REQUEST['input_text'])) {
           $search = isset($_REQUEST['search']) ? $_REQUEST['search'] : array('title');
            $search_content = implode(' LIKE \'%' . $_REQUEST['input_text'] . '%\' OR ', $search);
            GLOBAL $sql_show;
            $sql_show = "select * from artworks where {$search_content} LIKE '%{$_REQUEST['input_text']}%'AND artworks.orderID <=> NULL ORDER BY artworks.".$sel." DESC limit " . $mark . "," . $pageSize;
        } else {
            $sql_show = "select * from artworks  WHERE artworks.orderID <=> NULL ORDER BY artworks.".$sel." DESC limit " . $mark . "," . $pageSize;
        }
        $result = mysqli_query($conn, $sql_show);
        ?>


        <?php
        for ($j = 0; $j < $pageSize; $j++) {
            $row = mysqli_fetch_assoc($result);
            $desc = strip_tags($row['description']);
            ?>
            <div class="card text-center col-md-4">
                <img class="card-img-top" src="img/<?php echo "{$row['imageFileName']}" ?>" alt="Card image"
                     height="280">
                <div class="card-body">
                    <h4 class="card-title"><?php echo "{$row['title']}" ?></h4>
                    <p class="card-text text-leave"><?php echo "{$desc}" ?></p>
                    <p class="card-text">
                            <span class="btn btn-primary mr-3">热度<span
                                        class="badge badge-light"><?php echo "{$row['view']}" ?></span></span>
                        <a href="details.php?artworkID=<?php echo "{$row['artworkID']}" ?>" class="btn btn-primary">See
                            Profile</a>
                    </p>
                </div>
            </div>
            <?php
        }
    } else {
        $number = $totalCount - $mark;
        $sql_lastpage = "select * from artworks WHERE artworks.orderID <=> NULL ORDER BY artworks.".$sel." DESC limit " . $mark . "," . $number;
        if (isset($_REQUEST['input_text'])) {
            $search = isset($_REQUEST['search']) ? $_REQUEST['search'] : array('title');
            $search_content = implode(' LIKE \'%' . $_REQUEST['input_text'] . '%\' OR ', $search);
            GLOBAL $sql_lastpage;
            $sql_lastpage = "select * from artworks where {$search_content} LIKE '%{$_REQUEST['input_text']}%' AND artworks.orderID <=> NULL ORDER BY artworks.".$sel." DESC limit " . $mark . "," . $number;
        } else {
            $sql_lastpage = "select * from artworks  WHERE artworks.orderID <=> NULL ORDER BY artworks.".$sel." DESC limit " . $mark . "," . $number;
        }
        $result = mysqli_query($conn, $sql_lastpage);
        for ($j = 0; $j < $number; $j++) {
            $row = mysqli_fetch_assoc($result);
            $desc = strip_tags($row['description']);
            ?>
            <div class="card text-center col-md-4">
                <img class="card-img-top" src="img/<?php echo "{$row['imageFileName']}" ?>" alt="Card image"
                     height="280">
                <div class="card-body">
                    <h4 class="card-title"><?php echo "{$row['title']}" ?></h4>
                    <p class="card-text text-leave"><?php echo "{$desc}" ?></p>
                    <p class="card-text">
                            <span class="btn btn-primary mr-3">热度<span
                                        class="badge badge-light"><?php echo "{$row['view']}" ?></span></span>
                        <a href="details.php?artworkID=<?php echo "{$row['artworkID']}" ?>" class="btn btn-primary">See
                            Profile</a>
                    </p>
                </div>
            </div>
            <?php
        }
    }

    ?>
    </div>
    <?php
    if (isset($_REQUEST['input_text'])) {

        ?>


        <div id="buttonPart" class="d-flex justify-content-between mt-3">
            <a class="btn btn-primary"
               onclick="loadXMLDoc(<?php echo $firstPage; ?>,<?php echo $lastPage; ?>,<?php echo "'{$_REQUEST['input_text']}'" ?>,<?php $search_content = implode(' ', $search);
               echo "'{$search_content}'" ?>)">FirstPage</a>
            &nbsp;&nbsp;
            <a class="btn btn-primary"
               onclick="loadXMLDoc(<?php echo $prePage; ?>,<?php echo $lastPage; ?>,<?php echo "'{$_REQUEST['input_text']}'" ?>,<?php $search_content = implode(' ', $search);
               echo "'{$search_content}'" ?>)">PrePage</a>
            &nbsp;&nbsp;
            <a class="btn btn-primary"
               onclick="loadXMLDoc(<?php echo $nextPage; ?>,<?php echo $lastPage; ?>,<?php echo "'{$_REQUEST['input_text']}'" ?>,<?php $search_content = implode(' ', $search);
               echo "'{$search_content}'" ?>)">NextPage</a>
            &nbsp;&nbsp;
            <a class="btn btn-primary"
               onclick="loadXMLDoc(<?php echo $lastPage; ?>,<?php echo $lastPage; ?>,<?php echo "'{$_REQUEST['input_text']}'" ?>,<?php $search_content = implode(' ', $search);
               echo "'{$search_content}'" ?>)">LastPage</a>
            &nbsp;&nbsp;
            <?php echo $currentPage; ?>/<?php echo $totalPage; ?>&nbsp;Pages
        </div>

        <?php
    }else{
        ?>

    <div id="buttonPart" class="d-flex justify-content-between mt-3">
        <a class="btn btn-primary"
           onclick="loadXMLDoc2(<?php echo $firstPage; ?>,<?php echo $lastPage; ?>)">FirstPage</a>
        &nbsp;&nbsp;
        <a class="btn btn-primary"
           onclick="loadXMLDoc2(<?php echo $prePage; ?>,<?php echo $lastPage; ?>)">PrePage</a>
        &nbsp;&nbsp;
        <a class="btn btn-primary"
           onclick="loadXMLDoc2(<?php echo $nextPage; ?>,<?php echo $lastPage; ?>)">NextPage</a>
        &nbsp;&nbsp;
        <a class="btn btn-primary"
           onclick="loadXMLDoc2(<?php echo $lastPage; ?>,<?php echo $lastPage; ?>)">LastPage</a>
        &nbsp;&nbsp;
        <?php echo $currentPage; ?>/<?php echo $totalPage; ?>&nbsp;Pages
    </div>
    <?php
    }
    }//end of else totalCount != 0;

    if ($result) {
        mysqli_free_result($result);
    }
    mysqli_close($conn);

    ?>
    <!--    <script>-->
    <!--        function loadXMLDoc(str) {-->
    <!--            var xmlhttp;-->
    <!--            if (window.XMLHttpRequest) {-->
    <!--                //  IE7+, Firefox, Chrome, Opera, Safari 浏览器执行代码-->
    <!--                xmlhttp = new XMLHttpRequest();-->
    <!--            }-->
    <!--            else {-->
    <!--                // IE6, IE5 浏览器执行代码-->
    <!--                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");-->
    <!--            }-->
    <!--            xmlhttp.onreadystatechange = function () {-->
    <!--                if (xmlhttp.readyState == 4 && (xmlhttp.status == 200 || xmlhttp.status == 304)) {-->
    <!--                    document.getElementById("search_result").innerHTML = xmlhttp.responseText;-->
    <!--                    // document.getElementById("buttonPart").innerHTML="";-->
    <!---->
    <!--                }-->
    <!--                xmlhttp.open("GET", "searchForAjax.php?page=" + str, true);-->
    <!--                xmlhttp.send();-->
    <!--            }-->
    <!--        }-->
    <!--    </script>-->
</main>
<script src="js/simply-toast.min.js"></script>
<script src="js/search.js" type="text/javascript"></script>
<script type="text/javascript" rel="script" src="js/registe.js"></script>
<script type="text/javascript" rel="script" src="js/login.js"></script>
</body>
</html>