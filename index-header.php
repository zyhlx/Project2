<?php
  session_start();
//放在公共文件的头
?>


<header class="row">
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark w-100">

        <div class="col-sm-2">
            <a href="index.html" class="navbar-brand">Art Store</a>
        </div>
        <div class="col-sm-5">
            <span class="navbar-text">Where you can find <em>GENIUS</em> and <em>EXTROORDINARY</em></span>
        </div>
        <div class="col-sm-5">
            <ul class="navbar-nav collapse navbar-collapse justify-content-end" id="collapsibleNavbar">

                <?php if( !isset($_POST['username']) ){
                if ( !isset($_SESSION['username']) ){

               ?>
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="search.php">Search</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="modal" data-target="#Register">Registe</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="modal" data-target="#Login">Login</a>
                </li>

                <?php
                }	else{
                    echo "    <li class=\"nav-item\">
                    <a class=\"nav-link\" href=\"index.php\">Home</a>
                </li>
                <li class=\"nav-item\">
                    <a class=\"nav-link\" href=\"search.php\">Search</a>
                </li>
                <li class=\"nav-item\">
                    <a class=\"nav-link\" href='user.php'>".$_SESSION['username']."</a>
                </li>
                <li class=\"nav-item\">
                    <a class=\"nav-link\" href=\"logout.php?action=logout\">Logout</a>
                </li>";
                }
                }else{

                    echo "    <li class=\"nav-item\">
                    <a class=\"nav-link\" href=\"index.php\">Home</a>
                </li>
                <li class=\"nav-item\">
                    <a class=\"nav-link\" href=\"search.php\">Search</a>
                </li>
                <li class=\"nav-item\">
                    <a class=\"nav-link\" href='user.php'>".$_SESSION['username']."</a>
                </li>
                <li class=\"nav-item\">
                    <a class=\"nav-link\" href=\"logout.php?action=logout\">Logout</a>
                </li>";
                }
                ?>

                <!--                <li class="nav-item">-->
                <!--                    <a class="nav-link" href="#">Link 3</a>-->
                <!--                </li>-->
            </ul>
        </div>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <?php
        include 'registeAndLogin.php';
        ?>

    </nav>
</header>