<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 2018/6/5
 * Time: 13:54
 */


function outPutHotImage1($number){
    include("index-data.php");
    global $hotimage,$hotimagecount;
    echo "  <div class=\"carousel-inner\">
                        <div class=\"carousel-item active media border p-1\">
                            <img src=\"img/".$hotimage["{$hotimagecount[$number]}"]['imageFileName']."\" class=\"img-responsive center-block mr-3 mt-1\">
                            <div class=\"carousel-caption-reset\">
                                <h3>".$hotimage["{$hotimagecount[$number]}"]['title']."</h3>
                                <p>".$hotimage["{$hotimagecount[$number]}"]['description']."</p>
                            </div>
                        </div>
                        </div>";
}


function outPutHotImage2($number){
    include("index-data.php");
    global $hotimage,$hotimagecount;
    echo "  <div class=\"carousel-inner\">
                        <div class=\"carousel-item media border p-1\">
                            <img src=\"img/".$hotimage[$hotimagecount[$number]]['imageFileName']."\" class=\"img-responsive center-block mr-3 mt-1\">
                            <div class=\"carousel-caption-reset\">
                                <h3>".$hotimage[$hotimagecount[$number]]['title']."</h3>
                                <p>".$hotimage[$hotimagecount[$number]]['description']."</p>
                            </div>
                        </div>
                        </div>";
}
?>