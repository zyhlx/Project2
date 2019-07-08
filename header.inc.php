<?php
//放在公共文件的头
session_start();

?>


<header>
    <div class="topHeaderRow">
        <div class="container-fluid d-flex flex-row-reverse">
            <ul class="list-inline">

                <?php if (!isset($_POST['username'])) {
                    if (!isset($_SESSION['username'])) {
                        ?>
                        <li class="list-inline-item"><a href="index.php"><i class="fa fa-sign-out"></i>首页</a></li>
                        <li class="list-inline-item"><a href="" data-toggle="modal" data-target="#Register" class=""><i
                                        class="fa fa-user-circle"></i>注册</a></li>
                        <li class="list-inline-item"><a href="" data-toggle="modal" data-target="#Login"><i
                                        class="fa fa-cart-plus"></i>登录</a></li>

                        <?php
                    } else {
                        ?>
                        <li class="list-inline-item"><a href="logout.php?action=logout"><i class="fa fa-sign-out"></i>登出</a></li>
                        <li class="list-inline-item"><a href="user.php"><i class="fa fa-user-circle"></i>用户</a></li>
                        <li class="list-inline-item"><a href="shoppingcart.php"><i class="fa fa-cart-plus"></i>购物车</a></li>
                        <?php
                    }
                } else {
                    echo " <li class=\"list-inline-item\"><a href=\"logout.php?action=logout\"><i class=\"fa fa-sign-out\"></i>登出</a></li>
                    <li class=\"list-inline-item\"><a href=\"#\"><i class=\"fa fa-user-circle\"></i>{$_SESSION['username']}</a></li>
                    <li class=\"list-inline-item\"><a href=\"shoppingcart.php\"><i class=\"fa fa-cart-plus\"></i>购物车</a></li>";
                }
                ?>
            </ul>
        </div>
    </div>
    <!-- end topHeaderRow -->
    <nav class="navbar navbar-expand-sm w-100 bg-light navbar-light">
        <div class="container d-flex">
            <div class="navbar-header">
                <a class="navbar-brand" href="index.php">Art Store</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                        data-target="#bs-example-navbar-collapse-1">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>

            <div class="flex-grow-1 d-flex justify-content-between collapse navbar-collapse"
                 id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Contact</a></li>
                    <li class="nav-item dropdown">
                        <!--<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">-->
                        <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">Hot
                            Genre</a>
                        <!--</button>-->
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Realism</a></li>
                            <li><a class="dropdown-item" href="#">Expressionism</a></li>
                            <li><a class="dropdown-item" href="#">Romanticism</a></li>
                        </ul>
                    </li>
                </ul>


                <form class="navbar-form form-inline" id="form1" role="search" action="search.php">
                    <div class="form-group">
                        <input type="hidden" name="sel" value="view"> <?php if(!isset($_REQUEST['search'])){
                        ?>
                        <div class="form-check form-check-inline abc-checkbox abc-checkbox-info abc-checkbox-circle">
                            <input type="checkbox" class="form-check-input" name="search[]" value="title" checked>
                            <label class="form-check-label" for="search">名称</label>
                        </div>
                        <div class="form-check form-check-inline abc-checkbox abc-checkbox-info abc-checkbox-circle">
                            <input type="checkbox" class="form-check-input" name="search[]" value="description">
                            <label class="form-check-label" for="search">简介</label>
                        </div>
                        <div class="form-check form-check-inline abc-checkbox abc-checkbox-info abc-checkbox-circle">
                            <input type="checkbox" class="form-check-input" name="search[]" value="artist">
                            <label class="form-check-label" for="search">作者</label>
                        </div>
                        <?php
                        }else{
                                $search = $_REQUEST['search'];
                                if(in_array('title',$search)){
                                    echo "     <div class=\"form-check form-check-inline abc-checkbox abc-checkbox-info abc-checkbox-circle\">
                            <input type=\"checkbox\" class=\"form-check-input\" name=\"search[]\" value=\"title\" checked>
                            <label class=\"form-check-label\" for=\"search\">名称</label>
                        </div>";
                                }else{
                                    echo "     <div class=\"form-check form-check-inline abc-checkbox abc-checkbox-info abc-checkbox-circle\">
                            <input type=\"checkbox\" class=\"form-check-input\" name=\"search[]\" value=\"title\">
                            <label class=\"form-check-label\" for=\"search\">名称</label>
                        </div>";
                                }
                                if(in_array('description',$search)){
                                    echo " <div class=\"form-check form-check-inline abc-checkbox abc-checkbox-info abc-checkbox-circle\">
                            <input type=\"checkbox\" class=\"form-check-input\" name=\"search[]\" value=\"description\" checked>
                            <label class=\"form-check-label\" for=\"search\">简介</label>
                        </div>";
                                }else{
                                    echo " <div class=\"form-check form-check-inline abc-checkbox abc-checkbox-info abc-checkbox-circle\">
                            <input type=\"checkbox\" class=\"form-check-input\" name=\"search[]\" value=\"description\">
                            <label class=\"form-check-label\" for=\"search\">简介</label>
                        </div>";
                                }
                            if(in_array('artist',$search)){
                                echo " <div class=\"form-check form-check-inline abc-checkbox abc-checkbox-info abc-checkbox-circle\">
                            <input type=\"checkbox\" class=\"form-check-input\" name=\"search[]\" value=\"artist\" checked>
                            <label class=\"form-check-label\" for=\"search\">作者</label>
                        </div>";
                            }else{
                                    echo "  <div class=\"form-check form-check-inline abc-checkbox abc-checkbox-info abc-checkbox-circle\">
                            <input type=\"checkbox\" class=\"form-check-input\" name=\"search[]\" value=\"artist\">
                            <label class=\"form-check-label\" for=\"search\">作者</label>
                        </div>";
                            }
                        }?>

                        <input type="text" class="form-control" id="input_text" name="input_text" placeholder="Search" value="<?php if(isset($_REQUEST['input_text'])){echo $_REQUEST['input_text'];}?>">
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>

        <?php
        include 'registeAndLogin.php';
        ?>

    </nav>

</header>