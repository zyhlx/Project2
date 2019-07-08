<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 2018/6/7
 * Time: 19:34
 */
$dbhost = 'localhost';  // mysql服务器主机地址
$dbuser = 'root';// mysql用户名
$dbpass = '';          // mysql用户名密码
$dbname = 'artstore';
$conn = mysqli_connect($dbhost, $dbuser, $dbpass);
if (!$conn) {
    die('连接错误: ' . mysqli_error($conn));
}
?>

<aside class="col-md-2">
    <div class="card">
        <div class="card-header font-weight-bold">流行艺术家</div>
        <ul class="list-group">

            <?php

            mysqli_select_db($conn, $dbname);
            mysqli_query($conn, "set names utf8");
            $sql_artist="SELECT count(*),artist,sum(`view`)AS views FROM artworks GROUP BY artist ORDER BY views desc LIMIT 0 , 5";
            $result = $conn->query($sql_artist) or die($conn->error);
            while ($row = $result->fetch_assoc()) {
                echo " <li class=\"list-group-item\"><a href=\"#\" onclick=\"window.location.href = 'search.php?input_text={$row['artist']}&search[]=artist'\">{$row['artist']}</a></li>";
            }

            ?>
        </ul>
    </div>
    <!-- end continents panel -->

    <div class="card">
        <div class="card-header font-weight-bold">流行流派</div>
        <ul class="list-group">
            <?php

            mysqli_select_db($conn, $dbname);
            mysqli_query($conn, "set names utf8");
            $sql_genre="SELECT count(*),genre,sum(`view`)AS views FROM artworks GROUP BY genre ORDER BY views desc LIMIT 0 , 5";
            $result = $conn->query($sql_genre) or die($conn->error);
            while ($row = $result->fetch_assoc()) {
                echo " <li class=\"list-group-item\"><a href=\"#\">{$row['genre']}</a></li>";
            }

            ?>

        </ul>
    </div>
    <!-- end continents panel -->
</aside>
