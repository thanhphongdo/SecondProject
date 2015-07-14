<?php
    session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Cửa hàng sách trực tuyến NHHP</title>
        <link type="text/css" rel="stylesheet" href="css/bootstrap.css" />
        <link type="text/css" rel="stylesheet" href="css/bootstrap-theme.css" />
        <link type="text/css" rel="stylesheet" href="css/style.css" />
        <link type="text/css" rel="stylesheet" href="css/slider.css" />
        <script src="js/js-image-slider-1.js" type="text/javascript"></script>
        <script src="js/js-image-slider-2.js" type="text/javascript"></script>
        
    </head>
    <?php
    require "login.php";
    require "./libs/db.php";
    $stmt = $dbh -> prepare("SELECT  * " .
                            "FROM    theloaisach " .
                            "WHERE   TheLoaiCha IS NULL");
    $stmt -> execute();
    ?>
    <body>        
        <div class="container page-width-limited">
            <div id="page-header"></div>   
            <nav class="navbar navbar-default">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="index.php">
                            Trang chủ
                            <span class="glyphicon glyphicon-home"/>
                        </a>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            Thể loại sách
                            <span class="glyphicon glyphicon-book" />
                        </a>
                        <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                            <?php
                            while ($row = $stmt -> fetch()) {
                                $tmpStmt = $dbh -> prepare("SELECT   * " .
                                                          "FROM     theloaisach " .
                                                          "WHERE    TheLoaiCha = " . $row["MaTheLoai"]);
                                $tmpStmt -> execute();
                            ?>
                            <li class="dropdown-submenu">
                                <a href="booklist.php?matheloai=<?php echo $row["MaTheLoai"]; ?>" tabindex="-1"><?php echo $row["TenTheLoai"]; ?></a>
                                <ul class="dropdown-menu">
                                    <?php
                                    while ($tmpRow = $tmpStmt->fetch()) {
                                    ?>
                                    <li><a href="booklist.php?matheloai=<?php echo $tmpRow["MaTheLoai"]; ?>" tabindex="-1"><?php echo $tmpRow["TenTheLoai"]; ?></a></li>
                                    <?php
                                    }
                                    ?>
                                </ul>
                            </li>
                            <?php
                            }
                            ?>
                        </ul>
                    </li>
                    <li>
                        <a href="giohang.php">
                            Giỏ hàng
                            <span class="glyphicon glyphicon-shopping-cart" />
                        </a>
                    </li>
                    <li>
                        <a href="lienhe.php">
                            Góp ý - Liên hệ
                            <span class="glyphicon glyphicon-comment"/>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            Hướng dẫn đặt hàng
                            <span class="glyphicon glyphicon-question-sign"/>
                        </a>
                    </li>
                </ul>
                <?php
                    if(empty($_SESSION['usernameKH'])){
                ?>
                <ul id="login" class="nav navbar-nav navbar-right">
                    <li>
                        <a href="signup.php" id="DangKy">
                            Đăng kí
                            <span class="glyphicon glyphicon-user" />
                        </a>
                    </li>
                    <li>
                        <a id="DangNhap">
                            Đăng nhập
                            <span class="glyphicon glyphicon-log-in" />
                        </a>
                    </li>
                </ul>
                <?php
                    }
                    else{
                ?>
                <ul class="nav navbar-nav navbar-right user">
                    <li>
                        <a href="#" class="dropdown-toggle" id="login-true" data-toggle="dropdown" data-login="true">
                        <span><?php echo ('Chào '.$_SESSION['tenKH'].'! ');?> 
                        <b class="glyphicon glyphicon-cog"></b></span></a> 
                        <ul class="dropdown-menu">
                            <li><a href="#">Đặt hàng</a></li>
                            <li><a href="lienhe.php">Góp ý</a></li>
                            <li><a href="thongtinkhachhang.php">Thông tin khách hàng</a></li>
                            <li><a href="hoadonkhachhang.php">Hóa đơn mua hàng</a></li>
                            <li class="divider"></li>
                            <li><a href="logout.php?logout=true">Thoát</a></li>
                        </ul>
                    </li>
                </ul>
                <?php
                    }
                ?>
            </nav>
        </div>
