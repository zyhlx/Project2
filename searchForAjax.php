<?php
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
//$sql_total = "select * from artworks";
//$result = mysqli_query($conn, $sql_total);

$sel = isset($_REQUEST['sel'])? $_REQUEST['sel'] :'view';



$sql_total = "select * from artworks  WHERE artworks.orderID <=> NULL";

//if (isset($_REQUEST['input_text'])) {
//    $search = isset($_REQUEST['search'])? $_REQUEST['search'] : array('title');
//    $search_content = implode('OR',$search);
//    GLOBAL  $sql_total;
//    $sql_total = "select * from artworks where {$search_content}  LIKE '%{$_REQUEST['input_text']}%'";
//} else {
//    $sql_total = "select * from artworks ";
//}

if (isset($_REQUEST['input_text'])) {
    $search = isset($_REQUEST['search'])? $_REQUEST['search'] : 'title';
    $search1 = explode(" ", $search);
    $search_content = implode(' LIKE \'%'.$_REQUEST['input_text'].'%\' OR ',$search1);
    GLOBAL  $sql_total;
    $sql_total = "select * from artworks where {$search_content}  LIKE '%{$_REQUEST['input_text']}%' AND artworks.orderID <=> NULL";
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
//        $sql_show = "select * from artworks limit " . $mark . "," . $pageSize;
//        $result = mysqli_query($conn, $sql_show);

        $sql_show = "select * from artworks  WHERE artworks.orderID <=> NULL ORDER BY artworks.".$sel." DESC limit " . $mark . "," . $pageSize;
        if (isset($_REQUEST['input_text'])) {
            $search = isset($_REQUEST['search'])? $_REQUEST['search'] : 'title';
            $search1 = explode(" ", $search);
            $search_content = implode(' LIKE \'%'.$_REQUEST['input_text'].'%\' OR ',$search1);
//            $search_content = implode('OR',$search);
            GLOBAL  $sql_show;
            $sql_show = "select * from artworks where {$search_content} LIKE '%{$_REQUEST['input_text']}%' AND artworks.orderID <=> NULL ORDER BY artworks.".$sel." DESC limit " . $mark . "," . $pageSize;
        } else {
            $sql_show = "select * from artworks  WHERE artworks.orderID <=> NULL ORDER BY artworks.".$sel." DESC limit " . $mark . "," . $pageSize;
        }

        $result = mysqli_query($conn, $sql_show);

        ?>

        <?php
        for ($j = 0; $j < $pageSize; $j++) {
            $row = mysqli_fetch_assoc($result);
//            echo $row['description'];
//            echo "<hr>";
//            $desc = strip_tags($row['description']);
            echo " <div class=\"card text-center col-md-4\">
            <img class=\"card-img-top\" src=\"img/{$row['imageFileName']}\" alt=\"Card image\"
                 height=\"280\">
            <div class=\"card-body\">
                <h4 class=\"card-title\">{$row['title']}</h4>
                <p class=\"card-text text-leave\">{$row['description']}</p>
                <p class=\"card-text\">
                            <span class=\"btn btn-primary mr-3\">热度<span
                                    class=\"badge badge-light\">{$row['view']}</span></span>
                    <a href=\"details.php?artworkID={$row['artworkID']}\" class=\"btn btn-primary\">See Profile</a>
                </p>
            </div>
    </div>";

        }
    } else {
        $number = $totalCount - $mark;
//        $sql_lastpage = "select * from artworks limit " . $mark . "," . $number;
//        $result = mysqli_query($conn, $sql_lastpage);

        $sql_lastpage = "select * from artworks  WHERE artworks.orderID <=> NULL ORDER BY artworks.".$sel." DESC limit " . $mark . "," . $number;
        if (isset($_REQUEST['input_text'])) {
            $search = isset($_REQUEST['search'])? $_REQUEST['search'] :'title';
            $search1 = explode(" ", $search);
            $search_content = implode(' LIKE \'%'.$_REQUEST['input_text'].'%\' OR ',$search1);
//            $search_content = implode('OR',$search);
            GLOBAL  $sql_lastpage;
            $sql_lastpage = "select * from artworks where {$search_content} LIKE '%{$_REQUEST['input_text']}%' AND artworks.orderID <=> NULL ORDER BY artworks.".$sel." DESC limit " . $mark . "," . $number;
        } else {
            $sql_lastpage = "select * from artworks  WHERE artworks.orderID <=> NULL ORDER BY artworks.".$sel." DESC limit " . $mark . "," . $number;
        }
        $result = mysqli_query($conn, $sql_lastpage);


        for ($j = 0; $j < $number; $j++) {
            $row = mysqli_fetch_assoc($result);
//            $desc = strip_tags($row['description']);
            echo " <div class=\"card text-center col-md-4\">
                <img class=\"card-img-top\" src=\"img/{$row['imageFileName']}\" alt=\"Card image\"
                     height=\"280\">
                <div class=\"card-body\">
                    <h4 class=\"card-title\">{$row['title']}</h4>
                    <p class=\"card-text text-leave\">{$row['description']}</p>
                    <p class=\"card-text\">
                            <span class=\"btn btn-primary mr-3\">热度<span
                                    class=\"badge badge-light\">{$row['view']}</span></span>
                        <a href=\"details.php?artworkID={$row['artworkID']}\" class=\"btn btn-primary\">See Profile</a>
                    </p>
                </div>
            </div>"
            ?>

            <?php
        }
    }
}

    ?>